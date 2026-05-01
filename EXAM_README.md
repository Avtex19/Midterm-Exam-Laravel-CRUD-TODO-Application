KIU Student Task Manager - Laravel CRUD + TODO
==============================================

Setup
-----
1) Requirements: PHP >= 8.1, Composer, a MySQL/Postgres database.
2) Install dependencies:
   - Copy env and generate key:
     ```
     cp .env.example .env
     php artisan key:generate
     ```
   - Configure DB connection in `.env` (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
   - Install PHP deps:
     ```
     composer install
     ```
   - (Optional) Install frontend deps for Vite assets:
     ```
     npm install && npm run build
     ```

Database
--------
- Run migrations and seed sample tasks:
  ```
  php artisan migrate --seed
  ```

Run the app
-----------
```
php artisan serve
```
Open `http://127.0.0.1:8000` → you'll be redirected to Tasks.

Features
--------
- Full CRUD for tasks (title, description, status pending/done, deadline).
- Toggle status (Done/Pending) via single click.
- Filtering by status and simple search by title/description.
- Pagination (10 per page).
- Bootstrap-based clean UI with a layout.

DB Export (Submission)
----------------------
- After seeding or adding your own data, export the DB:
  - MySQL:
    ```
    mysqldump -u <user> -p <database> > export.sql
    ```
  - Postgres:
    ```
    pg_dump -U <user> -d <database> -F p -f export.sql
    ```
- Include `export.sql` in your submission `.zip`.

Notes
-----
- All CRUD uses Eloquent (`App\Models\Task`).
- Code follows MVC: `Task` (Model), `TaskController` (Controller), Blade views (Views).
- No auth is required; you can add Breeze later for the final project.

