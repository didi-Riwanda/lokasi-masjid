<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mosquee Shared Create</title>
</head>
<body>
    <form action="{{ route('mosquee_shared.store') }}" method="POST">
        @csrf

        {{-- <input type="hidden" name="user_id" id="user_id"> 
        <input type="hidden" name="ip_address" id="ip_address">  --}}

        <button>Save</button>
    </form>
</body>
</html>