# Setup and installation

This guide assumes a Unix-like shell (macOS, Linux, or WSL). On Windows, use PowerShell or Git Bash and adjust paths.

## Requirements

- **PHP** 8.1 or newer, with extensions Laravel typically needs: `openssl`, `pdo`, `mbstring`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath` (and `pdo_sqlite` or `pdo_mysql` depending on database).
- **Composer** 2.x ([getcomposer.org](https://getcomposer.org)).
- A **database**: SQLite (simplest) or MySQL/MariaDB/PostgreSQL.

Optional:

- **Node.js** + npm if you later customize Vite assets (`npm install`, `npm run build`).

## Clone and install PHP dependencies

```bash
cd /path/to/Midterm-Exam-Laravel-CRUD-TODO-Application
composer install
```

If Composer warns about platform packages, fix your local PHP version or use the version your instructor expects.

## Environment file

```bash
cp .env.example .env
php artisan key:generate
```

`APP_KEY` must be set or encrypted cookies and sessions will not work reliably.

## Option A: SQLite (local development)

1. Open `.env` and set:

   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=/full/path/to/project/database/database.sqlite
   ```

   Use a **full absolute path** to avoid ambiguity when running Artisan from different directories.

2. Create the file if needed:

   ```bash
   touch database/database.sqlite
   ```

3. Run migrations and seed:

   ```bash
   php artisan migrate --seed
   ```

## Option B: MySQL (common in production / shared hosting)

1. Create an empty database (example name: `kiu_tasks`).

2. In `.env`:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=kiu_tasks
   DB_USERNAME=your_user
   DB_PASSWORD=your_password
   ```

3. Run:

   ```bash
   php artisan migrate --seed
   ```

If you use SSL to MySQL, set `MYSQL_ATTR_SSL_CA` only when your host requires it (see `config/database.php`).

## Run the application

```bash
php artisan serve
```

Default URL: [http://127.0.0.1:8000](http://127.0.0.1:8000).

For a custom host/port:

```bash
php artisan serve --host=0.0.0.0 --port=8080
```

## Optional: frontend build (Vite)

The task UI uses Bootstrap from a CDN in the Blade layout, so **you do not need** `npm run build` for the assignment UI to work. If you change `resources/js` or `resources/css` for Vite:

```bash
npm install
npm run dev    # development
# or
npm run build  # production assets
```

## Verify installation

1. Open the task list in a browser.
2. Create one task manually.
3. Run tests:

   ```bash
   php artisan test
   ```

All tests should pass.

## Fresh database (destructive)

This drops all tables and rebuilds from migrations, then seeds:

```bash
php artisan migrate:fresh --seed
```

**Warning:** This deletes all data in the configured database.
