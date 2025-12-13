# Config Directory

This directory contains all application configuration files.

## 📁 Configuration Files

```
config/
├── app.php           # Application settings
├── auth.php          # Authentication configuration
├── database.php      # Database connections
├── sanctum.php       # API authentication
├── cors.php          # CORS settings
├── permission.php    # Spatie permissions
└── ...
```

## ⚙️ Key Configuration Files

### **app.php**
Main application configuration:
- Application name
- Environment (local, production)
- Debug mode
- URL configuration
- Timezone
- Locale settings

**Important Settings:**
```php
'name' => env('APP_NAME', 'GDG AOU Learning Platform'),
'env' => env('APP_ENV', 'production'),
'debug' => env('APP_DEBUG', false),
'url' => env('APP_URL', 'http://localhost'),
'timezone' => 'UTC',
'locale' => 'en',
'fallback_locale' => 'en',
```

### **database.php**
Database connection configuration:
- MySQL connection settings
- Connection pooling
- Read/write connections

**MySQL Configuration:**
```php
'mysql' => [
    'driver' => 'mysql',
    'host' => env('DB_HOST', '127.0.0.1'),
    'port' => env('DB_PORT', '3306'),
    'database' => env('DB_DATABASE', 'gdg_learning'),
    'username' => env('DB_USERNAME', 'root'),
    'password' => env('DB_PASSWORD', ''),
],
```

### **sanctum.php**
Laravel Sanctum API authentication:
- Token expiration
- Stateful domains
- Guard configuration

**Key Settings:**
```php
'expiration' => 60, // Token expires after 60 minutes
'guard' => ['web', 'api'],
'stateful' => explode(',', env('SANCTUM_STATEFUL_DOMAINS', 'localhost')),
```

### **cors.php**
Cross-Origin Resource Sharing (CORS):
- Allowed origins
- Allowed methods
- Allowed headers
- Credentials support

**Configuration:**
```php
'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_methods' => ['*'],
'allowed_origins' => [env('FRONTEND_URL', 'http://localhost:3000')],
'allowed_headers' => ['*'],
'supports_credentials' => true,
```

### **permission.php**
Spatie Laravel Permission:
- Table names
- Model configuration
- Cache settings

**Settings:**
```php
'models' => [
    'permission' => Spatie\Permission\Models\Permission::class,
    'role' => Spatie\Permission\Models\Role::class,
],
'table_names' => [
    'roles' => 'roles',
    'permissions' => 'permissions',
    'model_has_permissions' => 'model_has_permissions',
    'model_has_roles' => 'model_has_roles',
    'role_has_permissions' => 'role_has_permissions',
],
```

## 🔧 Environment Variables

Configuration values are loaded from `.env` file:

```env
# Application
APP_NAME="GDG AOU Learning Platform"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gdg_learning
DB_USERNAME=root
DB_PASSWORD=

# Frontend
FRONTEND_URL=http://localhost:3000

# Sanctum
SANCTUM_STATEFUL_DOMAINS=localhost:3000
```

## 📝 Accessing Configuration

### **In Code:**
```php
// Get config value
$appName = config('app.name');
$dbHost = config('database.connections.mysql.host');

// Set config value (runtime only)
config(['app.debug' => false]);

// Check if config exists
if (config()->has('app.name')) {
    // ...
}
```

### **In Views:**
```blade
{{ config('app.name') }}
```

## 🔒 Security Best Practices

- ✅ Never commit `.env` file
- ✅ Use environment variables for sensitive data
- ✅ Set `APP_DEBUG=false` in production
- ✅ Use strong `APP_KEY`
- ✅ Configure proper CORS origins
- ✅ Set appropriate token expiration

## 🔧 Configuration Caching

### **Cache Configuration:**
```bash
# Cache config for better performance
php artisan config:cache

# Clear config cache
php artisan config:clear
```

**Note:** Always clear cache after changing config files!

## 📝 Creating Custom Configuration

1. **Create config file:**
```php
// config/features.php
return [
    'enabled' => env('FEATURES_ENABLED', true),
    'max_items' => env('FEATURES_MAX_ITEMS', 100),
];
```

2. **Access in code:**
```php
$enabled = config('features.enabled');
$maxItems = config('features.max_items');
```

3. **Add to .env:**
```env
FEATURES_ENABLED=true
FEATURES_MAX_ITEMS=50
```

## 🔗 Related Documentation

- [Laravel Configuration](https://laravel.com/docs/configuration)
- [Environment Configuration](https://laravel.com/docs/configuration#environment-configuration)
- [Sanctum Documentation](https://laravel.com/docs/sanctum)
- [Spatie Permissions](https://spatie.be/docs/laravel-permission)
