
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  @include('header')
  <!-- make login form -->
  <h1>Login</h1>
    <form action="login" method="POST">
        @csrf
        <label for="username">Username</label>
        <input type="text" id="username" name="username"><br><br>
        @if ($errors->has('username'))
        <div class="error">{{ $errors->first('username') }}</div>
        @endif
    
        <label for="password">Password</label>
        <input type="text" name="password" id="password">
        @if ($errors->has('password'))
        <div class="error">{{ $errors->first('password') }}</div>
        @endif
        <button type="submit">Login</button>
    </form>
    <button type="submit" onclick="window.location.href='{{route('register.show')}}'">Register</a></button>
  @include('footer')
</body>

</html>
