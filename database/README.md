# Database Directory

This directory contains all database-related files including migrations and seeders.

## 📁 Structure

```
database/
├── migrations/     # Database schema migrations
├── seeders/        # Database seeders
└── factories/      # Model factories (for testing)
```

## 🗄️ Migrations

### **Overview:**
Migrations are version control for your database schema. Each migration file represents a change to the database structure.

### **Key Migrations:**

| Migration | Description |
|-----------|-------------|
| `create_users_table` | User accounts with encrypted fields |
| `create_permission_tables` | Spatie permission tables (roles, permissions) |
| `create_colleges_table` | College reference data |
| `create_tracks_table` | Track reference data |
| `create_courses_table` | Course catalog |
| `create_enrollments_table` | Course enrollments |
| `create_course_sessions_table` | Scheduled sessions |
| `create_attendance_records_table` | Attendance tracking |
| `create_assignments_table` | Course assignments |
| `create_grades_table` | Student grades |
| `create_certificates_table` | Generated certificates |
| `create_notifications_table` | In-app notifications |

### **Running Migrations:**

```bash
# Run all migrations
php artisan migrate

# Fresh migration (drop all tables and re-run)
php artisan migrate:fresh

# Fresh migration with seeders
php artisan migrate:fresh --seed

# Rollback last migration
php artisan migrate:rollback

# Check migration status
php artisan migrate:status
```

### **Creating New Migration:**

```bash
# Create migration
php artisan make:migration create_features_table

# Create migration with model
php artisan make:model Feature -m
```

## 🌱 Seeders

### **Overview:**
Seeders populate the database with initial or test data.

### **Available Seeders:**

1. **CollegesSeeder** - 5 colleges
2. **TracksSeeder** - 10 tracks
3. **RolesAndPermissionsSeeder** - 4 roles, 45+ permissions
4. **UsersSeeder** - 20 test users
5. **CoursesSeeder** - 10 sample courses

### **Running Seeders:**

```bash
# Run all seeders
php artisan db:seed

# Run specific seeder
php artisan db:seed --class=UsersSeeder

# Fresh migration with seeders
php artisan migrate:fresh --seed
```

### **Creating New Seeder:**

```bash
php artisan make:seeder FeatureSeeder
```

## 📊 Database Schema

### **Core Tables:**

#### **users**
- User accounts
- Encrypted fields: `national_id_encrypted`, `phone_encrypted`
- Relationships: college, roles, enrollments

#### **courses**
- Course catalog
- Fields: title, description, capacity, status
- Relationships: track, instructor, enrollments, sessions

#### **enrollments**
- Course enrollments
- Fields: user_id, course_id, status
- Status: enrolled, waitlisted, dropped, completed

#### **course_sessions**
- Scheduled sessions
- Fields: title, start_at, end_at, modality
- Relationships: course, attendance_records

#### **grades**
- Student grades
- Fields: assignment_id, user_id, grade_value, status
- Weighted calculation support

#### **certificates**
- Generated certificates
- Fields: certificate_number, file_url, criteria_snapshot
- Unique certificate numbers

## 🔧 Best Practices

### **Migrations:**
- ✅ Use descriptive names
- ✅ Add foreign key constraints
- ✅ Add indexes for frequently queried columns
- ✅ Use `up()` and `down()` methods
- ✅ Never modify existing migrations in production

### **Seeders:**
- ✅ Use factories for test data
- ✅ Make seeders idempotent (can run multiple times)
- ✅ Seed in logical order (dependencies first)
- ✅ Use transactions for performance

## 📝 Example Migration

```php
public function up(): void
{
    Schema::create('features', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('name');
        $table->text('description')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
        
        // Indexes
        $table->index('user_id');
        $table->index('is_active');
    });
}
```

## 📝 Example Seeder

```php
public function run(): void
{
    Feature::create([
        'user_id' => 1,
        'name' => 'Sample Feature',
        'description' => 'This is a sample feature',
        'is_active' => true,
    ]);
}
```

## 🔗 Related Documentation

- [Laravel Migrations](https://laravel.com/docs/migrations)
- [Laravel Seeders](https://laravel.com/docs/seeding)
- [Database Schema](../docs/DATABASE_SCHEMA.md)
