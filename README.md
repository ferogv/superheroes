# Superheroes

Activity 8 → Activity 10 — CRUD + Local File Storage and Soft Deletes (Laravel 7)

Small Laravel 7 application that implements a CRUD system to register and manage superheroes. This README describes the updates added for Activity 10: local file storage for photos, logical deletion (soft deletes), and views for managing and restoring deleted records.

Summary of new features (Activity 10)
- Photo storage: photos are uploaded and saved to local storage (storage/app/public). Database stores the storage path (relative) rather than external URLs. Views render images via the storage asset helper.
- Public storage link: a symbolic link public/storage → storage/app/public is required so stored files are web-accessible.
- Soft deletes: the `superheroes` table supports soft deletes (uses `deleted_at` timestamp). Index shows only active records.
- Trash view and restore: added views/actions to list logically deleted records and restore them.
- Files on disk are not removed by delete operations (soft delete preserves file). When a record is permanently removed you may optionally delete its file from disk.

Files and locations changed or added
- Model
  - `app/Superhero.php` — added `use Illuminate\Database\Eloquent\SoftDeletes;` and `$dates`/`$fillable` updates.
- Migrations
  - `database/migrations/*_create_superheroes_table.php` — added `picture` column (string) and `softDeletes()` call (adds `deleted_at`).
  - If you already ran migrations before Activity 10, a new migration was added to add the `picture` column and `deleted_at` (example: `2025_xx_xx_add_picture_and_softdeletes_to_superheroes.php`).
- Controller
  - `app/Http/Controllers/SuperheroController.php` — updated `store` and `update` to handle file uploads via `Storage::disk('public')->putFile(...)`; added `trash()`, `restore($id)`, and `forceDelete($id)` actions as needed.
- Views (Blade)
  - `resources/views/superheroes/create.blade.php` — file input added; form uses `enctype="multipart/form-data"`.
  - `resources/views/superheroes/edit.blade.php` — file input added; shows current avatar preview.
  - `resources/views/superheroes/show.blade.php` — renders image using `asset('storage/'.$superhero->picture)`.
  - `resources/views/superheroes/index.blade.php` — lists active records and optionally shows thumbnail.
  - `resources/views/superheroes/trash.blade.php` — new view that lists soft-deleted records with a Restore button.
- Routes
  - `routes/web.php` — `Route::resource('superheroes', 'SuperheroController');` plus routes for trash/restore/forceDelete, for example:
    - `GET /superheroes/trash` → `SuperheroController@trash`
    - `PATCH /superheroes/{id}/restore` → `SuperheroController@restore`
    - `DELETE /superheroes/{id}/force` → `SuperheroController@forceDelete`
- Storage
  - Ensure `config/filesystems.php` has `public` disk (default) and that `links` configuration is appropriate.

Quick setup / upgrade steps (after pulling the updated repo)
1. Install dependencies (if needed)
```bash
composer install
npm install   # optional, for assets
npm run dev   # optional
```

2. Copy env and set DB credentials
```bash
cp .env.example .env
php artisan key:generate
# edit .env DB_* values
```

3. Create or migrate database
- If this is a fresh setup:
```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS superheroes CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
php artisan migrate
```
- If upgrading an existing DB and a new migration was added:
```bash
php artisan migrate
```

4. Create public storage symlink
```bash
php artisan storage:link
```

5. Run the application
```bash
php artisan serve
# visit: http://127.0.0.1:8000/superheroes
```

How photo upload is handled (implementation notes)
- Forms:
  - `create` and `edit` forms use `enctype="multipart/form-data"` and include:
    `<input type="file" name="picture">`
- Controller (store/update):
  - Validate `picture` as `image|mimes:jpeg,png,jpg,gif,svg|max:2048` (or as required).
  - On upload:
    ```php
    if ($request->hasFile('picture')) {
        $path = $request->file('picture')->store('avatars', 'public'); // returns relative path like "avatars/abc.jpg"
    } else {
        $path = null; // or default placeholder
    }
    $superhero->picture = $path;
    ```
  - Save the relative path to DB; display via `asset('storage/'.$superhero->picture)`.
- Soft deletes:
  - Model uses `SoftDeletes`; migration calls `$table->softDeletes();`
  - Deleting from index runs `$superhero->delete();` which sets `deleted_at` (file remains on disk).
  - Restore runs `$superhero->restore();`
  - Force delete runs `$superhero->forceDelete();` and may remove file from disk via `Storage::disk('public')->delete($superhero->picture)` if desired.

Views added/changed for Activity 10
- `resources/views/superheroes/create.blade.php` — file input and instructions for image.
- `resources/views/superheroes/edit.blade.php` — file input, current image preview.
- `resources/views/superheroes/index.blade.php` — lists active records only.
- `resources/views/superheroes/trash.blade.php` — lists deleted records with Restore/Force Delete actions.
- `resources/views/superheroes/show.blade.php` — displays stored image via `asset('storage/'.$entity->picture)`.
