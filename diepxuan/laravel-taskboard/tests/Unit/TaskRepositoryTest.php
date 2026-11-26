<?php

declare(strict_types=1);

namespace Diepxuan\TaskBoard\Tests\Unit;

use Diepxuan\TaskBoard\Services\TaskRepository;
use Tests\TestCase;

/**
 * Unit test cho TaskRepository — parse task docs.
 *
 * Dùng thư mục fixture tạm, KHÔNG chạm DB.
 */
final class TaskRepositoryTest extends TestCase
{
    private string $fixtureDir;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fixtureDir = sys_get_temp_dir() . '/taskboard-test-' . uniqid('', true);
        mkdir($this->fixtureDir, 0777, true);
        mkdir($this->fixtureDir . '/phase 1', 0777, true);
    }

    protected function tearDown(): void
    {
        foreach (glob($this->fixtureDir . '/*/*') ?: [] as $f) {
            @unlink($f);
        }
        foreach (glob($this->fixtureDir . '/*') ?: [] as $f) {
            is_file($f) ? @unlink($f) : @rmdir($f);
        }
        @rmdir($this->fixtureDir);

        parent::tearDown();
    }

    private function repo(): TaskRepository
    {
        return new TaskRepository($this->fixtureDir);
    }

    private function write(string $relative, string $content): void
    {
        file_put_contents($this->fixtureDir . '/' . $relative, $content);
    }

    public function testParseExtractsIdentityModuleStatusDll(): void
    {
        $this->write('197-so-hoa-don.md', <<<'MD'
            # Task 197: SO-Hoa-Don-Ban-Hang

            ## Nhom: SO (Sales Order)

            - **DLL:** SOVchSO3.dll
            - **Status:** ✅ DONE — đã merge vào main
            MD);

        $task = $this->repo()->find('197');

        self::assertNotNull($task);
        self::assertSame('197', $task['id']);
        self::assertSame('SO-Hoa-Don-Ban-Hang', $task['title']);
        self::assertSame('SO', $task['module']);
        self::assertSame('SOVchSO3.dll', $task['dll']);
        self::assertSame('done', $task['column']);
        self::assertSame('root', $task['phase']);
    }

    public function testModuleFallsBackToFilenamePrefix(): void
    {
        $this->write('008-ar-bao-cao.md', "# Task 008: Bao cao\n\n- **Status:** PENDING\n");

        self::assertSame('AR', $this->repo()->find('008')['module']);
    }

    public function testTitleFallsBackToFirstHeading(): void
    {
        $this->write('999-custom.md', "# Custom Task Title\n\nNo Task prefix here.\n");

        $task = $this->repo()->find('999');

        self::assertSame('Custom Task Title', $task['title']);
    }

    /**
     * @dataProvider columnProvider
     */
    public function testResolveColumnFromFreeFormStatus(string $status, string $expected): void
    {
        self::assertSame($expected, (new TaskRepository('/tmp'))->resolveColumn($status));
    }

    public static function columnProvider(): array
    {
        return [
            'done plain'          => ['DONE', TaskRepository::COLUMN_DONE],
            // Route shell KHONG phai DONE: co anchor nhung chua co man hinh CRUD.
            'route shell only'    => ['DONE (route shell)', TaskRepository::COLUMN_PENDING],
            'explicit shell only' => ['SHELL_ONLY — route khong ton tai', TaskRepository::COLUMN_PENDING],
            'shell only variant'  => ['SHELL ONLY (metadata)', TaskRepository::COLUMN_PENDING],
            'done emoji merged'   => ['✅ DONE — merged PR #277', TaskRepository::COLUMN_DONE],
            'merged keyword'      => ['DONE — merged PR #244', TaskRepository::COLUMN_DONE],
            'in progress'         => ['IN PROGRESS (Livewire component)', TaskRepository::COLUMN_IN_PROGRESS],
            'can map'             => ['🔄 CẦN MAP — route hiện có', TaskRepository::COLUMN_IN_PROGRESS],
            'implemented'         => ['IMPLEMENTED locally (CRUD UI)', TaskRepository::COLUMN_IN_PROGRESS],
            'pending'             => ['❌ PENDING — chưa implement', TaskRepository::COLUMN_PENDING],
            'empty status'        => ['', TaskRepository::COLUMN_PENDING],
            'doc only'            => ['📄 DOCUMENTATION ONLY — ghi chú', TaskRepository::COLUMN_OTHER],
            'not a task'          => ['NOT A TASK (meta/doc file, skipped)', TaskRepository::COLUMN_OTHER],
        ];
    }

    public function testChecklistProgressIsParsed(): void
    {
        $this->write('360-test.md', <<<'MD'
            # Task 360: Test

            - **Status:** DONE

            - [x] Viec 1
            - [x] Viec 2
            - [ ] Viec 3
            - [ ] Viec 4
            MD);

        $task = $this->repo()->find('360');

        self::assertSame(2, $task['check_done']);
        self::assertSame(4, $task['check_total']);
        self::assertSame(50, $task['progress']);
        self::assertCount(4, $task['checklist']);
    }

    public function testPhaseDirectoriesAreDiscovered(): void
    {
        $this->write('001-root.md', "# Task 001: Root task\n\n- **Status:** DONE\n");
        $this->write('phase 1/002-phase.md', "# Task 002: Phase task\n\n- **Status:** DONE\n");

        $all = $this->repo()->all();

        self::assertCount(2, $all);
        self::assertSame('root', $all->firstWhere('id', '001')['phase']);
        self::assertSame('phase 1', $all->firstWhere('id', '002')['phase']);
        self::assertSame(['root', 'phase 1'], $this->repo()->phases());
    }

    public function testReadmeAndIndexFilesAreSkipped(): void
    {
        $this->write('README.md', "# Readme\n");
        $this->write('_index.md', "# Index\n");
        $this->write('001-real.md', "# Task 001: Real\n\n- **Status:** DONE\n");

        self::assertCount(1, $this->repo()->all());
    }

    public function testStatsCountByColumnModuleAndChecklist(): void
    {
        $this->write('001-a.md', "# Task 001: A\n\n## Nhom: SO\n\n- **Status:** DONE\n\n- [x] done\n- [ ] open\n");
        $this->write('002-b.md', "# Task 002: B\n\n## Nhom: SO\n\n- **Status:** PENDING\n");
        $this->write('003-c.md', "# Task 003: C\n\n## Nhom: AR\n\n- **Status:** IN PROGRESS\n");

        $stats = $this->repo()->stats();

        self::assertSame(3, $stats['total']);
        self::assertSame(1, $stats['columns'][TaskRepository::COLUMN_DONE]);
        self::assertSame(1, $stats['columns'][TaskRepository::COLUMN_PENDING]);
        self::assertSame(1, $stats['columns'][TaskRepository::COLUMN_IN_PROGRESS]);
        self::assertSame(2, $stats['modules']['SO']);
        self::assertSame(1, $stats['modules']['AR']);
        self::assertSame(['done' => 1, 'total' => 2], $stats['checklists']);
    }

    public function testSortKeyOrdersNumericIdsAscending(): void
    {
        $this->write('010-c.md', "# Task 010: C\n\n- **Status:** DONE\n");
        $this->write('002-a.md', "# Task 002: A\n\n- **Status:** DONE\n");
        $this->write('100-b.md', "# Task 100: B\n\n- **Status:** DONE\n");

        $ids = $this->repo()->all()->pluck('id')->all();

        self::assertSame(['002', '010', '100'], $ids);
    }

    public function testUpdateStatusRefusesWhenNotWritable(): void
    {
        $this->write('001-a.md', "# Task 001: A\n\n- **Status:** PENDING\n");

        config(['taskboard.writable' => false]);

        self::assertFalse($this->repo()->updateStatus('001', 'DONE'));
        self::assertStringContainsString('PENDING', (string) file_get_contents($this->fixtureDir . '/001-a.md'));
    }

    public function testUpdateStatusWritesWhenWritable(): void
    {
        $this->write('001-a.md', "# Task 001: A\n\n- **Status:** PENDING\n");

        config(['taskboard.writable' => true]);

        self::assertTrue($this->repo()->updateStatus('001', 'DONE'));
        self::assertStringContainsString('**Status:** DONE', (string) file_get_contents($this->fixtureDir . '/001-a.md'));
    }

    public function testMissingTasksDirectoryYieldsEmptyCollection(): void
    {
        $repo = new TaskRepository($this->fixtureDir . '/khong-ton-tai');

        self::assertCount(0, $repo->all());
        self::assertSame([], $repo->phases());
    }
}
