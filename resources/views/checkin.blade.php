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
  <h1>List of checkin:</h1>
  <div>
    <table>
      <tr>
        <th>Index</th>
        <th>Booking id</th>
        <th>Employee id</th>
        <th>Checkin time</th>
        <th>Checkout time</th>
        <th>Fee</th>
        <th>Total price</th>
      </tr>
      @foreach ($datas as $index => $data)
      <tr>
        <td>{{ $index }}</td>
        <td>{{ $data->id }}</td>
        <td>{{ $data->employee_id }}</td>
        <td>{{ $data->checkin_time }}</td>
        <td>{{ $data->checkout_time }}</td>
        <td>{{ $data->fee }}</td>
        <td>{{ $data->total_price }}</td>
        <td><button onclick="window.location.href='{{route('checkout',['id'=>$id=$data->id])}}'">Checkout</button></td>
        <td><button onclick="window.location.href='{{route('delCheck',['id'=>$id=$data->id])}}'">Delete</button></td>
        <td>
          <form action="checked/addFee" method="POST">
            @csrf
            <input type="text" id="fee" name="fee" placeholder="addFee">
            <input value="{{$data->id}}" name="id" hidden>
            @if($errors->has('fee'))
              <div class="error">{{ $errors->first('fee') }}</div>
            @endif
            <button type="submit">Submit</button>
          </form>
        </td>
      </tr>
      @endforeach
    </table>
  </div>
  @include('footer')
</body>

</html>
