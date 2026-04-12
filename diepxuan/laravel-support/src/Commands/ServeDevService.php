<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-04-12 23:57:44
 */

namespace Diepxuan\Support\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Process;

class ServeDevService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serve:dev:service
        {action : install|uninstall|start|stop|restart|status|enable|disable}
        {--name=portal : Service name}
        {--user=root : Service user}
        {--group=root : Service group}
        {--interval=30 : Health check interval in seconds}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage systemd service for development servers';

    /**
     * Service template.
     *
     * CÁC LỖI SYSTEMD SERVICE ĐÃ SỬA - 2026-04-05:
     *
     * Vấn đề: Service không khởi động đúng cách, gây ra vòng lặp restart và tiến trình zombie.
     *
     * Nguyên nhân gốc rễ:
     * 1. Type=simple với lệnh daemonizing: Lệnh `serve:dev` spawn các tiến trình con
     *    (php artisan serve, npm run vite) và tiến trình chính thoát. Với Type=simple,
     *    systemd nghĩ service đã chết khi tiến trình chính thoát.
     *
     * 2. KillMode=process: Chỉ kill tiến trình chính, để lại các tiến trình con (node, vite,
     *    esbuild) chạy như zombie. Chúng tích lũy theo thời gian và gây xung đột cổng.
     *
     * 3. Health check ExecStartPost: Có thể gây xung đột transaction khi stopping/restarting
     *    vì systemd xếp hàng các jobs xung đột (stop health check vs stop main service).
     *
     * Giải pháp đã áp dụng:
     * 1. Type=forking: Bảo systemd mong đợi tiến trình chính fork và thoát, trong khi
     *    các tiến trình con tiếp tục chạy. Phù hợp với hành vi thực tế của lệnh serve:dev.
     *
     * 2. KillMode=control-group: Kill TẤT CẢ tiến trình trong cgroup, đảm bảo không có zombie.
     *
     * 3. Tích hợp flag --health: Health check giờ là một phần của lệnh chính, loại bỏ
     *    xung đột ExecStartPost.
     *
     * 4. TimeoutStopSec=60: Tăng timeout để shutdown êm ái cho tất cả tiến trình con.
     */
    protected $serviceTemplate = <<<'EOT'
        [Unit]
        Description=Portal Development Service (PHP + Vite)
        After=network.target
        Requires=network.target

        [Service]
        Type=forking
        User={user}
        Group={group}
        WorkingDirectory={working_dir}
        Environment="PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin"
        Environment="NODE_ENV=development"
        Environment="APP_ENV=local"

        # Main command - start serve:dev
        ExecStart=/usr/bin/php artisan serve:dev --foreground --health

        # Restart configuration
        Restart=always
        RestartSec=10
        StartLimitInterval=60
        StartLimitBurst=5

        # Health check

        # Logging
        StandardOutput=journal
        StandardError=journal
        SyslogIdentifier={service_name}

        # Process management
        KillMode=control-group
        KillSignal=SIGTERM
        TimeoutStopSec=60
        SendSIGKILL=yes

        [Install]
        WantedBy=multi-user.target
        EOT;

    /**
     * Timer template.
     */
    protected $timerTemplate = <<<'EOT'
        [Unit]
        Description={service_name} Health Check Timer
        Requires={service_name}.service
        After={service_name}.service

        [Timer]
        OnUnitActiveSec={interval}s
        OnBootSec=60s
        OnUnitInactiveSec={interval}s
        Persistent=true

        [Install]
        WantedBy=timers.target
        EOT;

    /**
     * Health service template.
     */
    protected $healthServiceTemplate = <<<'EOT'
        [Unit]
        Description={service_name} Health Check Service
        Requires={service_name}.service
        After={service_name}.service

        [Service]
        Type=oneshot
        User={user}
        Group={group}
        WorkingDirectory={working_dir}
        Environment="PATH=/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin"

        # Run health check
        ExecStart=/usr/bin/php artisan serve:dev:health --fix --log

        # Logging
        StandardOutput=journal
        StandardError=journal
        SyslogIdentifier={service_name}-health
        EOT;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action      = $this->argument('action');
        $serviceName = $this->option('name');

        $this->info("Development Service: {$serviceName}");

        switch ($action) {
            case 'install':
                return $this->installService();

            case 'uninstall':
                return $this->uninstallService();

            case 'start':
                return $this->startService();

            case 'stop':
                return $this->stopService();

            case 'restart':
                return $this->restartService();

            case 'status':
                return $this->statusService();

            case 'enable':
                return $this->enableService();

            case 'disable':
                return $this->disableService();

            default:
                $this->error("Unknown action: {$action}");
                $this->info('Available actions: install, uninstall, start, stop, restart, status, enable, disable');

                return 1;
        }
    }

    /**
     * Install systemd service.
     */
    protected function installService(): int
    {
        $serviceName = $this->option('name');
        $serviceDir  = '/etc/systemd/system';

        $this->info("Đang Installing {$serviceName} service...");

        // Check if running as root
        if (0 !== posix_getuid()) {
            $this->error('Lỗi: Please run as root (sudo)');

            return 1;
        }

        // Create service file
        $serviceContent = $this->renderTemplate($this->serviceTemplate);
        $serviceFile    = "{$serviceDir}/{$serviceName}.service";

        if (!file_put_contents($serviceFile, $serviceContent)) {
            $this->error("Lỗi: Failed to create service file: {$serviceFile}");

            return 1;
        }
        $this->info("Đã Service file created: {$serviceFile}");

        // Create health service file
        $healthServiceContent = $this->renderTemplate($this->healthServiceTemplate);
        $healthServiceFile    = "{$serviceDir}/{$serviceName}-health.service";

        if (!file_put_contents($healthServiceFile, $healthServiceContent)) {
            $this->error("Lỗi: Failed to create health service file: {$healthServiceFile}");

            return 1;
        }
        $this->info("Đã Health service file created: {$healthServiceFile}");

        // Create timer file
        $timerContent = $this->renderTemplate($this->timerTemplate);
        $timerFile    = "{$serviceDir}/{$serviceName}-health.timer";

        if (!file_put_contents($timerFile, $timerContent)) {
            $this->error("Lỗi: Failed to create timer file: {$timerFile}");

            return 1;
        }
        $this->info("Đã Timer file created: {$timerFile}");

        // Reload systemd
        $this->info('🔄 Reloading systemd...');
        Process::run('systemctl daemon-reload');

        // Enable services
        $this->info('⚙️ Enabling services...');
        Process::run("systemctl enable {$serviceName}.service");
        Process::run("systemctl enable {$serviceName}-health.timer");

        // Install docs:watch service
        $this->info('');
        $this->info('📚 Installing docs:watch service...');
        $this->installDocsWatchService();

        $this->info('');
        $this->info('Đã Service installed successfully!');
        $this->info('');
        $this->info('Quản lý: Management commands:');
        $this->info("   sudo systemctl start {$serviceName}.service");
        $this->info("   sudo systemctl stop {$serviceName}.service");
        $this->info("   sudo systemctl restart {$serviceName}.service");
        $this->info("   sudo systemctl status {$serviceName}.service");
        $this->info('');
        $this->info('🩺 Health check:');
        $this->info("   Runs every {$this->option('interval')} seconds");
        $this->info('   Logs: journalctl -u portal.service -f');
        $this->info('');
        $this->info('📚 Docs sync:');
        $this->info('   sudo systemctl status portal-docs-watch.service');
        $this->info('   journalctl -u portal-docs-watch.service -f');

        return 0;
    }

    /**
     * Uninstall systemd service.
     */
    protected function uninstallService(): int
    {
        $serviceName = $this->option('name');

        $this->info("🗑️ Uninstalling {$serviceName} service...");

        // Uninstall docs:watch service first
        $this->info('');
        $this->info('📚 Uninstalling docs:watch service...');
        $this->uninstallDocsWatchService();

        // Check if running as root
        if (0 !== posix_getuid()) {
            $this->error('Lỗi: Please run as root (sudo)');

            return 1;
        }

        // Stop services
        Process::run("systemctl stop {$serviceName}-health.timer 2>/dev/null || true");
        Process::run("systemctl stop {$serviceName}.service 2>/dev/null || true");

        // Disable services
        Process::run("systemctl disable {$serviceName}.service 2>/dev/null || true");
        Process::run("systemctl disable {$serviceName}-health.timer 2>/dev/null || true");

        // Remove files
        $serviceDir = '/etc/systemd/system';
        $files      = [
            "{$serviceDir}/{$serviceName}.service",
            "{$serviceDir}/{$serviceName}-health.service",
            "{$serviceDir}/{$serviceName}-health.timer",
        ];

        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
                $this->info("Đã Removed: {$file}");
            }
        }

        // Reload systemd
        Process::run('systemctl daemon-reload');
        Process::run('systemctl reset-failed');

        $this->info('Đã Service uninstalled successfully!');

        return 0;
    }

    /**
     * Install docs:watch service.
     */
    protected function installDocsWatchService(): void
    {
        // Call docs:watch --service command
        $result = $this->call('docs:watch', [
            '--service' => true,
        ]);

        if (0 === $result) {
            $this->info('✅ Docs:watch service installed');
        } else {
            $this->warn('⚠️  Docs:watch service installation failed (continuing anyway)');
        }
    }

    /**
     * Uninstall docs:watch service.
     */
    protected function uninstallDocsWatchService(): void
    {
        $serviceDir = '/etc/systemd/system';
        $files      = [
            "{$serviceDir}/portal-docs-watch.service",
        ];

        foreach ($files as $file) {
            if (file_exists($file)) {
                unlink($file);
                $this->info("Đã Removed: {$file}");
            }
        }

        // Stop and disable service
        Process::run('systemctl stop portal-docs-watch.service 2>/dev/null || true');
        Process::run('systemctl disable portal-docs-watch.service 2>/dev/null || true');

        $this->info('✅ Docs:watch service uninstalled');
    }

    /**
     * Start service.
     */
    protected function startService(): int
    {
        $serviceName = $this->option('name');

        $this->info("Khởi động: Starting {$serviceName} service...");

        $result = Process::run("systemctl start {$serviceName}.service");

        if ($result->successful()) {
            $this->info('Đã Service started');

            // Also start timer
            Process::run("systemctl start {$serviceName}-health.timer");
            $this->info('Đã Health timer started');

            return 0;
        }
        $this->error('Lỗi: Failed to start service: ' . $result->errorOutput());

        return 1;
    }

    /**
     * Stop service.
     */
    protected function stopService(): int
    {
        $serviceName = $this->option('name');

        $this->info("Dừng: Stopping {$serviceName} service...");

        $result = Process::run("systemctl stop {$serviceName}.service");

        if ($result->successful()) {
            $this->info('Đã Service stopped');

            // Also stop timer
            Process::run("systemctl stop {$serviceName}-health.timer");
            $this->info('Đã Health timer stopped');

            return 0;
        }
        $this->error('Lỗi: Failed to stop service: ' . $result->errorOutput());

        return 1;
    }

    /**
     * Restart service.
     */
    protected function restartService(): int
    {
        $serviceName = $this->option('name');

        $this->info("🔄 Restarting {$serviceName} service...");

        $result = Process::run("systemctl restart {$serviceName}.service");

        if ($result->successful()) {
            $this->info('Đã Service restarted');

            return 0;
        }
        $this->error('Lỗi: Failed to restart service: ' . $result->errorOutput());

        return 1;
    }

    /**
     * Check service status.
     */
    protected function statusService(): int
    {
        $serviceName = $this->option('name');

        $this->info("Trạng thái: {$serviceName} Service Status");
        $this->info('==============================');

        // Main service
        $this->info('');
        $this->info('🌐 Main Service:');
        $result = Process::run("systemctl status {$serviceName}.service --no-pager");
        $this->line($result->output());

        // Timer
        $this->info('');
        $this->info('🩺 Health Timer:');
        $result = Process::run("systemctl status {$serviceName}-health.timer --no-pager");
        $this->line($result->output());

        return 0;
    }

    /**
     * Enable service.
     */
    protected function enableService(): int
    {
        $serviceName = $this->option('name');

        $this->info("⚙️ Enabling {$serviceName} service...");

        $result = Process::run("systemctl enable {$serviceName}.service");

        if ($result->successful()) {
            $this->info('Đã Service enabled');

            // Also enable timer
            Process::run("systemctl enable {$serviceName}-health.timer");
            $this->info('Đã Health timer enabled');

            return 0;
        }
        $this->error('Lỗi: Failed to enable service: ' . $result->errorOutput());

        return 1;
    }

    /**
     * Disable service.
     */
    protected function disableService(): int
    {
        $serviceName = $this->option('name');

        $this->info("⚙️ Disabling {$serviceName} service...");

        $result = Process::run("systemctl disable {$serviceName}.service");

        if ($result->successful()) {
            $this->info('Đã Service disabled');

            // Also disable timer
            Process::run("systemctl disable {$serviceName}-health.timer");
            $this->info('Đã Health timer disabled');

            return 0;
        }
        $this->error('Lỗi: Failed to disable service: ' . $result->errorOutput());

        return 1;
    }

    /**
     * Render template with variables.
     */
    protected function renderTemplate(string $template): string
    {
        $variables = [
            '{service_name}' => $this->option('name'),
            '{user}'         => $this->option('user'),
            '{group}'        => $this->option('group'),
            '{working_dir}'  => base_path(),
            '{interval}'     => $this->option('interval'),
        ];

        return str_replace(array_keys($variables), array_values($variables), $template);
    }
}
