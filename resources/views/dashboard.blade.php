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
  <h1>Dashboard</h1>
  <!--create table dashboard -->
  <h3>Total guest today: {{ $today }}</h3>
  <h3>Total guest last 7 days: {{ $last_7_days }}</h3>
  <h3>All checkin today: </h3>
  <table>
    <tr>
      <th>Booking id</th>
      <th>Guest name</th>
      <th>Guest number</th>
      <th>Room id</th>
      <th>Interest</th>
    </tr>
    @foreach ($guest_infos as $index => $info)
    <tr>
      <td>{{ $info->id }}</td>
      <td>{{ $info->guest_name }}</td>
      <td>{{ $info->guest_number }}</td>
      <td>{{ $info->room_id }}</td>
      <td>{{ $info->total_price }}</td>
    </tr>
    @endforeach
  </table>
  <h3>Today's total interest: {{ $total }} </h3>
  <h3>Current month total checkin: {{ $last_month }}</h3>
  <h3>Current month total interest: {{ $last_month_total }}</h3>
  @include('footer')
</body>

</html>
