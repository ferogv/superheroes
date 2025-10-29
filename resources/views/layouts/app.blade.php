<!doctype html>
<html lang="en">
<head>
  <!-- Bootstrap 4 CDN + Font Awesome -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="{{ route('superheroes.index') }}">Superheroes</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="mainNav">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link btn btn-success text-white ml-2" href="{{ route('superheroes.create') }}">
          <i class="fas fa-plus"></i> Add
        </a>
      </li>
    </ul>
    <span class="navbar-text text-muted">Total: {{ \App\Superhero::count() }}</span>
  </div>
</nav>
<div class="container mt-4">
  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @yield('content')
</div>
</body>
</html>