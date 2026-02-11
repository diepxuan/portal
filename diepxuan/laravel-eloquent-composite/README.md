# Laravel Eloquent Composite

Package hỗ trợ khóa chính composite cho Eloquent Model.

## Mô tả

Eloquent Composite Model (lấy từ composer.json).

## Chức năng chính

- Cung cấp class `CompositeModel` kế thừa `Illuminate\Database\Eloquent\Model`.
- Cung cấp trait `HasCompositePrimaryKey` để xử lý khóa chính gồm nhiều cột.
- Hỗ trợ lưu và cập nhật model với khóa chính composite.
- Tắt tính năng auto-increment mặc định.

## Cài đặt / Sử dụng

```bash
composer require diepxuan/laravel-eloquent-composite
```

Sử dụng trong model:

```php
use Diepxuan\Database\Eloquent\CompositeModel;

class YourModel extends CompositeModel
{
    protected $primaryKey = ['column1', 'column2'];
    public $incrementing = false;
}
```

Hoặc sử dụng trait trong model Eloquent thông thường:

```php
use Illuminate\Database\Eloquent\Model;
use Diepxuan\Database\Eloquent\Traits\HasCompositePrimaryKey;

class YourModel extends Model
{
    use HasCompositePrimaryKey;
    
    protected $primaryKey = ['column1', 'column2'];
    public $incrementing = false;
}
```

## Cấu trúc thư mục

```
laravel-eloquent-composite/
├── src/
│   ├── CompositeModel.php
│   └── Traits/
│       └── HasCompositePrimaryKey.php
└── composer.json
```

## Liên kết đến các package liên quan

- illuminate/database (dependency)

## Ghi chú

Package hữu ích khi làm việc với các bảng có khóa chính gồm nhiều cột (composite primary key) trong Laravel.