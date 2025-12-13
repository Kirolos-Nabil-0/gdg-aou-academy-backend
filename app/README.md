# App Directory

This directory contains the core application logic following Laravel's MVC architecture with Repository Pattern.

## 📁 Structure

```
app/
├── Http/
│   ├── Controllers/Api/    # API Controllers
│   ├── Requests/          # Form Request Validation
│   ├── Middleware/        # Custom Middleware
│   └── Traits/            # Reusable Traits
├── Models/                # Eloquent Models
├── Repositories/          # Repository Pattern
│   ├── Interfaces/        # Repository Interfaces
│   └── Eloquent/          # Repository Implementations
└── Providers/             # Service Providers
```

## 🎯 Key Components

### **Controllers (Http/Controllers/Api/)**
RESTful API controllers handling HTTP requests:
- `AuthController` - Authentication & user management
- `CourseController` - Course CRUD operations
- `EnrollmentController` - Enrollment management
- `GradeController` - Grading system
- `CertificateController` - Certificate generation
- `DashboardController` - Analytics & statistics
- `NotificationController` - Notification management

**Pattern:**
```php
public function index(Request $request): JsonResponse
{
    $data = $this->repository->all();
    return $this->successResponse($data, 'Success message');
}
```

### **Form Requests (Http/Requests/)**
Centralized validation and authorization:
- Validates incoming data
- Handles authorization logic
- Returns localized error messages

**Example:**
```php
public function rules(): array
{
    return [
        'email' => ['required', 'email'],
        'password' => ['required', 'min:8'],
    ];
}
```

### **Models (Models/)**
Eloquent ORM models representing database tables:
- Define relationships
- Set fillable/guarded attributes
- Cast data types
- Define accessors/mutators

**Key Models:**
- `User` - User accounts
- `Course` - Course catalog
- `Enrollment` - Course enrollments
- `Grade` - Student grades
- `Certificate` - Generated certificates

### **Repositories (Repositories/)**
Data access layer following Repository Pattern:

**Interfaces/** - Define contracts
**Eloquent/** - Implement contracts

**Benefits:**
- Testable code
- Swappable implementations
- Clean separation of concerns

**Example:**
```php
interface CourseRepositoryInterface
{
    public function all();
    public function find(int $id);
    public function create(array $data);
}
```

### **Providers (Providers/)**
Service providers for dependency injection:
- `RepositoryServiceProvider` - Binds repository interfaces to implementations
- `AppServiceProvider` - Application-wide services

## 🔧 Usage

### **Adding a New Feature:**

1. **Create Model:**
```bash
php artisan make:model Feature
```

2. **Create Repository Interface:**
```php
// app/Repositories/Interfaces/FeatureRepositoryInterface.php
interface FeatureRepositoryInterface extends RepositoryInterface
{
    public function customMethod();
}
```

3. **Create Repository Implementation:**
```php
// app/Repositories/Eloquent/FeatureRepository.php
class FeatureRepository extends BaseRepository implements FeatureRepositoryInterface
{
    public function customMethod() { }
}
```

4. **Bind in Service Provider:**
```php
// app/Providers/RepositoryServiceProvider.php
$this->app->bind(
    FeatureRepositoryInterface::class,
    FeatureRepository::class
);
```

5. **Create Controller:**
```bash
php artisan make:controller Api/FeatureController
```

6. **Create Form Request:**
```bash
php artisan make:request Feature/StoreFeatureRequest
```

## 📝 Best Practices

- ✅ Use Form Requests for validation
- ✅ Use Repository Pattern for data access
- ✅ Use ApiResponse trait for consistent responses
- ✅ Follow PSR-12 coding standards
- ✅ Add PHPDoc comments
- ✅ Use type hints
- ✅ Keep controllers thin

## 🔗 Related Documentation

- [Controllers README](Http/Controllers/README.md)
- [Models README](Models/README.md)
- [Repositories README](Repositories/README.md)
