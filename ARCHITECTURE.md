# Learning Platform - Project Architecture

## Overview
This is an **open-source API-based learning platform** built with Laravel, following best practices and clean architecture principles.

## Architecture Principles

### 1. **Repository Pattern**
- All database operations go through repositories
- Controllers call repositories, not models directly
- Each repository implements an interface for flexibility

### 2. **API Response Trait**
- Unified response format across all endpoints
- Consistent error handling
- Standardized success/error messages

### 3. **Form Request Validation**
- No validation logic in controllers
- Dedicated Form Request classes for each operation
- Clean, reusable validation rules

### 4. **Role-Based Access Control (RBAC)**
- Using Spatie Permission package
- Role and permission-based authorization
- Middleware for route protection

### 5. **Comprehensive Documentation**
- Every function has clear comments
- README.md in each major directory
- API documentation for all endpoints

## Project Structure

```
app/
├── Http/
│   ├── Controllers/     # API Controllers (thin, delegate to repositories)
│   ├── Requests/        # Form Request validation classes
│   ├── Middleware/      # Custom middleware (SetLocale, etc.)
│   └── Traits/          # Reusable traits (ApiResponse)
├── Repositories/        # Repository implementations
│   ├── Interfaces/      # Repository contracts
│   └── Eloquent/        # Eloquent-based repositories
├── Models/              # Eloquent models
└── Services/            # Business logic services (optional)
```

## Coding Standards

### Comments
- **English only** for all code comments
- Every class must have a docblock
- Every public method must have a docblock
- Complex logic must be explained

### Naming Conventions
- Controllers: `{Resource}Controller` (e.g., `UserController`)
- Repositories: `{Resource}Repository` (e.g., `UserRepository`)
- Interfaces: `{Resource}RepositoryInterface`
- Form Requests: `{Action}{Resource}Request` (e.g., `StoreUserRequest`)
- Traits: Descriptive names (e.g., `ApiResponse`)

## API Response Format

### Success Response
```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": { ... }
}
```

### Error Response
```json
{
    "success": false,
    "message": "Error message",
    "errors": { ... }
}
```

## Getting Started

See individual README files in each directory for detailed information:
- [Controllers README](app/Http/Controllers/README.md)
- [Repositories README](app/Repositories/README.md)
- [Requests README](app/Http/Requests/README.md)

## Contributing

This is an open-source project. Please follow the architecture principles and coding standards outlined in this document.

## License

[Add your license here]
