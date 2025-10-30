<?php

namespace App\Http\Controllers;

use App\Superhero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SuperheroController extends Controller
{
    public function index()
    {
        // Only active (not trashed) records
        $superheroes = Superhero::orderBy('id', 'desc')->paginate(10);
        return view('superheroes.index', compact('superheroes'));
    }

    public function create()
    {
        return view('superheroes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'real_name' => 'required|max:150',
            'hero_name' => 'required|max:150',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photo_url' => 'nullable|url',
            'description'=> 'nullable',
        ]);

        // Prefer uploaded file if provided; otherwise allow external URL (legacy)
        $path = null;
        if ($request->hasFile('photo')) {
            // Stores in storage/app/public/Avatars and returns relative path "Avatars/filename.ext"
            $path = Storage::disk('public')->put('Avatars', $request->file('photo'));
        } elseif (!empty($validated['photo_url'])) {
            // If you want to keep external URLs: store the URL as-is (but Activity 10 requests local storage)
            // We'll store external URL only if no uploaded file is provided
            $path = $validated['photo_url'];
        }

        Superhero::create([
            'real_name' => $validated['real_name'],
            'hero_name' => $validated['hero_name'],
            'photo_url' => $path, // store relative path (Avatars/...) or external URL
            'description'=> $validated['description'] ?? null,
        ]);

        return redirect()->route('superheroes.index')->with('success', 'Superhero created successfully');
    }

    public function show($id)
    {
        $superhero = Superhero::findOrFail($id);
        return view('superheroes.show', compact('superhero'));
    }

    public function edit($id)
    {
        $superhero = Superhero::findOrFail($id);
        return view('superheroes.edit', compact('superhero'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'real_name' => 'required|max:150',
            'hero_name' => 'required|max:150',
            'photo'     => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photo_url' => 'nullable|url',
            'description'=> 'nullable',
        ]);

        $superhero = Superhero::findOrFail($id);

        // If new file uploaded, store it and update photo_url with relative path.
        if ($request->hasFile('photo')) {
            $path = Storage::disk('public')->put('Avatars', $request->file('photo'));
            // Activity 10 requires not deleting files on soft-delete; also we keep old files (do not delete here)
            $superhero->photo_url = $path;
        } elseif (!empty($validated['photo_url'])) {
            // If user supplies an external URL and no file uploaded, update to that URL
            $superhero->photo_url = $validated['photo_url'];
        }

        $superhero->real_name = $validated['real_name'];
        $superhero->hero_name = $validated['hero_name'];
        $superhero->description = $validated['description'] ?? null;
        $superhero->save();

        return redirect()->route('superheroes.index')->with('success', 'Superhero updated successfully');
    }

    public function destroy($id)
    {
        // Soft delete: ensure your model uses SoftDeletes trait
        $superhero = Superhero::findOrFail($id);
        $superhero->delete(); // file is NOT deleted from storage per Activity 10
        return redirect()->route('superheroes.index')->with('success', 'Superhero deleted successfully');
    }

    /**
     * Show trashed (soft deleted) records
     */
    public function trashed()
    {
        $deleted = Superhero::onlyTrashed()->orderBy('deleted_at', 'desc')->paginate(10);
        return view('superheroes.trashed', compact('deleted'));
    }

    /**
     * Restore a soft deleted record
     */
    public function restore($id)
    {
        $superhero = Superhero::onlyTrashed()->findOrFail($id);
        $superhero->restore();
        return redirect()->route('superheroes.trashed')->with('success', 'Superhero restored successfully');
    }

    /**
     * Permanently delete a trashed record (optional)
     * If you use this, consider deleting the associated file manually here.
     */
    public function forceDelete($id)
    {
        $superhero = Superhero::onlyTrashed()->findOrFail($id);
        // If you want to remove the stored file when permanently deleting:
        if ($superhero->photo_url && !filter_var($superhero->photo_url, FILTER_VALIDATE_URL)) {
            // Only delete physical file if the stored value is a relative path (not an external URL)
            Storage::disk('public')->delete($superhero->photo_url);
        }
        $superhero->forceDelete();
        return redirect()->route('superheroes.trashed')->with('success', 'Superhero permanently deleted');
    }
}
