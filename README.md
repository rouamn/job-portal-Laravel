
# Laravel Project

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Project Overview

This is a Laravel application designed to manage user registration, login, and authentication. It includes routes for registration, login, and logout, with middleware protection for certain routes. This project is equipped with tests for user registration and login functionality.

## Installation and Setup Instructions

To get started with this project, follow these steps:

1. **Clone the repository:**

   ```bash
   git clone https://github.com/rouamn/job-portal-Laravel.git
   cd job-portal
   ```

2. **Install dependencies:**

   Install the required dependencies using Composer:

   ```bash
   composer install
   ```

3. **Configure environment variables:**

   Copy the `.env.example` file to `.env`:

   ```bash
   cp .env.example .env
   ```

   Open the `.env` file and set up the following environment variables:

   - `DB_CONNECTION=mysql` (or other database drivers if applicable)
   - `DB_HOST=127.0.0.1`
   - `DB_PORT=3306`
   - `DB_DATABASE=your_database_name`
   - `DB_USERNAME=your_database_username`
   - `DB_PASSWORD=your_database_password`

4. **Generate application key:**

   Run the following command to generate an application key for encryption:

   ```bash
   php artisan key:generate
   ```

5. **Run database migrations:**

   After configuring the database, run the migrations to set up the required tables:

   ```bash
   php artisan migrate
   ```

6. **Seed the database (optional):**

   If you want to seed sample data into the database (e.g., default users), use this command:

   ```bash
   php artisan db:seed
   ```

7. **Start the development server:**

   To run the application locally, use the following command:

   ```bash
   php artisan serve
   ```

   The application will be available at `http://127.0.0.1:8000` by default.

---

## Testing

To run tests for the application (such as for user registration and login functionality), use the following command:

```bash
php artisan test
```

---
### Interface Screenshots

#### 1. User Registration Page

![User Registration](resources/jobs.png)


## Additional Notes

- **Authentication:** The application uses Laravel's built-in authentication system for managing user login and registration.
- **Middleware:** Certain routes are protected by middleware to ensure that only authenticated users can access them.

---


