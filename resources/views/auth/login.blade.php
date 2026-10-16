{{-- sementara, tampilan nanti dibikin frontend sesuai figma --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name') }}</title>
</head>
<body>
    <h1>Login</h1>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <label>Email</label>
        <input type="email" name="email" value="{{ old('email') }}">
        @error('email') <p>{{ $message }}</p> @enderror

        <label>Password</label>
        <input type="password" name="password">
        @error('password') <p>{{ $message }}</p> @enderror

        <button type="submit">LOGIN</button>
    </form>
</body>
</html>
