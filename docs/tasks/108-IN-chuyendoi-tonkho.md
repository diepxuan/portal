# Task 108: INTransferINCDVT

## Nhom: IN (Inventory - Ton kho)

## Muc tieu
Chuyen doi chuc nang chuyen du lieu ton kho sang nam sau tu .NET sang PHP Laravel.

## Chi tiet
- **DLL:** INTransferINCDVT.dll
- **Chuc nang:** Chuyen doi du lieu ton kho (chuyen ton sang nam sau)
- **Loai:** Transfer (Chuyen doi)
- **Assembly Title:** Chuyen toi ton kho sang nam sau
- **Version:** 1.0.0.0
- **Namespace:** `AsiaERP.UserInterface`
- **Company:** ASIASOFT
- **Ma_ct:** IN (transfer)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/INTransferINCDVT.dll/README.md`

---

## Form classes

### frmINTransferINCDVT (Form chuyen doi)
- **Ke thua:** frmCalc
- **Chuc nang:** Chuyen so ton kho cuoi nam sang nam tai chinh moi

### Controls chinh

| Control | Type | Mo ta |
|---------|------|-------|
| lblSure | Label | Canh bao xac nhan (mau do) |
| txtMa_kho | AsTextBox | Chon ma kho (AutoLookup MA_KHO) |
| lblTen_kho | Label | Hien thi ten kho |
| lblFinal_day | Label | Ngay cuoi nam |
| txtFinal_day | AsMaskedTextBox | Ngay cuoi nam (readonly) |
| txtMa_so | TextBox | Ma so xac nhan (random) |
| txtConfirm | TextBox | Nhap lai ma so xac nhan |
| bgWorker | BackgroundWorker | Xu ly chuyen du lieu async |

### Controls kha ke thua

| Control | Type | Mo ta |
|---------|------|-------|
| cmdOk | Button | Nut OK (sau khi xac nhan) |
| cmdCancel | Button | Nut Huy |

---

## Business Logic

### Quy trinh xu ly

1. **Hien thi ngay cuoi nam**: Ngay 31/12 nam hien tai (readonly)
2. **Sinh ma xac nhan**: Random code 6 ky tu so
3. **Chon kho**: AsTextBox AutoLookup MA_KHO
4. **Xac nhan**: Nguoi dung nhap lai ma so
5. **Thuc hien**:
   - BackgroundWorker xu ly chuyen ton kho
   - Tao ban ghi INCDVT nam moi tu so ton cuoi nam
   - Bao cao ket qua (50015=thanh cong, 50010=that bai)
6. **Dong form**: Sau khi chuyen thanh cong

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Required | ma_kho | 'Chon kho can chuyen' |
| Match | ma_so = confirm | 'Ma xac nhan khong khop' |

### Business Rules

1. **Chon kho**: Chi chuyen du lieu cua kho duoc chon
2. **Xac nhan 2 buoc**: Nhap lai ma so de tranh nhan lenh sai
3. **Xu ly background**: Khong block UI khi chuyen nhieu du lieu
4. **Transaction**: Dam bao toan ven du lieu

---

## Mapping PHP

### 1. Livewire Component (Transfer)

```php
// diepxuan/laravel-catalog/src/Http/Livewire/IN/Transfers/Chuyentondauky.php
namespace Diepxuan\Catalog\Http\Livewire\IN\Transfers;

class Chuyentondauky extends Component
{
    const MA_CT = 'IN';
    const ACTION = 'TRANSFER_CDVT';

    public ?string $pMa_kho = null;
    public ?string $pTen_kho = null;
    public string $pFinal_day = '31/12/' . now()->year;
    public string $pMaSo = '';
    public string $pConfirm = '';
    public bool $pCanSubmit = false;
    public bool $pIsProcessing = false;
    public ?string $pStatus = null;

    public function mount(): void
    {
        $this->generateCode();
    }

    public function updatedPConfirm($value): void
    {
        $this->pCanSubmit = ($value === $this->pMaSo);
    }

    public function updatedPMaKho($value): void
    {
        // Auto-fill ten_kho
    }

    public function generateCode(): void
    {
        $this->pMaSo = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }

    public function execute(): void
    {
        if (!$this->pCanSubmit) return;

        $this->pIsProcessing = true;

        // Goi SP chuyen ton kho
        // $this->transferTonKho();

        $this->pIsProcessing = false;
        $this->pStatus = 'success';
    }

    public function render(): View
    {
        return view('catalog::in.transfers.chuyen-ton-dau-ky');
    }
}
```

### 2. Views

```
resources/views/catalog/in/transfers/
└── chuyen-ton-dau-ky.blade.php
```

### 3. Routes

```php
Route::get('/chuyen-ton-dau-ky', [Chuyentondauky::class, 'render'])
    ->name('catalog.in.transfers.chuyen-ton-dau-ky');
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMKHO.php | Kho |
| Model | laravel-simba | INCDVT.php | Ton dau ky |
| Component | laravel-catalog | Chuyentondauky.php | Transfer form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Stored Procedure SP_IN_TRANSFER_CDVT
- [ ] Tao Livewire Chuyentondauky
- [ ] Tao View chuyen-ton-dau-ky.blade.php
- [ ] Them Routes
- [ ] Test xac nhan 2 buoc (ma so)
- [ ] Test chon kho (AutoLookup)
- [ ] Test execute voi transaction