# Architecture and code organization

This application follows **Laravel’s MVC pattern** and keeps domain logic for tasks in a small, readable set of classes.

## High-level request flow

1. **Route** (`routes/web.php`) matches the HTTP method and URI.
2. **Middleware** (web group: sessions, CSRF, cookies, etc.) runs automatically.
3. **Controller** (`TaskController`) loads or persists data through the **Task** model.
4. For create/update, **Form Requests** validate input before the controller calls Eloquent.
5. **Blade** renders HTML using `layouts/app.blade.php` and task-specific views.

## Model: `App\Models\Task`

Responsibilities:

- Maps to the `tasks` table.
- Declares **mass assignable** attributes: `title`, `description`, `status`, `deadline`.
- Casts `deadline` to a date object for convenient formatting in views.
- Defines constants `STATUS_PENDING` and `STATUS_DONE` to avoid magic strings in PHP code.
- Provides **query scopes**:
  - `scopeStatus`: filter by a single status (used from the index query string).
  - `scopeSearch`: simple `LIKE` search on title and description.

## Controller: `App\Http\Controllers\TaskController`

| Method | Responsibility |
|--------|----------------|
| `index` | Read filtered/paginated tasks; pass `tasks`, `status`, `q` to the view. |
| `create` | Show the create form. |
| `store` | Validate via `StoreTaskRequest`, `Task::create(...)`. |
| `edit` | Show the edit form for one task (route model binding). |
| `update` | Validate via `UpdateTaskRequest`, `$task->update(...)`. |
| `destroy` | `$task->delete()`. |
| `toggleStatus` | Flip `pending` ↔ `done`, then `save()`. |

**Route model binding:** URLs like `/tasks/3/edit` resolve `Task` by primary key automatically. Invalid IDs yield a 404.

## Form requests

Validation rules are shared through the `TaskRules` trait and used by:

- `StoreTaskRequest`
- `UpdateTaskRequest`

Benefits:

- Controller methods stay short.
- Rules live in one place, so create and update stay consistent.
- Easier to test and extend (e.g., unique titles, custom messages).

## Views

- **`layouts/app.blade.php`**: HTML shell, Bootstrap 5, navbar, flash messages, validation error list, `@yield('content')`.
- **`tasks/index.blade.php`**: Table of tasks, GET filter form, search field, pagination links, action buttons.
- **`tasks/create.blade.php`** / **`tasks/edit.blade.php`**: POST forms with CSRF (and `@method('PUT')` on edit).

The list orders tasks with **nearest deadlines first** and puts rows without a deadline after dated rows (`orderByRaw('deadline IS NULL')` then `deadline` ascending).

## Routes

- `Route::resource('tasks', TaskController::class)->except(['show']);` registers standard RESTful routes except a dedicated “show” page.
- `Route::post('tasks/{task}/toggle', ...)` adds a dedicated **toggle** endpoint for quick status changes from the list.

## Pagination and UI

- `Paginator::useBootstrapFive()` is set in `AppServiceProvider` so pagination markup matches Bootstrap 5.

## Testing surface

Feature tests hit the same routes and middleware as a browser would, using an in-memory SQLite database for isolation (see `phpunit.xml` and `docs/TESTING.md`).

## Extension ideas (final project)

- **Authentication** (Laravel Breeze/Fortify): tasks per user, policies.
- **API + Sanctum**: JSON CRUD for a mobile or SPA client.
- **Policies**: ensure users only edit their own tasks.
- **API resources** or **Livewire/Inertia** for richer UI without full page reloads.
