@extends('layouts.app')

@section('content')
<h1>Superheroes</h1>

<div class="mb-3">
  <a href="{{ route('superheroes.create') }}" class="btn btn-success">Add new</a>
  <a href="{{ route('superheroes.trashed') }}" class="btn btn-secondary">View trashed</a>
</div>

<table class="table table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>Real Name</th>
      <th>Hero Name</th>
      <th>Photo</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    @forelse($superheroes as $hero)
      <tr>
        <td>{{ $hero->id }}</td>
        <td><a href="{{ route('superheroes.show', $hero->id) }}">{{ $hero->real_name }}</a></td>
        <td>{{ $hero->hero_name }}</td>
        <td>
          @if($hero->photo_url)
            @php
              $isExternal = \Illuminate\Support\Str::startsWith($hero->photo_url, ['http://', 'https://']);
              $imgSrc = $isExternal ? $hero->photo_url : asset('storage/' . $hero->photo_url);
            @endphp
            <img src="{{ $imgSrc }}" alt="{{ $hero->hero_name }}" style="height:50px; object-fit:cover;">
          @else
            <img src="{{ asset('storage/defaults/avatar.png') }}" alt="no avatar" style="height:50px; object-fit:cover;">
          @endif
        </td>
        <td>
          <a class="btn btn-sm btn-primary" href="{{ route('superheroes.edit', $hero->id) }}">Edit</a>

          <form action="{{ route('superheroes.destroy', $hero->id) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Delete superhero?')">Delete</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="5" class="text-center">No superheroes yet.</td></tr>
    @endforelse
  </tbody>
</table>

{{ $superheroes->links() }}
@endsection
