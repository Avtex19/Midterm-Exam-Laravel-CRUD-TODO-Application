# User guide: KIU Student Task Manager

This guide describes how to use the web interface after the application is running (`php artisan serve`).

## Opening the app

1. Start the server (see `README.md` or `docs/SETUP.md`).
2. Visit the home URL (for example `http://127.0.0.1:8000`).
3. You are redirected to the **Tasks** page automatically.

## Task list

The main screen shows a **table** of tasks with:

- **Title** and a short preview of the **description**
- **Status** badge (Pending or Done)
- **Deadline** (or a dash if none)
- **Created** (relative time, for example “2 hours ago”)
- **Actions**: toggle status, edit, delete

### Search

1. Type in the **Search** box (matches title or description).
2. Click **Apply**.

### Filter by status

1. Choose **All**, **Pending**, or **Done** in the **Status** dropdown.
2. Click **Apply**.

Search and status filter work together. Use **Reset** to clear query parameters and return to the default list.

### Pagination

If there are more tasks than fit on one page, use the **pagination links** at the bottom of the table (10 tasks per page).

## Create a new task

1. Click **New Task**.
2. Fill in **Title** (required).
3. Optionally add **Description**, choose **Status**, and set **Deadline**.
4. Click **Create**.

On success you return to the list with a green confirmation message.

## Edit a task

1. On the list, click **Edit** for the row you want.
2. Change any fields.
3. Click **Save Changes**.

## Mark Done or Pending quickly

- For a **pending** task, click the green **Done** button in the row.
- For a **done** task, click **Pending** to move it back.

This uses a separate **toggle** action and does not open the edit form.

## Delete a task

1. Click **Delete** on the row.
2. Confirm in the browser dialog.

Deletion cannot be undone unless you restore from a backup or re-seed the database.

## Validation messages

If required fields are missing or invalid (for example bad status or invalid date), the form **redisplays** with red error text at the top after submit.
