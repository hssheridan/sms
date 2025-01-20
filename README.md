# Student Management System

A Laravel-based application utilizing Filament's Admin Panel. On the home page, users may view a list of students. In the admin panel, users can manage students, courses, advisors, and the relationships between them.

## Set Up

### Prerequisites
1. Have [PHP](https://www.php.net/) 8.4 or higher installed.
2. Have [Composer](https://getcomposer.org/) installed.
3. Set up a PostgreSQL database.

### Installation
1. Clone the repository:
```bash
git clone https://github.com/hssheridan/sms.git
```
2. Navigate to project directory:
```bash
cd student-management-system
```
3. Install dependencies:
```bash
composer install
```
4. Copy `.env.example` to `.env`:
```bash
cp .env.example .env
```
5. Update `.env` with your database credentials.
6. Generate application key:
```bash
php artisan key:generate
```
7. Run migrations and seed database:
```bash
php artisan migrate --seed
```
8. Create Filament user:
```bash
php artisan make:filament-user
```
9. Start Laravel development server:
```bash
php artisan serve
```
10. Visit `http://localhost:8000/` in your browser to access the Student Management System.

## Features

- Frontend List View: A table of all the current students, including photos.
- Admin Panel: Requires the Filament User login generated above to access.
    -Advisors: Create, view, edit, or delete advisors. While editing, manage what courses or students an advisor has.
    -Courses: Create, view, edit, or delete courses.
    -Students: Create, view, edit, or delete students. List does not show all of their information; view a student to also see their photo and bio. While editing, manage what courses a student has. 