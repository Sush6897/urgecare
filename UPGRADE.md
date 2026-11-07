# Laravel 13 upgrade

This application now uses Laravel 13, Sanctum 4, Tinker 3, and PHPUnit 12.
PHP 8.3 or newer is required. The local CLI already runs PHP 8.5.12.
Apache's live web runtime also runs PHP 8.5.12. cURL, ZIP, and Intl are enabled
and verified through Apache; the homepage returns HTTP 200. XAMPP's Apache
`nghttp2.dll` was updated from the PHP distribution to fix cURL loading.
System configuration backups are saved as `C:\xampp\php\php.ini.before-laravel13`
and `C:\xampp\apache\bin\nghttp2.dll.before-laravel13`.
Composer resolves packages against PHP 8.3 to keep the lock file compatible
with the minimum supported PHP version.

The existing application structure, HTTP kernel, and exception handler remain
supported. The Sanctum token migration is already present in this repository.

## Local setup

1. Confirm both Apache and CLI use PHP 8.3 or newer. `php -v` checks only CLI;
   check the PHP version served by Apache separately.
2. Enable the ZIP extension in the active PHP configuration for Composer
   downloads, or use this command with the existing XAMPP ZIP DLL:
   `php -d extension=zip C:\ProgramData\ComposerSetup\bin\composer.phar install`.
3. Copy `.env.example` to `.env` if needed, configure the application's database
   and services, and run `php artisan key:generate` only for a new environment.
   Preserve the existing application key when upgrading an existing deployment.
4. Run `composer check-platform-reqs` and `php artisan test`.

The homepage test requires an available database with the application's schema.
No SQL imports were run during this upgrade.

After local environment setup and the blog compatibility migration fix, all
seven tests pass (eleven assertions), including the database-backed homepage.
The application key has been generated. The blog compatibility migration has
been applied and all migrations are current. It handles both legacy and current
schemas without overwriting blog content. Its rollback intentionally preserves
columns and data because the create migration already owns the current schema.

`php artisan route:list` also exposes an existing incomplete API configuration:
`routes/api.php` references a missing `App\Http\Controllers\AdminController`
for `/api/hospital`, `/api/data-gps`, `/api/alldata`, and `/api/search`.
Restore that controller before using those endpoints or completing route checks.

## Deployment checks

Back up the database, install the locked dependencies on a PHP 8.3+ server,
clear stale configuration, and restart long-running workers. Verify admin and
hospital login, password resets, hospital searches, blog uploads, and Exotel
callbacks against staging data before deploying to production.

References: [Laravel 11](https://laravel.com/docs/11.x/upgrade),
[Laravel 12](https://laravel.com/docs/12.x/upgrade), and
[Laravel 13](https://laravel.com/docs/13.x/upgrade) upgrade guides.
