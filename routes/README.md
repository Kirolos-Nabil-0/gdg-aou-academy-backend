# Routes Directory

This directory contains all application routes.

## 📁 Structure

```
routes/
├── api.php      # API routes
├── web.php      # Web routes
└── console.php  # Console routes
```

## 🛣️ API Routes (api.php)

All API routes are prefixed with `/api` and organized by feature.

### **Route Organization:**

```
/api
├── /auth                 # Authentication
├── /users                # User management (Admin)
├── /colleges             # Colleges (Admin CRUD)
├── /tracks               # Tracks (Admin CRUD)
├── /courses              # Courses
├── /enrollments          # Enrollments
├── /sessions             # Sessions
├── /attendance           # Attendance
├── /assignments          # Assignments
├── /grades               # Grades
├── /certificates         # Certificates
├── /dashboard            # Dashboards
└── /notifications        # Notifications
```

### **Authentication Routes:**

```php
Route::prefix('auth')->middleware('throttle:auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});
```

**Rate Limiting:** `throttle:auth` - Protects against brute force attacks

### **Public Routes:**

```php
// Colleges - Public access
Route::get('/colleges', [CollegeController::class, 'index']);
Route::get('/colleges/{id}', [CollegeController::class, 'show']);

// Tracks - Public access
Route::get('/tracks', [TrackController::class, 'index']);
Route::get('/tracks/{id}', [TrackController::class, 'show']);

// Published Courses - Public browsing
Route::get('/courses/published', [CourseController::class, 'published']);
```

### **Authenticated Routes:**

All routes inside `auth:sanctum` middleware require authentication:

```php
Route::middleware('auth:sanctum')->group(function () {
    // User profile
    Route::get('/user/me', [AuthController::class, 'me']);
    
    // Logout
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    
    // Protected resources...
});
```

### **Grouped Routes with Prefixes:**

#### **Enrollments:**
```php
Route::prefix('enrollments')->group(function () {
    Route::post('/', [EnrollmentController::class, 'enroll']);
    Route::get('/my', [EnrollmentController::class, 'myEnrollments']);
    Route::get('/course/{courseId}', [EnrollmentController::class, 'courseEnrollments']);
    Route::delete('/course/{courseId}', [EnrollmentController::class, 'unenroll']);
});
```

#### **Dashboards:**
```php
Route::prefix('dashboard')->group(function () {
    Route::get('/admin', [DashboardController::class, 'adminDashboard'])
        ->middleware('role:Admin');
    Route::get('/instructor', [DashboardController::class, 'instructorDashboard'])
        ->middleware('role:Instructor|HR');
    Route::get('/learner', [DashboardController::class, 'learnerDashboard']);
});
```

## 🔒 Middleware

### **Available Middleware:**

| Middleware | Purpose |
|------------|---------|
| `auth:sanctum` | Requires authentication |
| `throttle:auth` | Rate limiting (60 requests/min) |
| `role:Admin` | Requires Admin role |
| `role:Instructor\|HR` | Requires Instructor OR HR role |

### **Custom Middleware:**

Create custom middleware:
```bash
php artisan make:middleware CheckFeature
```

Register in `app/Http/Kernel.php`:
```php
protected $middlewareAliases = [
    'check.feature' => \App\Http\Middleware\CheckFeature::class,
];
```

Use in routes:
```php
Route::get('/feature', [FeatureController::class, 'index'])
    ->middleware('check.feature');
```

## 📊 Route List

View all registered routes:
```bash
# All routes
php artisan route:list

# Filter by path
php artisan route:list --path=api/courses

# Filter by method
php artisan route:list --method=POST
```

## 🎯 RESTful Resource Routes

Laravel provides resourceful routing:

```php
Route::apiResource('courses', CourseController::class);
```

This creates:
- `GET /courses` → index
- `POST /courses` → store
- `GET /courses/{id}` → show
- `PUT/PATCH /courses/{id}` → update
- `DELETE /courses/{id}` → destroy

## 🔧 Best Practices

- ✅ Group related routes with prefixes
- ✅ Use middleware for authentication/authorization
- ✅ Apply rate limiting to sensitive routes
- ✅ Use route model binding for cleaner code
- ✅ Keep routes organized and readable
- ✅ Use descriptive route names

## 📝 Example: Adding New Routes

```php
// 1. Group with prefix
Route::prefix('features')->group(function () {
    
    // 2. Public route
    Route::get('/', [FeatureController::class, 'index']);
    
    // 3. Authenticated routes
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/', [FeatureController::class, 'store']);
        Route::get('/{id}', [FeatureController::class, 'show']);
        
        // 4. Role-based route
        Route::delete('/{id}', [FeatureController::class, 'destroy'])
            ->middleware('role:Admin');
    });
});
```

## 🔗 Related Documentation

- [Laravel Routing](https://laravel.com/docs/routing)
- [API Documentation](../docs/API_DOCUMENTATION.md)
- [Middleware Guide](../docs/MIDDLEWARE.md)
