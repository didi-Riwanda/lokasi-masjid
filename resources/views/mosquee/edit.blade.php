<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit</title>
</head>
<body>
    <form action="{{ route('mosquee.update', $old_mosquee->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="uuid" id="uuid">
        <input type="text" name="name" id="name" value="{{ $old_mosquee->name }}"> <label for="name">Name of the Mosquee</label> <br>
        <input type="text" name="addrees" id="addrees" value="{{ $old_mosquee->addrees }}"> <label for="addrees">Address</label> <br>
        <input type="text" name="street" id="street" value="{{ $old_mosquee->street }}"> <label for="street">Street</label> <br>
        <input type="text" name="subdistrict" id="subdistrict" value="{{ $old_mosquee->subdistrict }}"> <label for="subdistrict">Subdistrict</label> <br>
        <input type="text" name="city" id="city" value="{{ $old_mosquee->city }}"> <label for="city">City</label> <br>
        <input type="text" name="province" id="province" value="{{ $old_mosquee->province }}"> <label for="province">Province</label> <br>
        <input type="text" name="latitude" id="latitude" value="{{ $old_mosquee->latitude }}"> <label for="latitude">Latitude</label> <br>
        <input type="text" name="longtitude" id="longtitude" value="{{ $old_mosquee->longtitude }}"> <label for="longtitude">Longtitude</label> <br>
        <input type="text" name="followers" id="followers" value="{{ $old_mosquee->followers }}"> <label for="followers">Followers</label> <br>
        <input type="text" name="shareds" id="shareds" value="{{ $old_mosquee->shareds }}"> <label for="shareds">Shareds</label> <br>

        <button type="submit">Update</button>
    
    </form>
</body>
</html>