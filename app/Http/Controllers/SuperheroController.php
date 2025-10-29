<?php

namespace App\Http\Controllers;

use App\Superhero;
use Illuminate\Http\Request;

class SuperheroController extends Controller
{
    public function index()
    {
        $superheroes = Superhero::orderBy('id','desc')->paginate(10);
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
            'photo_url' => 'nullable|url',
            'description' => 'nullable',
        ]);

        Superhero::create($validated);

        return redirect()->route('superheroes.index')->with('success','Superhero created successfully');
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
            'photo_url' => 'nullable|url',
            'description' => 'nullable',
        ]);

        Superhero::whereId($id)->update($validated);

        return redirect()->route('superheroes.index')->with('success','Superhero updated successfully');
    }

    public function destroy($id)
    {
        $superhero = Superhero::findOrFail($id);
        $superhero->delete();

        return redirect()->route('superheroes.index')->with('success','Superhero deleted successfully');
    }
}