<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Followers</title>
</head> 
<body>
    <form action="{{ route('mosquee_followers.update', $old_data->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="uuid" id="uuid">
        <select name="mosquee_id" id="mosquee_id">
                    <option>--Select--</option>
            @foreach ($all_mosquee as $mosquees)
                @if (old('mosquee_id', $old_data->mosquee_id) == $mosquees->id)
                    <option value="{{ $mosquees->id }}" selected>{{ $mosquees->name }}</option>
                @else
                    <option value="{{ $mosquees->id }}">{{ $mosquees->name }}</option>
                @endif
            @endforeach
        </select>

        {{-- <select name="user_id" id="user_id">
                <   option>--Select--</option>
            @foreach ($all_user as $users)
                @if ( $old_data->user_id == $users->id)
                    <option value="{{ $users->id }}" selected>{{ $users->name }}</option>
                @else
                    <option value="{{ $users->id }}">{{ $users->name }}</option>
                @endif
            @endforeach
        </select> --}}

        <button>Update</button>
    </form>
</body>
</html>