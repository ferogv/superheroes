@extends('layouts.app')

@section('content')
<h1>{{ $superhero->hero_name }}</h1>
<p><strong>Real name:</strong> {{ $superhero->real_name }}</p>
@if($superhero->photo_url)
  <p><img src="{{ $superhero->photo_url }}" alt="" style="max-width:300px;"></p>
@endif
@if($superhero->description)
  <p><strong>Info:</strong> {!! nl2br(e($superhero->description)) !!}</p>
@endif
<a class="btn btn-secondary" href="{{ route('superheroes.index') }}">Back</a>
<a class="btn btn-primary" href="{{ route('superheroes.edit', $superhero->id) }}">Edit</a>
@endsection