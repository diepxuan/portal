# Task 138: GL - Chuyen so lieu vao so cai

## Thong tin co ban

| Thuoc tinh | Gia tri |
|------------|---------|
| **DLL** | GLPost2GL.dll |
| **Module** | GL (General Ledger) |
| **Loai** | Transfer (Chuyen doi) |
| **Trang thai** | Da phan tich |

## Muc tieu
Chuyen doi chuc nang chuyen so lieu vao so cai tu .NET sang PHP Laravel.

## Cấu trúc dữ liệu

| Bảng | Mô tả | Loại |
|------|--------|------|
| GL1 | Chung tu GL | Transaction |
| GLMD | Ma doi tuong | Reference |

## Form classes

| Class | Ke thua | Muc dich |
|-------|---------|----------|
| frmGLPost2GL | frmCalc | Form chuyen so lieu |

## Stored Procedures

| SP Name | Mô tả |
|---------|-------|
| `GL_POST_2_GL` | Chuyen so lieu vao so cai |

## Business Logic

1. **Kiem tra so du**: Kiem tra so du truoc khi chuyen
2. **Tao dong so cai**: Tao dong tong hop cho TK
3. **Cap nhat so du**: Cap nhat so du TK sau khi chuyen
4. **Validate**: Khong chuyen truoc ngay khoa so

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/GL/Transfers/ChuyensolieuSocai.php
namespace Diepxuan\Catalog\Http\Livewire\GL\Transfers;

class ChuyensolieuSocai extends Component
{
    const MA_CT = 'GL';
    const ACTION = 'POST_2_GL';

    public ?Carbon $pNgay_chuyen = null;
    public bool $pIsProcessing = false;

    public function mount(): void
    {
        $this->pNgay_chuyen = now();
    }

    public function execute(): void
    {
        $this->pIsProcessing = true;
        DB::executeStoredProcedure('GL_POST_2_GL', [...]);
        $this->pIsProcessing = false;
    }

    public function render(): View
    {
        return view('catalog::gl.transfers.chuyen-so-lieu-so-cai');
    }
}
```

## Dependencies

| Package | Module | Mô tả |
|---------|--------|--------|
| diepxuan/catalog | GL | Module so cai |
| diepxuan/system | Commons | Ngay thang, khoa so |

## Progress Checklist

- [x] Phan tich DLL
- [ ] Tim kiem mapping SP GL_POST_2_GL
- [ ] Tao Livewire ChuyensolieuSocai
- [ ] Tao View
- [ ] Test kiem tra ngay khoa so
