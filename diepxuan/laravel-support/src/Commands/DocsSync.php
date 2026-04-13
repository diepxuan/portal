<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-04-13 17:40:39
 */

namespace Diepxuan\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

/**
 * Sync docs từ SimbaSql → Portal.
 *
 * Sử dụng: php artisan docs:sync
 */
class DocsSync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'docs:sync
        {--source=/root/.openclaw/workspace/projects/SimbaSql/docs : Source directory}
        {--dest=/root/.openclaw/workspace/projects/portal/diepxuan/laravel-simba/docs : Destination directory}
        {--dry-run : Show what would be copied without actually copying}
        {--delete : Delete files in dest not in source}
        {--debug : Show detailed output}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync documentation from SimbaSql to Portal';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $source  = $this->option('source');
        $dest    = $this->option('dest');
        $dryRun  = $this->option('dry-run');
        $delete  = $this->option('delete');
        $verbose = $this->option('debug');

        $this->info('📚 Documentation Sync');
        $this->info('=====================');

        // Validate source directory
        if (!is_dir($source)) {
            $this->error("Lỗi: Source directory not found: {$source}");

            return 1;
        }

        // Create destination if not exists
        if (!is_dir($dest)) {
            if ($dryRun) {
                $this->info("[DRY-RUN] Would create: {$dest}");
            } else {
                $this->info("Creating destination directory: {$dest}");
                mkdir($dest, 0755, true);
            }
        }

        $this->info('');
        $this->info("Source:      {$source}");
        $this->info("Destination: {$dest}");
        $this->info('Dry-run:     ' . ($dryRun ? 'Yes' : 'No'));
        $this->info('Delete:      ' . ($delete ? 'Yes' : 'No'));
        $this->info('');

        // Sync files
        $stats = $this->syncFiles($source, $dest, $dryRun, $delete, $verbose);

        // Summary
        $this->info('');
        $this->info('✅ Sync Complete');
        $this->info('================');
        $this->info("Copied:  {$stats['copied']} files");
        $this->info("Skipped: {$stats['skipped']} files");
        $this->info("Deleted: {$stats['deleted']} files");
        $this->info("Errors:  {$stats['errors']} files");

        return $stats['errors'] > 0 ? 1 : 0;
    }

    /**
     * Sync files from source to destination.
     */
    protected function syncFiles(string $source, string $dest, bool $dryRun, bool $delete, bool $verbose): array
    {
        $stats = [
            'copied'  => 0,
            'skipped' => 0,
            'deleted' => 0,
            'errors'  => 0,
        ];

        // Use rsync for efficient sync
        $rsyncCmd = 'rsync -av --progress';

        if ($dryRun) {
            $rsyncCmd .= ' --dry-run';
        }

        if ($delete) {
            $rsyncCmd .= ' --delete';
        }

        if ($verbose) {
            $rsyncCmd .= ' --verbose';
        } else {
            $rsyncCmd .= ' --quiet';
        }

        $rsyncCmd .= " {$source}/ {$dest}/";

        $this->info('Running rsync...');
        if ($verbose) {
            $this->line("Command: {$rsyncCmd}");
        }

        $result = Process::run("PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin {$rsyncCmd}");

        if ($result->successful()) {
            // Parse rsync output for stats
            $output = $result->output();

            // Count copied files (lines with "=>")
            if (str_contains($output, '=>')) {
                $stats['copied'] = substr_count($output, '=>');
            }

            // Count deleted files
            if (str_contains($output, 'deleting ')) {
                $stats['deleted'] = substr_count($output, 'deleting ');
            }
        } else {
            $this->error('rsync failed: ' . $result->errorOutput());
            ++$stats['errors'];

            // Fallback to cp command
            $this->warn('Falling back to cp command...');
            $this->syncWithCp($source, $dest, $dryRun, $delete, $verbose, $stats);
        }

        return $stats;
    }

    /**
     * Fallback sync using cp command.
     */
    protected function syncWithCp(string $source, string $dest, bool $dryRun, bool $delete, bool $verbose, array &$stats): void
    {
        if ($dryRun) {
            $this->info("[DRY-RUN] cp -r {$source}/ {$dest}/");

            return;
        }

        // Copy all files
        $cpCmd  = "cp -r {$source}/ {$dest}/";
        $result = Process::run($cpCmd);

        if ($result->successful()) {
            ++$stats['copied'];
            $this->info('Copied all files successfully');
        } else {
            ++$stats['errors'];
            $this->error('cp failed: ' . $result->errorOutput());
        }

        // Delete extra files if requested
        if ($delete) {
            $this->deleteExtraFiles($source, $dest, $stats);
        }
    }

    /**
     * Delete files in destination not in source.
     */
    protected function deleteExtraFiles(string $source, string $dest, array &$stats): void
    {
        $sourceFiles = $this->getFiles($source);
        $destFiles   = $this->getFiles($dest);

        $extraFiles = array_diff($destFiles, $sourceFiles);

        foreach ($extraFiles as $file) {
            $filePath = $dest . '/' . $file;
            if (file_exists($filePath)) {
                unlink($filePath);
                ++$stats['deleted'];
                $this->info("Deleted: {$file}");
            }
        }
    }

    /**
     * Get list of files in directory.
     *
     * @return array<string>
     */
    protected function getFiles(string $dir): array
    {
        $files    = [];
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $relativePath = str_replace($dir . '/', '', $file->getPathname());
                $files[]      = $relativePath;
            }
        }

        return $files;
    }
}
