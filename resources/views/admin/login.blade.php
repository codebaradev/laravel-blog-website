<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="errors-container">
        @error('login')
            <p>{{ $message }}</p>
        @enderror
    </div>
    <form action="" method="post">
        @csrf
        <label for="email_username">Email or Username</label>
        <input type="text" name="email_username" id="email_username" value="{{old('email_username')}}">
        @error('email_username')
            <p>{{ $message }}</p>
        @enderror

        <label for="password">Password</label>
        <input type="text" name="password" id="password" value="{{old('password')}}">
        @error('password')
            <p>{{ $message }}</p>
        @enderror

        <button type="submit">Login</button>
    </form>
</body>
</html>
