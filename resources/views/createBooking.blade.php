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
  <form action="add" method="POST">
    @csrf
    <label for="guest_name">Guest name</label>
    <input type="text" id="guest_name" name="guest_name"><br><br>
    @if ($errors->has('guest_name'))
      <div class="error">{{ $errors->first('guestName') }}</div>
    @endif
    <label for="guest_number">Guest number</label>
    <input type="text" id="guest_number" name="guest_number"><br><br>
    @if ($errors->has('guest_number'))
      <div class="error">{{ $errors->first('guest_number') }}</div>
    @endif
    <label for="room_id">Room ID</label>
    <input type="text" name="room_id" id="room_id">
    @if ($errors->has('room_id'))
      <div class="error">{{ $errors->first('room_id') }}</div>
    @endif
    <button type="submit">Submit</button>
  </form>
  @include('footer')
</body>

</html>
