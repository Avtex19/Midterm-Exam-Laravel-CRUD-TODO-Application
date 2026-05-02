# KIU Student Task Manager

A Laravel **CRUD + TODO** web application themed as a student task manager (Kutaisi International University). You can use it as-is or adapt the branding. It is suitable as a midterm foundation and can be extended later (authentication, APIs, and more).

**Full documentation index**

| Document | Contents |
|----------|----------|
| This file (`README.md`) | Overview, quick start, features, troubleshooting |
| [`docs/SETUP.md`](docs/SETUP.md) | Requirements, installation, environment, SQLite vs MySQL |
| [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md) | MVC layout, request flow, main classes, design choices |
| [`docs/DATABASE.md`](docs/DATABASE.md) | Schema, migrations, seeding, backups, `export.sql` |
| [`docs/TESTING.md`](docs/TESTING.md) | Running tests, what is covered, CI notes |
| [`docs/USER_GUIDE.md`](docs/USER_GUIDE.md) | How to use the UI (create, edit, filter, search) |
| [`EXAM_README.md`](EXAM_README.md) | Short exam submission checklist |

---

## Table of contents

1. [Overview](#overview)
2. [Features](#features)
3. [Quick start](#quick-start)
4. [Documentation map](#documentation-map)
5. [Tech stack](#tech-stack)
6. [Project structure (summary)](#project-structure-summary)
7. [HTTP routes (summary)](#http-routes-summary)
8. [Common Artisan commands](#common-artisan-commands)
9. [Troubleshooting](#troubleshooting)
10. [License](#license)

---

## Overview

The application lets users manage **tasks** with:

- A **title** and optional **description**
- A **status** of `pending` or `done`
- An optional **deadline** (calendar date)

The UI lists tasks in a table, supports **pagination**, **filtering by status**, **search** on title and description, and quick **Done / Pending** toggles. All persistence goes through **Eloquent** models and standard Laravel **migrations** and **seeders**.

---

## Features

| Area | What you get |
|------|----------------|
| **Create** | Form to add a task; server-side validation |
| **Read** | Paginated list of tasks (10 per page) |
| **Update** | Edit form for an existing task |
| **Delete** | Delete with browser confirmation |
| **Status** | Mark tasks Done or Pending (form + one-click toggle) |
| **Filter** | Show all, only pending, or only done |
| **Search** | Query by title or description (combined with filters) |
| **Data** | Factory + seeder for sample tasks |
| **Tests** | Feature tests for CRUD, validation, filter, toggle |

---

## Quick start

Prerequisites: **PHP ≥ 8.1**, **Composer**, and a supported database (SQLite is the simplest for local work).

```bash
git clone <your-repo-url> kiu-task-manager
cd kiu-task-manager

composer install
cp .env.example .env
php artisan key:generate
```

**SQLite (recommended for local development)**

Ensure `.env` contains:

```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/project/database/database.sqlite
```

Create the database file if it does not exist:

```bash
touch database/database.sqlite
```

Then:

```bash
php artisan migrate --seed
php artisan serve
```

Open [http://127.0.0.1:8000](http://127.0.0.1:8000). The home URL redirects to the task list.

**Run tests**

```bash
php artisan test
```

For step-by-step setup with **MySQL** and more detail, see [`docs/SETUP.md`](docs/SETUP.md).

---

## Documentation map

- **[`docs/SETUP.md`](docs/SETUP.md)** — Install Composer dependencies, configure `.env`, create the database, first run, optional Vite assets.
- **[`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md)** — How MVC is organized, controller responsibilities, form requests, model scopes, Blade layout.
- **[`docs/DATABASE.md`](docs/DATABASE.md)** — `tasks` table columns, migrations, factories, seeders, exporting `export.sql`, reset workflows.
- **[`docs/TESTING.md`](docs/TESTING.md)** — PHPUnit configuration, in-memory SQLite for tests, extending coverage.
- **[`docs/USER_GUIDE.md`](docs/USER_GUIDE.md)** — End-user walkthrough of every screen and action.
- **[`EXAM_README.md`](EXAM_README.md)** — Minimal checklist for zip / GitHub submission.

---

## Tech stack

- **Framework:** Laravel 10.x
- **Language:** PHP 8.1+
- **ORM:** Eloquent
- **Views:** Blade + Bootstrap 5 (CDN) + Bootstrap Icons
- **HTTP:** Resource controller (except `show`) + one extra route for status toggle
- **Tests:** PHPUnit (via `php artisan test`)

---

## Project structure (summary)

```
app/
  Http/
    Controllers/TaskController.php   # CRUD + status toggle
    Requests/                        # StoreTaskRequest, UpdateTaskRequest, TaskRules trait
  Models/Task.php                    # Eloquent model + query scopes
database/
  factories/TaskFactory.php
  migrations/..._create_tasks_table.php
  seeders/DatabaseSeeder.php
resources/views/
  layouts/app.blade.php
  tasks/index.blade.php, create.blade.php, edit.blade.php
routes/web.php
tests/Feature/TaskCrudTest.php, ExampleTest.php
```

A longer annotated tree is in [`docs/ARCHITECTURE.md`](docs/ARCHITECTURE.md).

---

## HTTP routes (summary)

| Method | URI | Name | Purpose |
|--------|-----|------|---------|
| GET | `/` | — | Redirects to `tasks.index` |
| GET | `/tasks` | `tasks.index` | List tasks (filters, search, pagination) |
| GET | `/tasks/create` | `tasks.create` | Create form |
| POST | `/tasks` | `tasks.store` | Store new task |
| GET | `/tasks/{task}/edit` | `tasks.edit` | Edit form |
| PUT/PATCH | `/tasks/{task}` | `tasks.update` | Update task |
| DELETE | `/tasks/{task}` | `tasks.destroy` | Delete task |
| POST | `/tasks/{task}/toggle` | `tasks.toggle` | Flip pending ↔ done |

There is no `tasks.show` route; details appear in the list and edit screens.

---

## Common Artisan commands

| Command | Purpose |
|---------|---------|
| `php artisan migrate` | Run pending migrations |
| `php artisan migrate:fresh --seed` | Drop all tables, migrate, seed (destructive) |
| `php artisan db:seed` | Run seeders only |
| `php artisan tinker` | REPL for Eloquent / debugging |
| `php artisan route:list` | List registered routes |
| `php artisan test` | Run automated tests |

---

## Troubleshooting

| Symptom | Likely cause | What to try |
|---------|----------------|-------------|
| `Could not open input file: artisan` | Wrong directory | `cd` into the project folder that contains `artisan` |
| `SQLSTATE[HY000]` SQLite | Missing file or bad `DB_DATABASE` path | `touch database/database.sqlite` and use an **absolute** path in `.env` |
| `419 Page Expired` on forms | Session / CSRF | Clear cookies; ensure `APP_URL` matches how you open the site |
| Empty task list after seed | Wrong DB or not migrated | Run `php artisan migrate --seed` against the same DB as `.env` |
| Tests fail on DB | Env not isolated | Tests use in-memory SQLite via `phpunit.xml`; run `php artisan test` from project root |

More detail: [`docs/SETUP.md`](docs/SETUP.md) and [`docs/DATABASE.md`](docs/DATABASE.md).

---

## License

This project is based on the Laravel application skeleton, which is open source under the [MIT license](https://opensource.org/licenses/MIT). Your assignment-specific code follows the same spirit unless your course states otherwise.
