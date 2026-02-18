<?php

namespace Diepxuan\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class ServeDevStop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:dev:stop';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Stop Laravel development server and Vite';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🛑 Stopping development servers...');

        $portalPidFile = storage_path('app/portal.pid');
        $vitePidFile = storage_path('app/vite.pid');

        // Stop Laravel server
        if (file_exists($portalPidFile)) {
            $pid = (int) file_get_contents($portalPidFile);
            if ($pid > 0) {
                Process::run("kill {$pid} 2>/dev/null");
                $this->info("✅ Laravel server stopped (PID: {$pid})");
            }
            unlink($portalPidFile);
        }

        // Stop Vite server
        if (file_exists($vitePidFile)) {
            $pid = (int) file_get_contents($vitePidFile);
            if ($pid > 0) {
                Process::run("kill {$pid} 2>/dev/null");
                $this->info("✅ Vite server stopped (PID: {$pid})");
            }
            unlink($vitePidFile);
        }

        // Kill any remaining processes
        Process::run('pkill -f "artisan serve" 2>/dev/null');
        Process::run('pkill -f "vite" 2>/dev/null');
        Process::run('pkill -f "npm run dev" 2>/dev/null');

        $this->info('✅ All development servers stopped');
        
        return 0;
    }
}