# Superheroes

Activity 8 — CRUD demo in Laravel 7

Small Laravel 7 application implementing a CRUD system to register and manage superheroes. Each record contains:
- **real_name** — superhero's real name  
- **hero_name** — name by which the superhero is known  
- **photo_url** — URL to the superhero's photo  
- **description** — additional information

Program description
- Web interface to create new superhero records using a form.
- List view that shows all superheroes with pagination.
- Detail view for each superhero, showing the photo (if a URL is provided) and full description.
- Edit form to update existing superhero records.
- Delete action to remove records from the database.
- Implemented using MVC: Eloquent models, a resource controller, Blade views and Laravel migrations.

Main project structure
- Model: `app/Superhero.php`  
- Migration: `database/migrations/*_create_superheroes_table.php`  
- Resource controller: `app/Http/Controllers/SuperheroController.php`  
- Blade views: `resources/views/superheroes/` (`index`, `create`, `show`, `edit`)  
- Layout: `resources/views/layouts/app.blade.php`  
- Routes: `routes/web.php` (`Route::resource('superheroes', 'SuperheroController')`)

Quick setup summary
1. Clone the repository:
```
git clone https://github.com/<your-username>/superheroes.git
cd superheroes
```
2. Install PHP dependencies:
```
composer install
```
3. (Optional) Install JS dependencies and compile assets:
```
npm install
npm run dev
```
4. Configure environment:
```
cp .env.example .env
php artisan key:generate
```
Edit `.env` to set your database connection.

5. Create the database and run migrations:
```
# example using MySQL
mysql -u root -e "CREATE DATABASE IF NOT EXISTS superheroes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
php artisan migrate
```
6. Start the development server:
```
php artisan serve
```
Open the URL shown by the command and navigate to `/superheroes`.

End of README
