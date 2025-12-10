# GDG AOU Academy Backend

A Laravel starter application for the GDG AOU Academy Backend project.

## Requirements

- PHP >= 8.2
- Composer
- MySQL 5.7+ or 8.0+

## Installation

1. Clone the repository:
```bash
git clone https://github.com/Kirolos-Nabil-0/gdg-aou-academy-backend.git
cd gdg-aou-academy-backend
```

2. Install PHP dependencies:
```bash
composer install
```

3. Copy the environment file:
```bash
cp .env.example .env
```

4. Generate application key:
```bash
php artisan key:generate
```

5. Configure your database in `.env`:
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=app
DB_USERNAME=app
DB_PASSWORD=app
```

6. Run database migrations:
```bash
php artisan migrate
```

## Running the Application

Start the development server:
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Available Endpoints

- `GET /` - Returns "Laravel starter app is running"
- `GET /api/health` - Returns `{"status":"ok"}` for health checks

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
