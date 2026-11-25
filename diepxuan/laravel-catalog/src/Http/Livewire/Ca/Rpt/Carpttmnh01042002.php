<?php

declare(strict_types=1);

namespace Diepxuan\Catalog\Http\Livewire\Ca\Rpt;

use Diepxuan\Catalog\Http\Livewire\Rpt\AbstractReport;
use Diepxuan\Simba\StoredProcedures\AsCARptTMNH01;
use Illuminate\Contracts\View\View;

/**
 * Sổ quỹ tiền mặt (CARptTMNH01).
 *
 * 5 tham số: pMa_Cty, pTk, pNgay1, pNgay2, pMaNt.
 */
class Carpttmnh01042002 extends AbstractReport
{
    public string $pTk = '';

    public ?string $pNgay1 = null;

    public ?string $pNgay2 = null;

    public string $pMa_Nt = 'VND';

    protected function spClass(): string
    {
        return AsCARptTMNH01::class;
    }

    /**
     * @return array<string,mixed>
     */
    public function procedurePayload(): array
    {
        return [
            'pMa_Cty' => (string) \CatalogService::company()->id,
            'pTk' => trim($this->pTk),
            'pNgay1' => $this->pNgay1,
            'pNgay2' => $this->pNgay2,
            'pMaNt' => trim($this->pMa_Nt),
        ];
    }

    public function render(): View
    {
        return view('catalog::ca.rpt.carpttmnh01042002', [
            'rows' => $this->rows,
            'columns' => $this->columns,
        ]);
    }
}
