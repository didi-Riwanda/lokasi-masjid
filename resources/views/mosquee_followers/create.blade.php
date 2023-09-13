<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create Followers</title>
</head> 
<body>
    <form action="{{ route('mosquee_followers.store') }}" method="POST">
        @csrf
        <input type="hidden" name="uuid" id="uuid">
        <select name="mosquee_id" id="mosquee_id">
                <option>--Select--</option>
            @foreach ($all_mosquee as $mosquees)
                <option value="{{ $mosquees->id }}">{{ $mosquees->name }}</option>
            @endforeach
        </select>

        {{-- <select name="user_id" id="user_id">
                <option>--Select--</option>
            @foreach ($all_user as $users)
                <option value="{{ $users->id }}">{{ $users->name }}</option>
            @endforeach
        </select> --}}

        <button>Save</button>
    </form>
</body>
</html>