
# 🎓 Student Course Management System (SCMS)

A lightweight and scalable **Student Course Management System** built with **Native PHP**, following the **MVC Architecture**, **Service Layer Pattern**, and **Repository Pattern** principles.

The system allows administrators to manage departments, courses, schedules, and students, while students can authenticate and register for courses that belong only to their departments.

---

# 📌 Table of Contents

* Overview
* Features
* System Architecture
* Project Structure
* Database Design
* Authentication & Authorization
* Business Rules
* Technologies Used
* Installation
* Configuration
* Routing System
* Database Schema
* Application Flow
* Security
* Future Improvements
* Screenshots
* Author

---

# 🚀 Overview

The Student Course Management System (SCMS) is designed to simplify academic course registration and administration.

The system provides two user types:

1. **Administrator**
2. **Student**

The administrator can manage:

* Departments
* Courses
* Course Schedules
* Students
* Course Registrations

The student can:

* Login to the system
* View available courses
* Register courses
* View personal schedule

---

# ✨ Features

## Administrator

* Authentication
* Dashboard
* Create, Update, Delete Departments
* Create, Update, Delete Courses
* Create, Update, Delete Course Schedules
* Create, Update, Delete Students
* View Student Registrations
* Upload Student Images

---

## Student

* Authentication
* View Courses
* Register Courses
* View Registered Courses
* View Weekly Schedule

---

# 🏗 System Architecture

The project follows:

* MVC Architecture
* Service Layer Pattern
* Repository Pattern
* Dependency Injection
* Single Responsibility Principle (SRP)

---

# 📂 Project Structure

```text
app/
│
├── Http/
│   └── Controllers/
│
├── Models/
│
├── Services/
│
├── Repositories/
│
├── Middleware/
│
├── Utility/
│
core/
│
├── Application.php
├── Container.php
├── Router.php
├── Request.php
├── Response.php
├── Database.php
├── Validator.php
├── View.php
│
config/
│
├── app.php
├── database.php
├── admin.php
│
public/
│
├── index.php
│
resources/
│
├── views/
│
├── assets/
│
storage/
│
├── images/
│
routers/
│
└── web.php
```

---

# 🗄 Database Design

## Tables

### departments

| Column | Type    |
| ------ | ------- |
| id     | INT     |
| name   | VARCHAR |

---

### users

| Column       | Type    |
| ------------ | ------- |
| id           | INT     |
| student_id   | VARCHAR |
| full_name    | VARCHAR |
| email        | VARCHAR |
| password     | VARCHAR |
| age          | INT     |
| gender       | VARCHAR |
| phone        | VARCHAR |
| parent_phone | VARCHAR |
| address      | TEXT    |
| dep_id       | INT     |
| image        | VARCHAR |

---

### courses

| Column       | Type    |
| ------------ | ------- |
| id           | INT     |
| name         | VARCHAR |
| code         | VARCHAR |
| dep_id       | INT     |
| credit_hours | INT     |

---

### course_schedules

| Column     | Type    |
| ---------- | ------- |
| id         | INT     |
| course_id  | INT     |
| week_day   | VARCHAR |
| start_time | TIME    |
| end_time   | TIME    |
| room       | VARCHAR |

---

### enrollments

| Column     | Type      |
| ---------- | --------- |
| id         | INT       |
| student_id | INT       |
| course_id  | INT       |
| created_at | TIMESTAMP |

---

# 📊 Entity Relationship Diagram

```text
Departments
      |
      |------< Users
      |
      |------< Courses
                      |
                      |------< Course Schedules

Users
      |
      |------< Enrollments >------ Courses
```

---

# 🔐 Authentication & Authorization

## Administrator Authentication

Administrator credentials are stored inside:

```text
config/admin.php
```

Authentication is performed using PHP Sessions.

---

## Student Authentication

Students authenticate using:

* Email
* Password

Passwords are hashed using:

```php
password_hash()
password_verify()
```

---

# 🛡 Session Structure

```php
$_SESSION['auth'] = [
    'id' => 1,
    'email' => 'student@school.edu',
    'role' => 'student'
];
```

---

# 📌 Business Rules

## Department Restriction

A student can register only for courses that belong to his department.

```text
Student Department
        ==
Course Department
```

---

## Duplicate Registration Prevention

A student cannot register for the same course more than once.

```sql
UNIQUE(student_id, course_id)
```

---

## Authentication Restriction

Unauthenticated users cannot access protected routes.

---

# 🔄 Application Flow

## Administrator Flow

```text
Login
 ↓
Dashboard
 ↓
Manage Departments
 ↓
Manage Courses
 ↓
Manage Schedules
 ↓
Manage Students
```

---

## Student Flow

```text
Login
 ↓
Dashboard
 ↓
View Courses
 ↓
Register Courses
 ↓
View Schedule
```

---

# 🌐 Routing System

Example:

```php
$router->get('/students', 'StudentController@index');
$router->post('/students', 'StudentController@store');
$router->post('/students/update', 'StudentController@update');
$router->post('/students/delete', 'StudentController@delete');
```

---

# 🔧 Technologies Used

## Backend

* PHP 8+
* PDO
* MySQL

## Frontend

* HTML5
* CSS3
* Bootstrap 5
* JavaScript

## Architecture

* MVC
* Repository Pattern
* Service Layer
* Dependency Injection

## Development Tools

* Composer
* Git
* GitHub
* XAMPP

---

# ⚙ Installation

## Clone Repository

```bash
git clone https://github.com/your-username/student-course-management-system.git
```

---

## Install Dependencies

```bash
composer install
```

---

## Configure Database

```bash
config/database.php
```

---

## Import Database

```bash
database.sql
```

---

## Run Application

```bash
php -S localhost:8000 -t public
```

---

# 🔒 Security

* Password Hashing
* Session Authentication
* Input Validation
* SQL Injection Protection using PDO Prepared Statements
* File Upload Validation
* Authentication Middleware
* Authorization Middleware

---

# 🚀 Future Improvements

* Email Verification
* Password Reset
* Notifications
* Course Capacity
* Attendance System
* GPA System
* PDF Reports
* REST API
* Role & Permission System
* AJAX & Real-time Features

---

# 📈 Design Patterns Used

* MVC
* Repository Pattern
* Service Pattern
* Dependency Injection
* Singleton Pattern
* Factory Pattern

---

# 👨‍💻 Author

**Mohanad Ahmed Shehata**

Software Engineer | PHP & Laravel Developer

* GitHub: https://github.com/your-username
* LinkedIn: https://linkedin.com/in/your-profile
* Portfolio: https://mohanadportfolio.vercel.app
