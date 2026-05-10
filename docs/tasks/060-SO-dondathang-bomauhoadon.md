# Task 060: SOND51bmhd

## Nhom: SO (Sales Order - Don hang ban)

## Muc tieu
Chuyen doi chuc nang bao mat hoa don (Ma hoa ket qua kiem tra) tu .NET sang PHP Laravel, dat ket qua tuong duong Phieubaono.

## Chi tiet
- **DLL:** SOND51bmhd.dll
- **Chuc nang:** Bao mat hoa don - Kiem tra va ma hoa hoa don tu in
- **Loai:** Utility (Cong cu)
- **Assembly Title:** SOND51bmhd
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asia Software Development JSC
- **Ma_ct:** BM (Bao mat)

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SOND51bmhd.dll/README.md`

---

## Cau truc du lieu

### Bang: DMBM (Danh muc cau hinh bao mat)

| Truong | Kieu | Chieu dai | Mo ta |
|--------|------|-----------|-------|
| ma_bm | varchar | 20 | Ma so bao mat |
| mk_bm | varchar | 100 | Mat khau bao mat (da ma hoa) |
| su_dung | bit | 1 | Su dung ma so (0: khong, 1: co) |
| ngay_tao | datetime | 8 | Ngay tao |
| nguoi_tao | varchar | 50 | Nguoi tao |

### Bang: BMHD (Bang ma hoa hoa don)

| Truong | Kieu | Mo ta |
|--------|------|-------|
| so_hd | int | So hoa don |
| ngay_hd | datetime | Ngay hoa don |
| so_seri | varchar | So seri (ky hieu) |
| mst | varchar | Ma so thue |
| ma_kt | varchar | Ma so kiem tra |
| ma_hoa | varchar | Ma hoa ket qua |

---

## Form classes

### 1. frmSOND51bmhd (Form chinh)
- **Ke thua:** frmAsiaRoot
- **Chuc nang:** Cai dat ma so bao mat, kiem tra va ma hoa hoa don
- **Controls:**

#### GroupBox 1: Thiet lap ma so bao mat

| Control | Type | Mo ta |
|---------|------|-------|
| txtMa_BM | TextBox | Ma so bao mat (PasswordChar='*') |
| chkHien | CheckBox | Hien thi/an ma so |
| ChkSu_dung | CheckBox | Su dung ma so bao mat |
| btnLuu | Button | Luu cau hinh |

#### GroupBox 3: Thong tin hoa don can kiem tra

| Control | Type | Mo ta |
|---------|------|-------|
| txtSo_HD | AsTextBox | So hoa don |
| txtNgay_HD | AsMaskedTextBox | Ngay hoa don (dd/MM/yyyy) |
| txtSo_seri | AsTextBox | Ky hieu hoa don |
| txtMST | AsTextBox | Ma so thue khach hang |
| txtMa_KT | AsTextBox | Ma so kiem tra |
| txtMa_hoa | AsTextBox | Ma hoa ket qua |
| btnKiemtra | Button | Kiem tra hoa don |
| btnMa_hoa | Button | Ma hoa thong tin |

### 2. frmConfirm (Form xac nhan)
- **Chuc nang:** Xac nhan thao tac cap nhat ma bao mat

---

## Thu tuc xu ly

### 1. Thiet lap ma so bao mat

```php
// Luu ma so bao mat (da ma hoa XOR + MD5)
function saveMaSoBaoMat(string $maSoMoi): void
{
    // Ma hoa XOR voi key mac dinh "asiasoft"
    // Hoac su dung ma hien tai lam key
    // Luu vao bang DMBM
}
```

### 2. Ma hoa thong tin hoa don

```php
// Tao ma hoa ket qua
function maHoaHoaDon(
    string $soHd,
    string $ngayHd,
    string $soSeri,
    string $mst
): string {
    // 1. Noi chuoi: soHd + "|" + ngayHd + "|" + soSeri + "|" + mst
    // 2. XOR voi key (ma_bm hoac "asiasoft" neu chua co ma_bm)
    // 3. Tao MD5 hash tu chuoi da ma hoa
    // 4. Tra ve ma_hoa (16 ky tu dau cua MD5)
}
```

### 3. Kiem tra hoa don

```php
// Kiem tra tinh hop le cua hoa don
function kiemTraHoaDon(
    string $soHd,
    string $ngayHd,
    string $soSeri,
    string $mst,
    string $maKtNhapVao
): bool {
    // 1. Tinh ma_kt tu thong tin nhap vao
    // 2. So sanh voi ma_kt nhap vao
    // 3. Tra ve ket qua
}
```

### 4. Thu toan ma hoa

```php
// XOR Encryption
function xorEncrypt(string $input, string $key): string
{
    // Chuyen sang byte array (UTF8)
    // XOR moi byte cua input voi byte cua key (lap lai key)
    // Chuyen ket qua sang Hex string
}

// MD5 Hash
function getMD5Hash(string $input): string
{
    // Tao MD5 hash
    // Tra ve hex string lowercase
}
```

---

## Business Logic

### Validate Rules

| Rule | Field | Message |
|------|-------|---------|
| Min length | ma_bm | 'Ma so bao mat phai lon hon 6 ky tu' |
| Required | so_hd | 'So hoa don khong duoc trong' |
| Required | ngay_hd | 'Ngay hoa don khong duoc trong' |
| Required | so_seri | 'Ky hieu hoa don khong duoc trong' |
| Required | mst | 'Ma so thue khong duoc trong' |

### Business Rules

1. **Ma so bao mat**:
   - Toi thieu 6 ky tu
   - Duoc ma hoa truoc khi luu (XOR + MD5)
   - Co the tuy chon su dung hoac khong

2. **Kiem tra hoa don**:
   - Nhap day du thong tin tu hoa don goc
   - He thong tu dong tinh toan ma kiem tra
   - So sanh ket qua de xac nhan tinh hop le

3. **Ma hoa hoa don**:
   - Ket hop thong tin hoa don voi ma bao mat
   - Tao ma hoa 16 ky tu (MD5)
   - Ma nay duoc in tren hoa don de kiem tra

---

## Mapping PHP

### 1. Model

```php
// app/Models/SO/DMBM.php
namespace Diepxuan\Simba\Models\SO;

class DMBM extends Model
{
    protected $table = 'DMBM';
    protected $primaryKey = 'ma_bm';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'ma_bm',
        'mk_bm',
        'su_dung',
        'ngay_tao',
        'nguoi_tao',
    ];

    protected $casts = [
        'ngay_tao' => 'date',
        'su_dung' => 'boolean',
    ];
}

// app/Models/SO/BMHD.php
class BMHD extends Model
{
    protected $table = 'BMHD';
    protected $primaryKey = ['so_hd', 'so_seri'];
    public $incrementing = false;
    protected $connection = 'simba';

    protected $fillable = [
        'so_hd', 'ngay_hd', 'so_seri',
        'mst', 'ma_kt', 'ma_hoa',
    ];

    protected $casts = [
        'so_hd' => 'integer',
        'ngay_hd' => 'date',
    ];
}
```

### 2. Security Service

```php
// diepxuan/laravel-catalog/src/Services/InvoiceSecurityService.php
namespace Diepxuan\Catalog\Services;

class InvoiceSecurityService
{
    private const DEFAULT_KEY = 'asiasoft';

    public function encrypt(string $input, ?string $key = null): string
    {
        $key = $key ?? self::DEFAULT_KEY;
        $inputBytes = mb_convert_encoding($input, 'UTF-8');
        $keyBytes = mb_convert_encoding($key, 'UTF-8');

        $result = '';
        $keyLen = strlen($keyBytes);
        for ($i = 0; $i < strlen($inputBytes); $i++) {
            $result .= chr(ord($inputBytes[$i]) ^ ord($keyBytes[$i % $keyLen]));
        }

        return strtoupper(bin2hex($result));
    }

    public function md5Hash(string $input): string
    {
        return strtolower(md5($input));
    }

    public function generateMaKt(
        string $soHd,
        string $ngayHd,
        string $soSeri,
        string $mst
    ): string {
        $data = "{$soHd}|{$ngayHd}|{$soSeri}|{$mst}";
        $encrypted = $this->encrypt($data);
        return substr($this->md5Hash($encrypted), 0, 16);
    }

    public function generateMaHoa(
        string $soHd,
        string $ngayHd,
        string $soSeri,
        string $mst,
        ?string $maBm = null
    ): string {
        $key = $maBm ?? self::DEFAULT_KEY;
        $data = "{$soHd}|{$ngayHd}|{$soSeri}|{$mst}";
        $encrypted = $this->encrypt($data, $key);
        return substr($this->md5Hash($encrypted), 0, 16);
    }

    public function verifyMaKt(
        string $soHd,
        string $ngayHd,
        string $soSeri,
        string $mst,
        string $maKtNhapVao
    ): bool {
        $maKtTinh = $this->generateMaKt($soHd, $ngayHd, $soSeri, $mst);
        return strcasecmp($maKtTinh, $maKtNhapVao) === 0;
    }
}
```

### 3. Livewire Component

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SO/Baomat/Baomathoadon.php
namespace Diepxuan\Catalog\Http\Livewire\SO\Baomat;

class Baomathoadon extends Component
{
    public ?string $pMa_Bm = null;
    public ?string $pMk_Bm = null;
    public bool $pHien = false;
    public bool $pSu_Dung = false;

    // Thong tin hoa don
    public ?string $pSo_Hd = null;
    public ?string $pNgay_Hd = null;
    public ?string $pSo_Seri = null;
    public ?string $pMst = null;
    public ?string $pMa_Kt = null;
    public ?string $pMa_Hoa = null;

    protected $rules = [
        'pMa_Bm' => 'nullable|string|min:6',
        'pMk_Bm' => 'nullable|string|min:6',
    ];

    public function mount(): void
    {
        $this->loadCauHinh();
    }

    public function luuCauHinh(): void
    {
        // Luu ma so bao mat
    }

    public function kiemTra(): void
    {
        $service = app(InvoiceSecurityService::class);
        $valid = $service->verifyMaKt(
            $this->pSo_Hd,
            $this->pNgay_Hd,
            $this->pSo_Seri,
            $this->pMst,
            $this->pMa_Kt
        );
        // Hien thi ket qua
    }

    public function maHoa(): void
    {
        $service = app(InvoiceSecurityService::class);
        $this->pMa_Hoa = $service->generateMaHoa(
            $this->pSo_Hd,
            $this->pNgay_Hd,
            $this->pSo_Seri,
            $this->pMst,
            $this->pMa_Bm
        );
    }

    public function render(): View
    {
        return view('catalog::so.baomat.baomathoadon');
    }
}
```

### 4. Views & Routes

```
resources/views/catalog/so/baomat/
├── baomathoadon.blade.php
```

```php
Route::prefix('catalog/so/baomat')
    ->name('catalog.so.baomat.')
    ->group(function () {
        Route::get('/hoa-don', [Baomathoadon::class, 'render'])
            ->name('baomathoadon');
    });
```

---

## Dependencies

| Loai | Package | File | Ghi chu |
|------|---------|------|---------|
| Model | laravel-simba | DMBM.php | Cau hinh bao mat |
| Model | laravel-simba | BMHD.php | Ma hoa hoa don |
| Service | laravel-catalog | InvoiceSecurityService.php | Ma hoa/kiem tra |
| Component | laravel-catalog | Baomathoadon.php | Form |

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Model DMBM, BMHD
- [ ] Tao InvoiceSecurityService
- [ ] Tao Livewire Baomathoadon
- [ ] Tao Views
- [ ] Them Routes
- [ ] Test Encrypt/Decrypt
- [ ] Test MD5 hash
- [ ] Test Verify logic
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
