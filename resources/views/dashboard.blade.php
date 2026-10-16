{{-- sementara, tampilan nanti dibikin frontend sesuai figma --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - {{ config('app.name') }}</title>
</head>
<body>
    <h1>Selamat datang, {{ auth()->user()->name }}</h1>
    <p>Role: {{ auth()->user()->role->name }}</p>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
