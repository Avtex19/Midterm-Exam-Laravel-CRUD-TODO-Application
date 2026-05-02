# Testing

## Running the suite

From the project root:

```bash
php artisan test
```

Equivalent:

```bash
./vendor/bin/phpunit
```

## Configuration

`phpunit.xml` sets:

- `APP_ENV=testing`
- `DB_CONNECTION=sqlite` and `DB_DATABASE=:memory:`

Feature tests that use `RefreshDatabase` migrate the schema into an **in-memory** SQLite database for each test class, so your local MySQL or file-based SQLite data is not touched.

## What is covered

`tests/Feature/TaskCrudTest.php` exercises:

- Creating a task via HTTP POST and asserting it exists in the database.
- Updating a task via HTTP PUT.
- Deleting a task via HTTP DELETE.
- Filtering the index by status (done tasks visible, pending hidden in that scenario).
- Toggling status from pending to done.
- Validation failures on store and update (empty title, invalid status, invalid date).

`tests/Feature/ExampleTest.php` asserts the home URL redirects to the task index (matching `routes/web.php`).

## Adding a new test

1. Create a test class under `tests/Feature/` or `tests/Unit/`.
2. For database-dependent tests, `use Illuminate\Foundation\Testing\RefreshDatabase;` on the test class.
3. Prefer named routes: `route('tasks.store')`, etc.

Example skeleton:

```php
public function test_example(): void
{
    $response = $this->get(route('tasks.index'));
    $response->assertOk();
}
```

## Continuous integration

The repository includes GitHub Actions workflows under `.github/workflows/` from the Laravel skeleton. Ensure any CI job runs `composer install` and `php artisan test` with PHP 8.1+.

## Deprecation notices on PHP 8.5+

If you see deprecation output from vendor packages (for example Collision) while tests still **pass**, that comes from dependencies, not your application code. Use the PHP version your course standardizes on, or update dependencies when framework maintainers release compatible versions.
