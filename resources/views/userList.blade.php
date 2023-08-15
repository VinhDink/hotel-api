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
      <h1>List of user:</h1>
      <div>
     <table>
        <tr>
          <th>Index</th>
          <th>Username</th>
          <th>Password</th>
          <th>Role</th>
        </tr>
        @foreach ($datas as $index => $data)
        <tr>
          <td>{{ $index }}</td>
          <td>{{ $data->username }}</td>
          <td>{{ $data->password }}</td>
          <td>{{ $data->role }}</td>
          <td><button onclick="window.location.href='{{route('userDestroy',['id'=>$id=$data->id])}}'">Delete</button></td>
        </tr>
        @endforeach
     </table>
      </div>
      @include('footer')

</body>
