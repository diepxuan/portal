# Task 223: SI-Cong-Cu-He-Thong-2

## Nhom: SI (System Integration)

## Muc tieu
Chuyen doi chuc nang cong cu he thong version 2 tu .NET sang PHP Laravel, dat ket qua tuong duong SiTools_2.

## Chi tiet
- **DLL:** SiTools_2.dll
- **Chuc nang:** Cong cu he thong (System Tools v2 - lightweight)
- **Loai:** Utility (UTL)
- **Assembly Title:** SiTools
- **Version:** 1.0.0.0
- **Namespace:** `AsiaErp.UserInterface`
- **Company:** Asiasoft

## Tai lieu tham khao
`/root/.openclaw/workspace/projects/SimbaSql/docs/decompiled/asia/SiTools_2.dll/README.md`

---

## Dac diem khac biet voi SiTools

| Dac diem | SiTools.dll | SiTools_2.dll |
|----------|-------------|----------------|
| System.Web reference | Co | Khong |
| System.Configuration reference | Co | Khong |
| InternalXmlHelper | Khong | Co |
| CacheSample | Co | Khong |

---

## Form classes

Giong nhu SiTools nhung khong co System.Web dependency.

---

## Mapping PHP

```php
// diepxuan/laravel-catalog/src/Http/Livewire/SI/CongcuHethong2.php
namespace Diepxuan\Catalog\Http\Livewire\SI\CongcuHethong2;

class CongcuHethong2 extends Component
{
    // Giong nhu SiTools nhung khong su dung System.Web.Caching
}
```

### Routes

```php
Route::prefix('catalog/si')
    ->name('catalog.si.')
    ->group(function () {
        Route::get('/cong-cu-he-thong-v2', [CongcuHethong2::class, 'render'])
            ->name('congcuhe thong2');
    });
```

---

## Progress Checklist

- [ ] Phan tich yeu cau & review task nay
- [ ] Tao Livewire component
- [ ] Tao View
- [ ] Them Routes
- [ ] Test
---
## Audit Status
- **Ngày audit:** 2026-05-10
- **Kết quả:** PENDING — spec đầy đủ, chưa implement
