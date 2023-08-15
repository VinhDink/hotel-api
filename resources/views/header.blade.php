<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>ABC Hotel</h1>
  <button onclick="window.location.href='{{route('booking')}}'"> View booking</button>
  <button onclick="window.location.href='{{route('checkin')}}'"> View checkin</button>
  <button onclick="window.location.href='{{route('employee')}}'"> View employee</button>
  <button onclick="window.location.href='{{route('room')}}'"> View room</button>
  <button onclick="window.location.href='{{route('dashboard')}}'"> View dashboard</button>
  <button onclick="window.location.href='{{route('logout')}}'"> Logout</button>
  @auth
    @if (auth()->user()->role == 'admin')
      <button onclick="window.location.href='{{route('userList')}}'"> User list</button>
    @endif
  @endauth
</body>
<h1>--------------------------------------------------------------------------------------------------------------------------</h1>

</html>
