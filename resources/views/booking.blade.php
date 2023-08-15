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
  <h1>List of booking:</h1>
  <div>
    <table>
      <tr>
        <th>Booking number</th>
        <th>Booking ID</th>
        <th>Guest name</th>
        <th>Guest number</th>
        <th>Room id</th>
        <th>Checked</th>
      </tr>
      @foreach ($datas as $index => $data)
        @if($data->checked==0)
        <tr>
          <td>{{ $index }}</td>
          <td>{{ $data->id }}</td>
          <td>{{ $data->guest_name }}</td>
          <td>{{ $data->guest_number }}</td>
          <td>{{ $data->room_id }}</td>
          <td>{{ $data->checked }}</td>
          <td><button onclick="window.location.href='{{route('checked',['id'=>$id=$data->id])}}'">Checkin</button></td>
          <td><button onclick="window.location.href='{{route('delBook',['id'=>$id=$data->id])}}'">Delete</button></td>
        </tr>
        @endif
      @endforeach
    </table>
  </div>
  <div>
    <button onclick="window.location.href='{{route('createBooking')}}'">Create booking</button>
  </div>
  @include('footer')
</body>

</html>
