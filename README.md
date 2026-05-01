# KIU Student Task Manager

Laravel CRUD + TODO application for managing student tasks.

## Features

- Task CRUD (create, read, update, delete)
- Status toggle (`pending` / `done`)
- Filtering by status
- Search by title/description
- Pagination
- Seeded sample data

## Tech Stack

- Laravel (MVC)
- Blade templates + Bootstrap 5
- Eloquent ORM
- SQLite (default local setup)

## Local Setup

1. Install dependencies:
   - `composer install`
2. Create env and app key:
   - `cp .env.example .env`
   - `php artisan key:generate`
3. Run migrations and seed:
   - `php artisan migrate --seed`
4. Start app:
   - `php artisan serve`

Open `http://127.0.0.1:8000`.

## Test

- Run all tests: `php artisan test`

## Submission Notes

- Include `export.sql` in your zip submission.
- Additional exam-specific instructions are in `EXAM_README.md`.
