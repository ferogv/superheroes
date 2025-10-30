@extends('layouts.app')

@section('content')
<h1>Edit Superhero</h1>

@if ($errors->any())
  <div class="alert alert-danger">
    <ul>@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
  </div>
@endif

<form action="{{ route('superheroes.update', $superhero->id) }}" method="POST" enctype="multipart/form-data">
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
    <label>Current Photo</label><br>
    @php
      $isExternal = $superhero->photo_url && \Illuminate\Support\Str::startsWith($superhero->photo_url, ['http://','https://']);
      $currentSrc = $superhero->photo_url ? ($isExternal ? $superhero->photo_url : asset('storage/'.$superhero->photo_url)) : asset('storage/defaults/avatar.png');
    @endphp
    <img src="{{ $currentSrc }}" alt="current" style="height:100px; object-fit:cover;">
  </div>

  <div class="form-group">
    <label>Upload New Photo (optional)</label>
    <input type="file" name="photo" accept="image/*" class="form-control">
    <small class="form-text text-muted">If a file is uploaded it will replace the DB value; old file will not be deleted (soft-delete policy).</small>
  </div>

  <div class="form-group">
    <label>Photo URL (optional)</label>
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
