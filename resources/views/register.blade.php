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
    <h1>Register</h1>
  <form action="register" method="POST">
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
    <label for="confirm_password">Confirm Password</label>
    <input type="text" name="confirm_password" id="confirm_password">
    @if ($errors->has('confirm_password'))
      <div class="error">{{ $errors->first('confirm_password') }}</div>
    @endif
    <label for="email">Email</label>
    <input type="email" name="email" id="email">
    @if ($errors->has('email'))
      <div class="error">{{ $errors->first('email') }}</div>
    @endif
    <button type="submit">Submit</button>
  </form>
  @include('footer')
</body>

</html>
