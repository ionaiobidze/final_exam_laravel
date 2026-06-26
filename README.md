# KIU Student Task Manager

A web app where a student can sign up, log in, and manage their own to-do tasks. Each task can have a deadline, a file attachment, and one or more categories. Built as the Laravel final project.

## Technologies Used

- **PHP 8** + **Laravel 13** — the framework and language.
- **SQLite** — the database (simple file-based, no server needed).
- **Blade** — Laravel's templating engine for the HTML pages.
- **Bootstrap 5 + custom CSS** — for the dark, responsive design.

## How to Run

```bash
./start          # or: php artisan serve
```

Then open `http://127.0.0.1:8000`. Register an account first — there are no pre-made logins.

## What the Project Does (mapped to the requirements)

### 1. MVC & Database

The code is split the Laravel way: **Models** (`Task`, `Category`, `User`) hold the data, **Controllers** handle the logic, and **Views** (Blade files) show the pages.

The database is built with **migrations** (files that create the tables). It uses two kinds of relationships:

- **One-to-Many** — one `User` has many `Tasks`. Each task belongs to the user who made it.
- **Many-to-Many** — a `Task` can have many `Categories`, and a `Category` can have many `Tasks`. This is connected through a pivot table (`category_task`).

### 2. CRUD Operations

You can fully **Create, Read, Update, and Delete** both Tasks and Categories through forms. Every form is protected with a **CSRF token** (Laravel's built-in security against fake form submissions).

### 3. Blade Templating & UI

The pages reuse a single layout (`layouts/app`) with `@extends` and `@section`. Shared form fields live in partials included with `@include`. Lists and conditions use `@foreach` and `@if`. Errors and success messages are shown clearly on the page. The navbar highlights the section you're on, and the design works on mobile.

### 4. Security, Validation & Advanced Features

- **Authentication** — register, login, and logout. Passwords are hashed.
- **Middleware** — the `auth` middleware blocks guests from the task/category pages and redirects them to login. Users can only see and edit their **own** tasks.
- **Validation** — all input is checked (required fields, valid email, password length, file type/size) and clear error messages are shown.
- **File Uploads** — each task can have a file (image, PDF, Word, or text, up to 4 MB). Images are previewed; other files get a download link. Old files are deleted when replaced or removed.
- **API** — a Resource Controller at `/api/tasks` returns task data as **JSON** (full Create/Read/Update/Delete over the API).

## Project Structure (key folders)

```
app/Http/Controllers/   TaskController, CategoryController, AuthController, Api/TaskController
app/Models/             Task, Category, User
database/migrations/    table definitions and relationships
resources/views/        Blade pages (tasks, categories, auth, layout)
routes/web.php          page routes (protected by auth)
routes/api.php          JSON API routes
public/css/hig.css      the custom design
```
