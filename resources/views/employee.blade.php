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
  <h1>List of Employee:</h1>
  <div>
    <table>
      <tr>
        <th>Index</th>
        <th>Employee id</th>
        <th>Employee name</th>
        <th>Role</th>
        <th>Status</th>
        <th>Shift</th>
        <th>Day off</th>
        <th>salary</th>
      </tr>
      @foreach ($datas as $index => $data)
      <tr>
        <td>{{ $index }}</td>
        <td>{{ $data->id }}</td>
        <td>{{ $data->name }}</td>
        <td>{{ $data->role }}</td>
        <td>{{ $status[$index] }}</td>
        <td>{{ $data->shift }}</td>
        <td>{{ $data->day_off }}</td>
        <td>{{ $data->salary }}</td>
      </tr>
      @endforeach
    </table>
  </div>
  @include('footer')
</body>

</html>
