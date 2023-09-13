<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mosquee Followers</title>
</head>
<body>

    <a href="{{ route('mosquee_followers.create') }}">Create</a>
    <ul>
        @foreach ($all_mosquee_follower as $mosquee_followers)
        <li>{{ $mosquee_followers->mosquee->name }}</li>
        {{-- <li>{{ $mosquee_followers->mosquee->count('mosquee.mosquee_id') }}</li> --}}
        <li>
            <img width="100px" src="{{ asset('storage/' . $mosquee_followers->mosquee->mosquee_image->source) }}" alt="">
        </li>
            {{-- <li>{{ $mosquee_followers->user->name }}</li> --}}
            {{-- <li>{{ $mosquee_followers->user->email }}</li> --}}

            <form action="{{ route('mosquee_followers.destroy', $mosquee_followers->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <a href="/mosquee_followers/{{ $mosquee_followers->uuid }}">Detail</a>
                <a href="{{ route('mosquee_followers.edit', $mosquee_followers->id) }}">Update</a>
                <button onclick="return confirm('Delete?')">Delete</button>
            </form>
        @endforeach
    </ul>
</body>
</html>