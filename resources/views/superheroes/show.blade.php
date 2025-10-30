@extends('layouts.app')

@section('content')
<h1>{{ $superhero->hero_name }}</h1>
<p><strong>Real name:</strong> {{ $superhero->real_name }}</p>

@php
  $isExternal = $superhero->photo_url && \Illuminate\Support\Str::startsWith($superhero->photo_url, ['http://','https://']);
  $showSrc = $superhero->photo_url ? ($isExternal ? $superhero->photo_url : asset('storage/'.$superhero->photo_url)) : asset('storage/defaults/avatar.png');
@endphp

<p><img src="{{ $showSrc }}" alt="" style="max-width:300px; object-fit:cover;"></p>

@if($superhero->description)
  <p><strong>Info:</strong> {!! nl2br(e($superhero->description)) !!}</p>
@endif

<a class="btn btn-secondary" href="{{ route('superheroes.index') }}">Back</a>
<a class="btn btn-primary" href="{{ route('superheroes.edit', $superhero->id) }}">Edit</a>
@endsection
