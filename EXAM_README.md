# Exam submission — KIU Student Task Manager

Use **`README.md`** as the main entry point and the **`docs/`** folder for detailed guides (setup, architecture, database, testing, user guide).

## Submission checklist

- [ ] Project runs after `composer install`, `.env` + `php artisan key:generate`, `php artisan migrate --seed`.
- [ ] Zip includes the **full Laravel project** (or submit a **GitHub** link if allowed).
- [ ] Include a database dump **`export.sql`** (regenerate after your final data; see [`docs/DATABASE.md`](docs/DATABASE.md)).
- [ ] Optional: run **`php artisan test`** and mention that tests pass.

## Quick commands (reference)

```bash
composer install
cp .env.example .env
php artisan key:generate
# Configure DB in .env (SQLite or MySQL — see docs/SETUP.md)
php artisan migrate --seed
php artisan serve
```

## Rubric mapping (short)

| Requirement | Where in project |
|-------------|-------------------|
| Laravel structure (routes, controllers, models) | `routes/web.php`, `app/Http/Controllers`, `app/Models` |
| MVC | See [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md) |
| Migration + fields | `database/migrations/2026_05_01_000000_create_tasks_table.php` |
| Seeding | `database/seeders/DatabaseSeeder.php`, `database/factories/TaskFactory.php` |
| Eloquent CRUD | `TaskController`, `App\Models\Task` |
| TODO: status + filter | Toggle route + index filters (see `README.md` route table) |
| Blade + Bootstrap | `resources/views/layouts/app.blade.php`, `resources/views/tasks/*` |

## Full documentation

| File | Purpose |
|------|---------|
| [`README.md`](README.md) | Overview, quick start, routes summary, troubleshooting |
| [`docs/SETUP.md`](docs/SETUP.md) | Installation, SQLite vs MySQL, verification |
| [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md) | MVC, request flow, classes |
| [`docs/DATABASE.md`](docs/DATABASE.md) | Schema, migrations, seed, export |
| [`docs/TESTING.md`](docs/TESTING.md) | How to run and extend tests |
| [`docs/USER_GUIDE.md`](docs/USER_GUIDE.md) | How to use the UI |
