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
  <form action="modify" method="POST">
    @csrf
    <label for="name">Room name</label>
    <input type="text" id="name" name="name"><br><br>
    <label for="type">Type</label>
    <input type="text" id="type" name="type"><br><br>
    <label for="hour_price">Hour price</label>
    <input type="text" name="hour_price" id="hour_price"><br><br>
    <label for="day_price">Day price</label>
    <input type="text" name="day_price" id="day_price"><br><br>
    <label for="size">Size</label>
    <input type="number" name="size" id="size"><br><br>
    <label for="">Balcony</label>
    <input type="radio" name="balcony" id="true" value="true">
    <label for="true">True</label>
    <input type="radio" name="balcony" id="false" value="false">
    <label for="false">False</label><br><br>
    <label for="view">View</label>
    <input type="text" id="view" name="view"><br><br>
    <label for="">Smoking</label>
    <input type="radio" name="smoking" id="true" value="true">
    <label for="true">True</label>
    <input type="radio" name="smoking" id="false" value="false">
    <label for="false">False</label><br><br>
    <label for="floor">Floor</label>
    <input type="number" name="floor" id="floor"><br><br>
    <label for="">Bathtub</label>
    <input type="radio" name="bathtub" id="true" value="true">
    <label for="true">True</label>
    <input type="radio" name="bathtub" id="false" value="false">
    <label for="false">False</label><br><br>
    <input type="text" name="id" value={{$_GET['id']}} hidden>
    <button type="submit">Submit</button>
  </form>
  @include('footer')
</body>

</html>
