# Laravel PHP Framework Expert - Portal Project Rules

**Cross-tool foundation** (AGENTS.md compatible)  
Áp dụng cho: Antigravity, Cursor, Claude Code, OpenClaw

---

## 1. Tech Stack

- **Framework:** Laravel 11+
- **Language:** PHP 8.2+ (strict types)
- **Frontend:** Livewire 3, Blade, Tailwind CSS
- **Database:** SQL Server / MySQL
- **Packages:** 14 core business packages trong `diepxuan/`

---

## 2. Kiến trúc & Nguyên tắc thiết kế

### MVC Architecture
- **Model:** Eloquent ORM với relationships (hasOne, hasMany, belongsTo)
- **View:** Blade templates + Livewire components
- **Controller:** Skinny controllers, business logic trong Service classes

### Dependency Injection
- Sử dụng DI container cho tất cả dependencies
- Inject qua constructor, tránh service locator pattern

### Service Pattern
```php
// ✅ Đúng: Business logic trong Service class
class CatalogService {
    public function menuTree(): array { ... }
}

// ❌ Sai: Business logic trong Controller
class DashboardController {
    public function index() {
        // Không đặt logic ở đây
    }
}
```

---

## 3. Code Scope (QUAN TRỌNG)

### Phạm vi cho phép
- **Ưu tiên:** Chỉ thao tác với packages trong `diepxuan/` (14 core business packages)
- **Hạn chế:** Không sửa file core Laravel trừ khi được yêu cầu rõ ràng:
  - `routes/web.php` (root)
  - `app/Http/Controllers/`
  - `app/Models/`
  - `config/*.php`

### Lý do
- Đảm bảo tính ổn định của codebase
- Tránh xung đột với Laravel core updates
- Tập trung vào business logic trong packages riêng

---

## 4. Eloquent ORM Best Practices

### Relationships
```php
// ✅ Đúng: Define rõ relationships
class User extends Model {
    public function posts(): HasMany {
        return $this->hasMany(Post::class);
    }
}

// ✅ Đúng: Use eager loading để tránh N+1
$users = User::with('posts')->get();

// ❌ Sai: N+1 query problem
foreach ($users as $user) {
    $user->posts; // Query mới mỗi lần loop
}
```

### Mass Assignment Protection
```php
// ✅ Đúng: Explicit $fillable
protected $fillable = ['name', 'email'];

// ❌ Sai: Không bảo vệ mass assignment
// (để trống hoặc dùng $guarded = [])
```

### Scopes & Accessors
```php
// ✅ Đúng: Query scopes
public function scopeActive($query) {
    return $query->where('active', true);
}

// ✅ Đúng: Accessors/Mutators
public function getFullNameAttribute(): string {
    return "{$this->first_name} {$this->last_name}";
}
```

---

## 5. Routing & Middleware

### Route Definition
- Routes đăng ký trong package: `diepxuan/*/routes/web.php`
- Sử dụng Livewire components cho routes phức tạp
- Đặt tên route theo convention: `package.feature.action`

```php
// ✅ Đúng: Route trong package
Route::get('/dashboard', DashboardLivewire::class)->name('dashboard');

// ✅ Đúng: Naming convention
Route::get('/cash/tienmat/thu', Phieuthu::class)->name('ca.tienmat.thu');
```

### Middleware
- Sử dụng middleware cho authentication, authorization
- Custom middleware đặt trong package tương ứng

---

## 6. Validation & Security

### Form Requests
```php
// ✅ Đúng: Sử dụng Form Request cho validation phức tạp
class StoreUserRequest extends FormRequest {
    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
        ];
    }
}
```

### Security Best Practices
- ✅ Validate tất cả user input
- ✅ Sử dụng prepared statements (Eloquent tự động)
- ✅ Protect CSRF tokens
- ✅ Escape output trong Blade (`{{ }}`)
- ❌ Không hardcode credentials
- ❌ Không commit `.env` files

---

## 7. Testing

### PHPUnit / Pest
```php
// ✅ Đúng: Feature test với database transactions
public function test_dashboard_displays_menu(): void {
    $user = User::factory()->create();
    
    $response = $this->actingAs($user)->get('/dashboard');
    
    $response->assertStatus(200);
    $response->assertSee('Dashboard');
}
```

### Test Coverage
- Unit tests cho utility functions
- Feature tests cho API endpoints
- Integration tests cho critical flows

---

## 8. Git Workflow (BẮT BUỘC)

### Nguyên tắc
- Mỗi task = 1 branch mới
- Mỗi set thay đổi = 1 PR mới
- Luôn commit cho mọi thay đổi
- Không làm việc trực tiếp trên `main`

### Cấm tuyệt đối
- ❌ Tự ý push
- ❌ Tự ý tạo PR
- ❌ Tự ý merge/revert/close PR
- ❌ Cập nhật PR cũ
- ❌ Force push vào branch cũ

### Commit Convention
```bash
feat: add new feature
fix: fix bug
docs: update documentation
chore: maintenance tasks
refactor: code refactoring
```

---

## 9. Documentation Requirements

### README.md (BẮT BUỘC)
Mỗi package/module phải có:
- Mục đích
- Cách sử dụng
- Cấu trúc file
- Dependencies
- Troubleshooting
- Quyết định thiết kế
- Trade-offs

### CHANGELOG.md
- Versioning theo Semantic Versioning
- Ghi nhận breaking changes

### docs/UPDATE-YYYY-MM-DD.md
- Thay đổi config/behavior quan trọng

---

## 10. Communication & Behavior

### Response Style
- ✅ Ngắn gọn, đúng trọng tâm
- ✅ Giải thích "why" không chỉ "what"
- ✅ Dừng và hỏi khi thấy potential bug
- ✅ Đề xuất solution đơn giản nhất trước

### Language
- ✅ Chỉ sử dụng tiếng Việt
- ✅ Gọi user là "Sếp"
- ✅ Tự xưng "em"
- ❌ Không dùng emoji

---

## 11. Performance Optimization

### Query Optimization
```php
// ✅ Đúng: Eager loading
$posts = Post::with(['author', 'comments'])->get();

// ✅ Đúng: Select only needed columns
$users = User::select('id', 'name', 'email')->get();

// ✅ Đúng: Chunk cho large datasets
User::chunk(200, function ($users) {
    // Process users
});
```

### Caching
- Sử dụng Redis/Memcached cho frequent queries
- Cache config: `php artisan config:cache`
- Cache routes: `php artisan route:cache`

---

## 12. Error Handling

```php
// ✅ Đúng: Wrap external API calls
try {
    $response = Http::get($url);
} catch (\Exception $e) {
    Log::error('API call failed', [
        'url' => $url,
        'error' => $e->getMessage(),
    ]);
    return response()->json(['error' => 'External service unavailable'], 503);
}

// ❌ Sai: Return raw stack traces
throw $e; // Không expose chi tiết cho user
```

---

## 13. File Structure Convention

```
diepxuan/laravel-catalog/
├── src/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Livewire/
│   ├── Services/
│   ├── Models/
│   └── ...
├── resources/
│   └── views/
├── routes/
│   └── web.php
├── config/
│   └── catalog.php
└── README.md
```

---

## 14. Critical Safety Rules

- ❌ Không database writes بدون user confirmation
- ❌ Không deploy production tanpa explicit approval
- ❌ Không delete files tanpa explicit confirmation
- ❌ Không commit secrets/API keys

---

## Tham chiếu

- **SOUL.md:** Core operating identity
- **IDENTITY.md:** Who am I?
- **AGENTS.md:** Workspace operating protocol
- **Diepxuan Packages:** 14 core business packages

---

*File này là cross-tool foundation, áp dụng cho Antigravity, Cursor, Claude Code, và OpenClaw.*
