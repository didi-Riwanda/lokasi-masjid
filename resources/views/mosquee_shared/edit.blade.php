<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mosquee Shared Update</title>
</head>
<body>
    
    <form action="{{ route('mosquee_shared.update', $old_data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="user_id" id="user_id"> {{-- <label for="user_id">User Id</label> --}} 
        <input type="text" name="ip_address" id="ip_address" value="{{ $old_data->ip_address }}"> <label for="ip_address">Ip Address</label>

        <button>Update</button>
    </form>
</body>
</html>