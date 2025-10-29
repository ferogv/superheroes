@extends('layouts.app')

@section('content')
<h1>Superheroes</h1>
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
            <img src="{{ $hero->photo_url }}" alt="" style="height:50px;">
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
      <tr><td colspan="5">No superheroes yet.</td></tr>
    @endforelse
  </tbody>
</table>

{{ $superheroes->links() }}
@endsection