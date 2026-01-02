## zippp — URL shortener

zippp is a lightweight Laravel-based URL shortener built for small teams and personal use. It supports:

- Per-user link management with pagination and redirect counting.
- Optional expiration per link (default 90 days) and a "never expire" option.
- Optional per-link password protection (users must enter the password to follow protected links).
- Editing and deleting links from a dashboard.
- A scheduled pruning command that deletes expired links automatically.
- Per-user link limit enforced server-side (configured in `LinkController`).

This repository contains the full application source built on Laravel with a Vite/Alpine/Flatpickr front-end for a smooth UX.

## Quick feature mapping

- Links are stored in the `links` table (see migrations in [database/migrations](database/migrations)).
- Columns of interest: `target`, `slug`, `expires_at`, `password_hash`.
- Passwords are stored hashed in `password_hash`. When set, visiting `/{slug}` requires the password first.
- A scheduled Artisan command `links:prune-expired` removes expired links; it's registered in [app/Console/Kernel.php](app/Console/Kernel.php).

## Local setup (development)

Follow these steps to run the project locally on a machine with PHP, Composer and Node.js installed (tested on Windows, macOS, Linux):

1. Clone the repository and change into the project directory:

```bash
git clone <repo-url> zappp
cd zappp
```

2. Install PHP dependencies with Composer:

```bash
composer install
```

3. Copy and configure your environment file:

```bash
cp .env.example .env
# Edit .env and set DB_CONNECTION, DB_DATABASE, DB_USERNAME, DB_PASSWORD, and APP_URL
```

4. Generate an application key:

```bash
php artisan key:generate
```

5. Create a database and run migrations:

```bash
php artisan migrate
```

6. (Optional) Seed test data:

```bash
php artisan db:seed
```

7. Install front-end dependencies and build assets (development):

```bash
npm install
npm run dev
```

If you prefer an optimized production build:

```bash
npm run build
```

8. Serve the application locally:

```bash
php artisan serve
# then open the printed URL (usually http://127.0.0.1:8000)
```

9. (Optional) Enable the scheduler for automatic pruning in production:

On Linux / macOS, add the following cron entry (runs Laravel scheduler every minute):

```cron
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

On Windows use Task Scheduler to run `php artisan schedule:run` every minute or as required.

## Using the App

- Register or log in to access the dashboard at `/dashboard`.
- Create links by providing a target URL; you may set a custom slug or let the app generate one.
- Expiration:
	- If you leave the expiration blank, the link defaults to 90 days from creation.
	- Check "Never expire" to keep the link active indefinitely.
- Password protection:
	- When enabled, the creator sets a password. Visiting the short URL will require entering that password before redirecting.
- Edit and delete links from the dashboard. Deleting asks for confirmation.

## Configuration and Customization

- Per-user link limit: enforced in `app/Http/Controllers/LinkController.php` by the `$max` variable near the start of the `store()` method. Change it to adjust the allowed number of links per user.
- Expiry default: controlled in `LinkController` (uses `now()->addDays(90)`).
- Scheduled pruning: implemented as the Artisan command `links:prune-expired` in [app/Console/Commands/PruneExpiredLinks.php](app/Console/Commands/PruneExpiredLinks.php).

## Security notes

- Passwords are hashed using Laravel's `Hash` helper; raw passwords are never stored.
- The unlock flow requires the correct password before redirecting; it does not store the password in session by default (each visit requires the password).
- When deploying, ensure you use HTTPS to protect passwords and link targets in transit.

## Development notes

- Frontend: uses Alpine.js for small interactive behaviors and Flatpickr for the date/time picker (see `resources/js/app.js`).
- Styles: Tailwind CSS configured in `tailwind.config.js`.
- Tests: The project currently does not include an extensive test suite — add PHPUnit or Pest tests as needed.

## Troubleshooting

- If the date-time picker doesn't appear, ensure you've run `npm install` and `npm run dev` and that your browser loads the compiled assets.
- If redirects to short slugs return 404, verify migrations ran and `expires_at` values aren't expired.

## Contributing

If you want to contribute features or fixes, fork the repository, create a branch per change, and open a pull request. Please include tests for non-trivial features.

## License

This project is provided under the MIT license.