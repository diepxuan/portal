<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-11-17
 */

namespace Diepxuan\TaskBoard\Services;

use Illuminate\Support\Collection;

/**
 * Đọc và cập nhật task từ các file markdown trong `docs/tasks/`.
 *
 * Không dùng database — nguồn dữ liệu là file .md trong repo, nên module chạy
 * được trên máy dev (không có kết nối DB trực tiếp).
 *
 * Cấu trúc thư mục:
 *   docs/tasks/*.md          → task phase hiện tại
 *   docs/tasks/phase 1/*.md  → task đã xong phase, tiếp tục hoàn thiện
 *
 * Metadata parse theo cùng quy ước `scripts/gen-tasks-index.php`:
 *   - ID     : `# Task {ID}:` dòng đầu, fallback prefix filename
 *   - Nhom   : `## Nhom: XX` hoặc prefix filename
 *   - Status : `**Status:** ...`
 *   - DLL    : `**DLL:** ...` / bảng `| **DLL** | ... |`
 */
class TaskRepository
{
    public const COLUMN_DONE        = 'done';
    public const COLUMN_IN_PROGRESS = 'in_progress';
    public const COLUMN_PENDING     = 'pending';
    public const COLUMN_OTHER       = 'other';

    /** Nhãn cột hiển thị trên Kanban. */
    public const COLUMN_LABELS = [
        self::COLUMN_PENDING     => 'Chờ làm',
        self::COLUMN_IN_PROGRESS => 'Đang làm',
        self::COLUMN_DONE        => 'Hoàn thành',
        self::COLUMN_OTHER       => 'Khác',
    ];

    public function __construct(protected string $tasksPath) {}

    public function tasksPath(): string
    {
        return $this->tasksPath;
    }

    /**
     * Toàn bộ task trong tất cả phase.
     *
     * @return Collection<int, array<string, mixed>>
     */
    public function all(): Collection
    {
        $rows = collect();

        // Thứ tự thư mục quyết định độ ưu tiên khi trùng ID: phase 1 thắng root
        // (phase 1 là bản mới nhất/đầy đủ nhất). Xem merge task 360.
        foreach (array_reverse($this->phaseDirectories(), true) as $phase => $dir) {
            foreach ($this->markdownFiles($dir) as $path) {
                $task = $this->parse($path, $phase);

                if ($task !== null) {
                    $rows->push($task);
                }
            }
        }

        // Dedupe theo ID (đã chuẩn hóa): giữ bản đầu tiên gặp — tức phase 1.
        $rows = $rows->unique(static fn (array $t): string => $t['id'] !== '' ? $t['id'] : $t['phase'] . '|' . $t['file']);

        return $rows->sortBy(static fn (array $t): array => $t['sort_key'])->values();
    }

    /**
     * Các ID bị trùng giữa nhiều file (dùng để cảnh báo/kiểm tra dữ liệu).
     *
     * @return array<string, array<int, string>>
     */
    public function duplicateIds(): array
    {
        $byId = [];

        foreach ($this->phaseDirectories() as $phase => $dir) {
            foreach ($this->markdownFiles($dir) as $path) {
                $task = $this->parse($path, $phase);

                if ($task !== null && $task['id'] !== '') {
                    $byId[$task['id']][] = $task['relative_path'];
                }
            }
        }

        return array_filter($byId, static fn (array $files): bool => \count($files) > 1);
    }

    /**
     * Nội dung mô tả của một nhóm (đọc từ `_index.md` trong thư mục).
     *
     * Dùng để hiển thị mô tả "Portal Task" / "Phase 1" trên board.
     */
    public function groupDescription(string $group): string
    {
        $dir = match ($group) {
            'portaltask' => $this->tasksPath . '/portaltask',
            'phase 1'    => $this->tasksPath . '/phase 1',
            default      => $this->tasksPath,
        };

        $index = $dir . '/_index.md';

        if (! is_file($index)) {
            return '';
        }

        $content = (string) file_get_contents($index);

        return trim((string) preg_replace('/^#\s+[^\n]*\n+/u', '', $content, 1));
    }

    /**
     * Một task theo ID.
     *
     * @return null|array<string, mixed>
     */
    public function find(string $id): ?array
    {
        return $this->all()->firstWhere('id', $id);
    }

    /**
     * Thống kê theo cột + module + phase.
     *
     * @return array{columns: array<string,int>, modules: array<string,int>, phases: array<string,int>, total: int, checklists: array{done:int,total:int}}
     */
    public function stats(?Collection $tasks = null): array
    {
        $tasks ??= $this->all();

        $columns = array_fill_keys(array_keys(self::COLUMN_LABELS), 0);
        $checkDone = 0;
        $checkTotal = 0;

        foreach ($tasks as $task) {
            $columns[$task['column']] = ($columns[$task['column']] ?? 0) + 1;
            $checkDone  += (int) $task['check_done'];
            $checkTotal += (int) $task['check_total'];
        }

        return [
            'columns'    => $columns,
            'modules'    => $tasks->groupBy('module')->map(static fn (Collection $g): int => $g->count())->all(),
            'phases'     => $tasks->groupBy('phase')->map(static fn (Collection $g): int => $g->count())->all(),
            'total'      => $tasks->count(),
            'checklists' => ['done' => $checkDone, 'total' => $checkTotal],
        ];
    }

    /**
     * Danh sách phase có trong dữ liệu.
     *
     * @return array<int, string>
     */
    public function phases(): array
    {
        return array_keys($this->phaseDirectories());
    }

    /**
     * Cập nhật status của task vào file .md.
     *
     * Ghi đè dòng `**Status:**` đầu tiên; nếu chưa có thì chèn ngay sau heading
     * cấp 1. Trả về false khi không cho phép ghi hoặc không tìm thấy task.
     */
    public function updateStatus(string $id, string $status): bool
    {
        if (! config('taskboard.writable', false)) {
            return false;
        }

        $task = $this->find($id);

        if ($task === null) {
            return false;
        }

        $path = (string) $task['path'];
        $content = (string) file_get_contents($path);

        $line = '**Status:** ' . trim($status);

        if (preg_match('/\*\*Status:\*\*[^\n]*/u', $content)) {
            $content = (string) preg_replace('/\*\*Status:\*\*[^\n]*/u', $line, $content, 1);
        } elseif (preg_match('/^(#[^\n]*\n)/mu', $content, $m)) {
            $content = str_replace($m[1], $m[1] . "\n" . $line . "\n", $content);
        } else {
            $content = $line . "\n\n" . $content;
        }

        return file_put_contents($path, $content) !== false;
    }

    /**
     * Toggle một checklist item `- [ ]` ↔ `- [x]` theo chỉ số dòng.
     */
    public function toggleChecklist(string $id, int $lineNumber): bool
    {
        if (! config('taskboard.writable', false)) {
            return false;
        }

        $task = $this->find($id);

        if ($task === null) {
            return false;
        }

        $path = (string) $task['path'];
        $lines = file($path, FILE_IGNORE_NEW_LINES);

        if ($lines === false || ! isset($lines[$lineNumber])) {
            return false;
        }

        $line = $lines[$lineNumber];

        if (preg_match('/^(\s*-\s+\[)([ xX])(\]\s+.*)$/u', $line, $m)) {
            $next = $m[2] === ' ' ? 'x' : ' ';
            $lines[$lineNumber] = $m[1] . $next . $m[3];
        } else {
            return false;
        }

        return file_put_contents($path, implode("\n", $lines) . "\n") !== false;
    }

    /**
     * Suy ra cột Kanban từ status tự do.
     *
     * Status trong repo rất đa dạng ("DONE (route shell)", "✅ DONE — merged PR #277",
     * "🔄 CẦN MAP", "IN PROGRESS (...)"), nên match theo từ khóa.
     */
    public function resolveColumn(string $status): string
    {
        $s = mb_strtoupper(trim($status));

        if ($s === '') {
            return self::COLUMN_PENDING;
        }

        // Marker loại trừ trước — chúng có thể chứa cả chữ DONE.
        if (str_contains($s, 'NOT A TASK') || str_contains($s, 'DOCUMENTATION ONLY') || str_contains($s, '📄')) {
            return self::COLUMN_OTHER;
        }

        // SHELL_ONLY = có route anchor/metadata shell nhưng CHƯA có màn hình CRUD.
        // Không được xếp vào Hoàn thành dù chuỗi có thể chứa "DONE".
        // Bắt cả các biến thể cũ: "DONE (route shell)", "DONE (route/shell exists)",
        // "DONE (task shell route)", "DONE (read-only report)".
        if (str_contains($s, 'SHELL_ONLY') || str_contains($s, 'SHELL ONLY')
            || str_contains($s, 'ROUTE SHELL') || str_contains($s, 'ROUTE/SHELL')
            || str_contains($s, 'TASK SHELL') || str_contains($s, 'SHELL EXISTS')
            || str_contains($s, 'READ-ONLY REPORT')) {
            return self::COLUMN_PENDING;
        }

        if (str_contains($s, 'IN PROGRESS') || str_contains($s, 'IN-PROGRESS') || str_contains($s, 'IMPLEMENTED')
            || str_contains($s, 'CẦN MAP') || str_contains($s, '🔄')) {
            return self::COLUMN_IN_PROGRESS;
        }

        if (str_contains($s, 'PENDING') || str_contains($s, 'TODO') || str_contains($s, '❌') || str_contains($s, 'CHƯA')) {
            return self::COLUMN_PENDING;
        }

        if (str_contains($s, 'DONE') || str_contains($s, 'MERGED') || str_contains($s, '✅')) {
            return self::COLUMN_DONE;
        }

        return self::COLUMN_PENDING;
    }

    /**
     * Parse một task doc thành mảng.
     *
     * @return null|array<string, mixed>
     */
    public function parse(string $path, string $phase = 'root'): ?array
    {
        if (! is_file($path)) {
            return null;
        }

        $content = (string) file_get_contents($path);
        $file = basename($path);

        [$id, $title] = $this->parseIdentity($content, $file);
        $status = $this->parseStatus($content);

        $checkDone = preg_match_all('/^\s*-\s+\[[xX]\]\s+/mu', $content);
        $checkOpen = preg_match_all('/^\s*-\s+\[\s\]\s+/mu', $content);
        $checkTotal = $checkDone + $checkOpen;

        return [
            'id'            => $id,
            'title'         => $title,
            'file'          => $file,
            'path'          => $path,
            'relative_path' => $this->relativePath($path),
            'phase'         => $phase,
            'module'        => $this->parseModule($content, $file),
            'dll'           => $this->parseDll($content),
            'status_raw'    => $status,
            'column'        => $this->resolveColumn($status),
            'check_done'    => $checkDone,
            'check_total'   => $checkTotal,
            'progress'      => $checkTotal > 0 ? (int) round($checkDone * 100 / $checkTotal) : null,
            'checklist'     => $this->parseChecklist($content),
            'sort_key'      => $this->sortKey($id, $file),
        ];
    }

    /**
     * Danh sách checklist để render trong panel chi tiết.
     *
     * @return array<int, array{line:int, done:bool, text:string}>
     */
    public function parseChecklist(string $content): array
    {
        $items = [];
        $lines = explode("\n", $content);

        foreach ($lines as $i => $line) {
            if (preg_match('/^(\s*)-\s+\[([ xX])\]\s+(.+)$/u', $line, $m)) {
                $items[] = [
                    'line' => $i,
                    'done' => mb_strtolower($m[2]) === 'x',
                    'text' => trim($m[3]),
                ];
            }
        }

        return $items;
    }

    /**
     * @return array{0:string, 1:string}
     */
    protected function parseIdentity(string $content, string $file): array
    {
        // SimbaERP task: "# Task 197: ..."
        if (preg_match('/^#\s+Task\s+(\d+(?:-\d+)?):\s*(.+)$/mu', $content, $m)) {
            return [$m[1], trim($m[2])];
        }

        // Portal task: "# Portal Task P001: ..."
        if (preg_match('/^#\s+Portal\s+Task\s+(P\d+):\s*(.+)$/mu', $content, $m)) {
            return [$m[1], trim($m[2])];
        }

        // Frontmatter ID (cac file meta cu)
        if (preg_match('/^---\n.*?^ID:\s*(P?\d+(?:-\d+)?)\s*$/msu', $content, $fm)) {
            $id = $fm[1];
            $title = preg_match('/^#\s+(.+)$/mu', $content, $tm) ? trim($tm[1]) : pathinfo($file, PATHINFO_FILENAME);

            return [$id, $title];
        }

        $id = preg_match('/^(P?\d+(?:-\d+)?)-/', $file, $fm2) ? $fm2[1] : '';

        if (preg_match('/^#\s+(.+)$/mu', $content, $m)) {
            return [$id, trim($m[1])];
        }

        return [$id, pathinfo($file, PATHINFO_FILENAME)];
    }

    protected function parseStatus(string $content): string
    {
        if (preg_match('/^[-*]\s+\*\*Status:\*\*\s*([^\n]+)/mu', $content, $m)) {
            return trim($m[1]);
        }

        if (preg_match('/\*\*Status:\*\*\s*([^\n]+)/u', $content, $m)) {
            return trim($m[1]);
        }

        return '';
    }

    protected function parseModule(string $content, string $file): string
    {
        if (preg_match('/^##\s+Nh[oó]m:\s+(\w+)/mu', $content, $m)) {
            $module = mb_strtoupper($m[1]);

            return $module === 'SYSTEM' ? 'SYS' : $module;
        }

        if (preg_match('/^\|\s*\*\*Module\*\*\s*\|\s*([A-Z]{2,6})\b/mu', $content, $m)) {
            $module = mb_strtoupper($m[1]);

            return $module === 'SYSTEM' ? 'SYS' : $module;
        }

        // Portal task -> module riêng
        if (str_starts_with($file, 'P') && preg_match('/^P\d+-/', mb_strtoupper($file))) {
            return 'PORTAL';
        }

        $stripped = preg_replace('/^P?\d+(?:-\d+)?-/', '', mb_strtoupper($file)) ?? '';

        foreach (['AR', 'AP', 'CA', 'CO', 'SO', 'PO', 'SI', 'IN', 'FA', 'GL'] as $prefix) {
            if (str_starts_with($stripped, $prefix . '-') || str_starts_with($stripped, $prefix . '_')) {
                return $prefix;
            }
        }

        if (str_contains($stripped, 'BAN-HANG')) {
            return 'SO';
        }

        foreach (['SIMBA-LOGIN', 'ADMIN-DASHBOARD', 'DEVELOPER-SUPPORT', 'TONG-HOP', 'HANG-TON-KHO', 'SYSTEM'] as $needle) {
            if (str_contains($stripped, $needle)) {
                return 'SYS';
            }
        }

        return 'KHÁC';
    }

    protected function parseDll(string $content): string
    {
        if (preg_match('/^\|\s*\*\*DLL\*\*\s*\|\s*([^|]+?)\s*\|/miu', $content, $m)) {
            return trim($m[1]);
        }

        if (preg_match('/\*\*[^*\n]*DLL[^*\n]*:\*\*\s*(.+)$/miu', $content, $m)) {
            return trim($m[1]);
        }

        return '';
    }

    /**
     * @return array<string, string> phase label => absolute path
     */
    protected function phaseDirectories(): array
    {
        $dirs = [];

        if (is_dir($this->tasksPath)) {
            $dirs['root'] = $this->tasksPath;

            $phase1 = $this->tasksPath . '/phase 1';

            if (is_dir($phase1)) {
                $dirs['phase 1'] = $phase1;
            }

            $portal = $this->tasksPath . '/portaltask';

            if (is_dir($portal)) {
                $dirs['portaltask'] = $portal;
            }
        }

        return $dirs;
    }

    /**
     * @return array<int, string>
     */
    protected function markdownFiles(string $dir): array
    {
        $files = [];

        foreach (scandir($dir) ?: [] as $entry) {
            if ($entry === '.' || $entry === '..' || $entry[0] === '.' || ! str_ends_with($entry, '.md')) {
                continue;
            }

            // Bo qua file he thong: README va moi file bat dau bang '_'
            // (_index.md, _reports-inventory.md, _modules/... ).
            if ($entry === 'README.md' || str_starts_with($entry, '_')) {
                continue;
            }

            $files[] = $dir . '/' . $entry;
        }

        sort($files);

        return $files;
    }

    protected function relativePath(string $path): string
    {
        $base = base_path() . '/';

        return str_starts_with($path, $base) ? substr($path, \strlen($base)) : $path;
    }

    /**
     * @return array{0:int, 1:int, 2:string}
     */
    protected function sortKey(string $id, string $file): array
    {
        // Portal task: xep theo so sau P (P001, P002, ...)
        if (preg_match('/^P(\d+)$/', $id, $m)) {
            return [-1, (int) $m[1], $file];
        }

        if (preg_match('/^(\d+)(?:-(\d+))?$/', $id, $m)) {
            return [(int) $m[1], isset($m[2]) ? (int) $m[2] : (int) $m[1], $file];
        }

        return [PHP_INT_MAX, PHP_INT_MAX, $file];
    }
}
