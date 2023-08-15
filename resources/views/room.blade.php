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
  <h1>List of room: </h1>
  <div>
    <table>
      <tr>
        <th>Index</th>
        <th>Room id</th>
        <th>Room name</th>
        <th>Type</th>
        <th>Hour price</th>
        <th>Day price</th>
        <th>Status</th>
        <th>Size</th>
        <th>Balcony</th>
        <th>View</th>
        <th>Smoking</th>
        <th>Floor</th>
        <th>Bathtub</th>
      </tr>
      @foreach ($datas as $index => $data)
      <tr>
        <td>{{ $index }}</td>
        <td>{{ $data->id }}</td>
        <td>{{ $data->name }}</td>
        <td>{{ $data->type }}</td>
        <td>{{ $data->hour_price }}</td>
        <td>{{ $data->day_price }}</td>
        <td>{{ $data->status }}</td>
        <td>{{ $data->size }}</td>
        <td>{{ $data->balcony }}</td>
        <td>{{ $data->view }}</td>
        <td>{{ $data->smoking }}</td>
        <td>{{ $data->floor }}</td>
        <td>{{ $data->bathtub }}</td>
        <td><button onclick="window.location.href='{{route('modify',['id'=>$id = $data->id])}}'">Modify</button></td>
        @endforeach
      </tr>
    </table>
  </div>
@include('footer')
</body>

</html>
