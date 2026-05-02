# Database: schema, migrations, seeding, export

## Schema: `tasks` table

| Column | Type | Notes |
|--------|------|--------|
| `id` | bigint, auto-increment | Primary key |
| `title` | string | Required in forms and validation |
| `description` | text, nullable | Optional long text |
| `status` | enum | `pending` or `done`; default `pending` |
| `deadline` | date, nullable | Optional; stored as date (no time component) |
| `created_at`, `updated_at` | timestamps | Laravel defaults |

Migration file: `database/migrations/2026_05_01_000000_create_tasks_table.php`.

## Migrations

Apply schema:

```bash
php artisan migrate
```

Rollback last batch:

```bash
php artisan migrate:rollback
```

Full reset (drops all tables) and re-run:

```bash
php artisan migrate:fresh
```

Add seed data in the same step:

```bash
php artisan migrate:fresh --seed
```

## Seeding and sample data

`Database\Seeders\DatabaseSeeder` creates **25** tasks using `Task::factory(25)->create()`.

Factory: `database/factories/TaskFactory.php` — generates English-style titles/descriptions, random status, optional deadline.

Run only seeders (after migrations):

```bash
php artisan db:seed
```

## Eloquent usage (rubric)

All task persistence uses the **`Task`** model:

- **Create:** `Task::create([...])`
- **Read:** `Task::query()->...` with scopes and `paginate()`
- **Update:** `$task->update([...])` or attribute assignment + `$task->save()`
- **Delete:** `$task->delete()`

No raw SQL is required for normal CRUD in this project.

## Clearing tasks only (Tinker)

From project root:

```bash
php artisan tinker --execute="\App\Models\Task::truncate();"
```

Or interactive Tinker:

```bash
php artisan tinker
>>> \App\Models\Task::truncate();
>>> exit
```

**Note:** Do not type the `>>>` prompt characters; those are Psy Shell’s display only.

## Submission export: `export.sql`

Your course may require a **`.sql` dump** in the zip.

### SQLite

From the project directory (adjust path to your `.sqlite` file):

```bash
sqlite3 database/database.sqlite .dump > export.sql
```

### MySQL

```bash
mysqldump -u USER -p DATABASE_NAME > export.sql
```

### PostgreSQL

```bash
pg_dump -U USER -d DATABASE_NAME -F p -f export.sql
```

Regenerate `export.sql` whenever you change data you want the grader to see. Commit or include the file in your submission zip according to instructor rules.

## phpunit testing database

Automated tests use **in-memory SQLite** via `phpunit.xml` (`DB_CONNECTION=sqlite`, `DB_DATABASE=:memory:`) so running tests does not erase your development database.
