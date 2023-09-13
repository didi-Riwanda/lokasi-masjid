<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create</title>
</head>
<body>
    <form action="{{ route('mosquee.store') }}" method="POST">
        @csrf

        <input type="hidden" name="uuid" id="uuid">
        <input type="text" name="name" id="name"> <label for="name">Name of the Mosquee</label> <br>
        <input type="text" name="addrees" id="addrees"> <label for="addrees">Address</label> <br>
        <input type="text" name="street" id="street"> <label for="street">Street</label> <br>
        <input type="text" name="subdistrict" id="subdistrict"> <label for="subdistrict">Subdistrict</label> <br>
        <input type="text" name="city" id="city"> <label for="city">City</label> <br>
        <input type="text" name="province" id="province"> <label for="province">Province</label> <br>
        <input type="text" name="latitude" id="latitude"> <label for="latitude">Latitude</label> <br>
        <input type="text" name="longtitude" id="longtitude"> <label for="longtitude">Longtitude</label> <br>
        <input type="text" name="followers" id="followers"> <label for="followers">Followers</label> <br>
        <input type="text" name="shareds" id="shareds"> <label for="shareds">Shareds</label> <br>

        <button type="submit">Save</button>
    </form>
</body>
</html>