@extends('layouts.app')

@section('content')
<h1>Edit Superhero</h1>
@if ($errors->any())
  <div class="alert alert-danger">
    <ul>@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
  </div>
@endif
<form action="{{ route('superheroes.update', $superhero->id) }}" method="POST">
  @csrf
  @method('PATCH')
  <div class="form-group">
    <label>Real Name</label>
    <input type="text" name="real_name" class="form-control" value="{{ old('real_name', $superhero->real_name) }}" required>
  </div>
  <div class="form-group">
    <label>Hero Name</label>
    <input type="text" name="hero_name" class="form-control" value="{{ old('hero_name', $superhero->hero_name) }}" required>
  </div>
  <div class="form-group">
    <label>Photo URL</label>
    <input type="url" name="photo_url" class="form-control" value="{{ old('photo_url', $superhero->photo_url) }}">
  </div>
  <div class="form-group">
    <label>Additional Info</label>
    <textarea name="description" class="form-control">{{ old('description', $superhero->description) }}</textarea>
  </div>
  <button class="btn btn-primary" type="submit">Save</button>
  <a class="btn btn-secondary" href="{{ route('superheroes.index') }}">Cancel</a>
</form>
@endsection