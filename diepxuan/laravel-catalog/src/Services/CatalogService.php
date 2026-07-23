<?php

declare(strict_types=1);

/*
 * @copyright  © 2019 Dxvn, Inc.
 *
 * @author     Tran Ngoc Duc <ductn@diepxuan.com>
 * @author     Tran Ngoc Duc <caothu91@gmail.com>
 *
 * @lastupdate 2026-07-11 14:35:01
 */

namespace Diepxuan\Catalog\Services;

use Diepxuan\Catalog\Config\TimerConfig;
use Diepxuan\Catalog\Models\Simba\SysCompany;
use Diepxuan\Catalog\Models\Simba\SysLanguage;
use Diepxuan\Catalog\Models\Simba\SysUserInfo;
use Diepxuan\Catalog\Models\User;
use Diepxuan\Simba\StoredProcedures\AsGLGetDMTK;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class CatalogService
{
    protected SysLanguage $sysLanguage;
    protected ?User $user = null;
    protected ?SysUserInfo $simbaUser = null;
    protected ?SysCompany $company = null;
    protected string $maNt;
    protected string $id;
    protected array $glDmTks = [];

    public function __construct()
    {
        $this->id = uniqid('report_');
        // \Log::info("ReportService instance đã được khởi tạo với ID: {$this->id}");
        // \Debugbar::info('ReportService instance đã được khởi tạo với ID: ' . $this->id);
    }

    public function user(): ?User
    {
        return $this->user ?? $this->user = Auth::user();
    }

    /**
     * Get Simba user. Returns null when user is not linked to a Simba account
     * (missing UserLink) or the Simba SQL Server is unreachable.
     */
    public function simbaUser(): ?SysUserInfo
    {
        if ($this->simbaUser !== null) {
            return $this->simbaUser;
        }

        $laravelUser = $this->user();
        if (! $laravelUser || ! $laravelUser->simbaLink) {
            return $this->simbaUser = null;
        }

        try {
            return $this->simbaUser = $laravelUser->getSimbaUser();
        } catch (\Throwable $e) {
            \Log::warning('CatalogService::simbaUser load failed', [
                'user_id' => $laravelUser->getKey(),
                'error'   => $e->getMessage(),
            ]);

            return $this->simbaUser = null;
        }
    }

    public function language()
    {
        return $this->sysLanguage ?? $this->sysLanguage = SysLanguage::current()->first();
    }

    /**
     * Returns null when user has no Simba company binding.
     */
    public function company(): ?SysCompany
    {
        if ($this->company) {
            return $this->company;
        }

        $companies = $this->companies();
        if ($companies->isEmpty()) {
            return $this->company = null;
        }

        $ma_cty = session('selected_company', '001');
        $this->company = $ma_cty
            ? $companies->firstWhere('ma_cty', $ma_cty)
            : $companies->first();

        if ($this->company) {
            session(['selected_company' => $this->company->ma_cty]);
        }

        return $this->company;
    }

    /**
     * Returns empty collection when user has no Simba link (dev / SSO-only flows).
     */
    public function companies(): Collection
    {
        $simbaUser = $this->simbaUser();

        return $simbaUser ? $simbaUser->companies : collect();
    }

    public function year(?int $year = null): int
    {
        if (!is_numeric($year) || $year < 2_006 || $year > 2_100) {
            $year = session('year', now()->year) ?? now()->year;
        }

        session(['year' => $year]);

        return $year;
    }

    /**
     * Legacy timer method for backward compatibility.
     *
     * @param null|array|string $time Timer settings
     *
     * @return array{id: string, from: string, to: string}
     */
    public function timer(array|string|null $time = null): array
    {
        $time = match (true) {
            \is_array($time) => $time,
            null === $time   => [],
            default          => ['id' => $time],
        };

        return TimerConfig::timer($time ?: null);
    }

    /**
     * Get timer from date.
     */
    public function timerFrom(): string
    {
        return $this->timer()['from'];
    }

    /**
     * Get timer to date.
     */
    public function timerTo(): string
    {
        return $this->timer()['to'];
    }

    public function ma_Nt()
    {
        return $this->maNt ?? $this->maNt = ($this->company()->siSetup->ma_nt0 ?? 'VND');
    }

    public function glDmTks(?string $pTk = null, ?string $pStruct = null): Collection
    {
        $company = $this->company();
        if (! $company) {
            return collect();
        }

        $maCty = $company->id;
        $key   = implode('|', [$maCty, $pStruct ?? '']);

        $this->glDmTks[$key] ??= AsGLGetDMTK::call([
            'pMa_cty' => $maCty,
            'pTk'     => null,
            'pStruct' => $pStruct,
        ]);

        return $this->glDmTks[$key]
            ->filter(static fn ($item) => null === $pTk || (string) $item->tk === $pTk)
            ->values();
    }
}
