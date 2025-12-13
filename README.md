# 🎓 GDG Learning Platform

[![Laravel](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

A comprehensive Learning Management System (LMS) built for **Google Developer Groups**
---

## 📋 Table of Contents

- [About](#about)
- [Features](#features)
- [Architecture](#architecture)
- [Tech Stack](#tech-stack)
- [Installation](#installation)
- [API Documentation](#api-documentation)
- [Project Structure](#project-structure)
- [Contributing](#contributing)

---

## 🎯 About

The **GDG Learning Platform** is a modern, scalable learning management system designed to facilitate online education. It provides comprehensive tools for course management, student enrollment, attendance tracking, grading, and certificate generation.

### **Key Highlights:**
- 🔐 **Secure Authentication** - Token-based auth with Laravel Sanctum
- 👥 **Role-Based Access Control** - 4 roles with 45+ granular permissions
- 📊 **Comprehensive Dashboards** - Admin, Instructor, and Learner views
- 📜 **PDF Certificates** - Auto-generated with eligibility criteria
- 🌐 **Multilanguage Support** - English & Arabic
- 📱 **RESTful API** - 50+ well-documented endpoints

---

## ✨ Features

### **For Administrators:**
- Platform-wide statistics and analytics
- User management (CRUD)
- Course approval and management
- System configuration

### **For Instructors/HR:**
- Course creation and management
- Student enrollment management
- Attendance tracking
- Grade submission and gradebook
- Course statistics

### **For Learners:**
- Course browsing and enrollment
- Attendance tracking
- Grade viewing
- Certificate generation
- Personal dashboard

### **Core Modules:**
1. **Authentication & Authorization** - Sanctum + Spatie Permissions
2. **Course Management** - Full CRUD with status tracking
3. **Enrollment System** - Self-enrollment + waitlist support
4. **Session & Attendance** - Scheduling and tracking
5. **Grading System** - Weighted grade calculation
6. **Certificates** - PDF generation with eligibility checks
7. **Dashboards** - Role-based analytics
8. **Notifications** - In-app notification system

---

## 🏗️ Architecture

### **Design Patterns:**

#### **1. Repository Pattern**
Clean separation between business logic and data access:
```
Controller → Repository Interface → Repository Implementation → Model
```

**Benefits:**
- Testable code
- Swappable data sources
- Clean architecture

#### **2. Form Request Validation**
Centralized validation and authorization:
```php
public function store(StoreCourseRequest $request)
{
    // Validation already done!
    $course = $this->courseRepository->create($request->validated());
}
```

#### **3. Trait-Based Responses**
Consistent API responses across all controllers:
```php
return $this->successResponse($data, 'Success message');
return $this->errorResponse('Error message', 400);
```

### **Architecture Layers:**

```
┌─────────────────────────────────────┐
│         API Routes (routes/)        │
├─────────────────────────────────────┤
│      Controllers (Http/Controllers) │
├─────────────────────────────────────┤
│    Form Requests (Http/Requests)    │
├─────────────────────────────────────┤
│   Repositories (Repositories/)      │
├─────────────────────────────────────┤
│         Models (Models/)            │
├─────────────────────────────────────┤
│          Database (MySQL)           │
└─────────────────────────────────────┘
```

---

## 🛠️ Tech Stack

### **Backend:**
- **Framework:** Laravel 11.x
- **Language:** PHP 8.2+
- **Database:** MySQL 8.0+
- **Authentication:** Laravel Sanctum
- **Authorization:** Spatie Laravel Permission
- **PDF Generation:** barryvdh/laravel-dompdf

### **Key Packages:**
```json
{
  "laravel/sanctum": "^4.0",
  "spatie/laravel-permission": "^6.0",
  "barryvdh/laravel-dompdf": "^3.1"
}
```

---

## 🚀 Installation

### **Prerequisites:**
- PHP 8.2 or higher
- Composer
- MySQL 8.0+
- Node.js & npm (optional, for frontend)

### **Step 1: Clone Repository**
```bash
git clone https://github.com/your-org/gdg-learning-platform.git
cd gdg-learning-platform
```

### **Step 2: Install Dependencies**
```bash
composer install
```

### **Step 3: Environment Setup**
```bash
cp .env.example .env
php artisan key:generate
```

### **Step 4: Configure Database**
Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=gdg_learning
DB_USERNAME=root
DB_PASSWORD=your_password
```

### **Step 5: Run Migrations & Seeders**
```bash
php artisan migrate:fresh --seed
```

This will create:
- All database tables
- 4 roles (Admin, HR, Instructor, Learner)
- 45+ permissions
- Sample data (colleges, tracks, courses, users)

### **Step 6: Storage Link**
```bash
php artisan storage:link
```

### **Step 7: Start Server**
```bash
php artisan serve
```

**API Base URL:** `http://localhost:8000/api`

---

## 📡 API Documentation

### **Authentication**
All authenticated endpoints require Bearer token:
```bash
Authorization: Bearer {token}
```

### **Quick Start Example:**

**1. Login:**
```bash
POST /api/auth/login
Content-Type: application/json

{
  "email": "admin@gdg.com",
  "password": "password"
}
```

**2. Get User Profile:**
```bash
GET /api/user/me
Authorization: Bearer {token}
```

### **API Endpoints Overview:**

| Module | Endpoints | Description |
|--------|-----------|-------------|
| **Auth** | 7 | Registration, login, password reset |
| **Courses** | 6 | CRUD + published courses |
| **Enrollments** | 4 | Enroll, unenroll, view enrollments |
| **Sessions** | 3 | Schedule, view sessions |
| **Attendance** | 4 | Mark, view attendance |
| **Grades** | 5 | Submit, view grades, gradebook |
| **Certificates** | 4 | Generate, download, check eligibility |
| **Dashboards** | 4 | Admin, Instructor, Learner dashboards |
| **Notifications** | 5 | View, mark read, delete |

**Total:** 50+ endpoints

For detailed API documentation, see [API_DOCUMENTATION.md](docs/API_DOCUMENTATION.md)

---

## 📁 Project Structure

```
gdg-learning-platform/
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/     # API Controllers
│   │   ├── Requests/            # Form Request Validation
│   │   └── Traits/              # ApiResponse Trait
│   ├── Models/                  # Eloquent Models
│   ├── Repositories/            # Repository Pattern
│   │   ├── Interfaces/          # Repository Interfaces
│   │   └── Eloquent/            # Repository Implementations
│   └── Providers/               # Service Providers
├── database/
│   ├── migrations/              # Database Migrations
│   └── seeders/                 # Database Seeders
├── routes/
│   └── api.php                  # API Routes
├── config/                      # Configuration Files
├── lang/                        # Translations (EN/AR)
└── resources/
    └── views/certificates/      # PDF Templates
```

Each directory contains its own README with detailed documentation.

---

## 🔒 Security Features

- ✅ **Encrypted Fields** - Sensitive data (national_id, phone)
- ✅ **Rate Limiting** - Auth routes protected
- ✅ **CORS Configuration** - Controlled API access
- ✅ **Token Expiration** - 60-minute sessions
- ✅ **Role-Based Access** - Granular permissions
- ✅ **Form Validation** - All inputs validated

---

## 🌐 Multilanguage Support

The platform supports **English** and **Arabic**:

```bash
# Set language in request header
Accept-Language: ar
```

All API responses and validation messages are localized.

---

## 🧪 Testing

### **Default Test Accounts:**

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@gdg.com | password |
| Instructor | instructor@gdg.com | password |
| HR | hr@gdg.com | password |
| Learner | learner@gdg.com | password |

---

## 📚 Additional Documentation

- [Deployment Guide](docs/DEPLOYMENT_GUIDE.md)
- [API Documentation](docs/API_DOCUMENTATION.md)
- [Architecture Guide](docs/ARCHITECTURE.md)
- [Contributing Guide](CONTRIBUTING.md)

---

## 🤝 Contributing

We welcome contributions! Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

### **Development Workflow:**
1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---

## 👥 Authors

**GDG AOU Development Team**

---

## 🙏 Acknowledgments

- Laravel Framework
- Spatie Permissions
- DomPDF
- Arab Open University
- Google Developer Groups

---

## 📞 Support

For support, email support@gdg-aou.com or open an issue on GitHub.

---

**Made with ❤️ by GDG AOU**
