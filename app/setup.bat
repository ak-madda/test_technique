@echo off
echo Setting up Laravel backend with SQLite on Windows...

REM Installer les dépendances Composer
composer install

REM Créer le fichier de base de données SQLite
if not exist database\database.sqlite (
    type nul > database\database.sqlite
    echo Created database/database.sqlite
) else (
    echo Database file already exists
)

REM Copier le fichier d'environnement s'il n'existe pas
if not exist .env (
    copy .env.example .env
    echo Copied .env.example to .env
) else (
    echo .env file already exists
)

REM Configurer la base de données SQLite dans .env
echo Configuring .env for SQLite...
powershell -Command "(Get-Content .env) -replace 'DB_CONNECTION=mysql', 'DB_CONNECTION=sqlite' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace 'DB_HOST=127.0.0.1', '# DB_HOST=127.0.0.1' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace 'DB_PORT=3306', '# DB_PORT=3306' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace 'DB_DATABASE=.*', '# DB_DATABASE=' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace 'DB_USERNAME=.*', '# DB_USERNAME=' | Set-Content .env"
powershell -Command "(Get-Content .env) -replace 'DB_PASSWORD=.*', '# DB_PASSWORD=' | Set-Content .env"

REM Générer la clé d'application
php artisan key:generate

REM Exécuter les migrations
php artisan migrate --force

REM Exécuter les seeders
php artisan db:seed --force

REM Vider les caches
php artisan view:clear
php artisan cache:clear
php artisan config:clear
php artisan route:clear

echo.
echo Setup completed successfully!
echo Database file: database\database.sqlite
echo You can now start the server with: php artisan serve
pause