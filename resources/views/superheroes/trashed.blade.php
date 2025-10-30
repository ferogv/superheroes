@extends('layouts.app')

@section('content')
<h1>Trashed Superheroes</h1>

<a href="{{ route('superheroes.index') }}" class="btn btn-secondary mb-2">Back to active</a>

<table class="table">
  <thead>
    <tr><th>Avatar</th><th>Real Name</th><th>Hero Name</th><th>Deleted At</th><th>Actions</th></tr>
  </thead>
  <tbody>
    @forelse($deleted as $d)
      <tr>
        <td>
          @php
            $isExternal = $d->photo_url && \Illuminate\Support\Str::startsWith($d->photo_url, ['http://','https://']);
            $src = $d->photo_url ? ($isExternal ? $d->photo_url : asset('storage/'.$d->photo_url)) : asset('storage/defaults/avatar.png');
          @endphp
          <img src="{{ $src }}" width="60" style="object-fit:cover;">
        </td>
        <td>{{ $d->real_name }}</td>
        <td>{{ $d->hero_name }}</td>
        <td>{{ $d->deleted_at }}</td>
        <td>
          <form action="{{ route('superheroes.restore', $d->id) }}" method="POST" style="display:inline">
            @csrf
            <button class="btn btn-sm btn-success">Restore</button>
          </form>

          <form action="{{ route('superheroes.forceDelete', $d->id) }}" method="POST" style="display:inline">
            @csrf
            @method('DELETE')
            <button class="btn btn-sm btn-danger" onclick="return confirm('Permanently delete?')">Delete permanently</button>
          </form>
        </td>
      </tr>
    @empty
      <tr><td colspan="5" class="text-center">No trashed records.</td></tr>
    @endforelse
  </tbody>
</table>

{{ $deleted->links() }}
@endsection
