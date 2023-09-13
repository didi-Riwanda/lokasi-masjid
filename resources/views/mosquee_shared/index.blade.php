<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mosquee Shared View</title>
</head>
<body>
    @if ( $message = Session::get('success'))
        <p>{{ $message }}</p>
    @endif

    <a href="{{ route('mosquee_shared.create') }}">Create</a>
    <ul>
        @foreach ($all_mosquee_shared as $mosquee_shareds)
            {{-- <li>{{ $mosquee_shareds->user_id }}</li> --}}
            <li>{{ $mosquee_shareds->ip_address }}</li>

            <form action="{{ route('mosquee_shared.destroy', $mosquee_shareds->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <a href="{{ route('mosquee_shared.edit', $mosquee_shareds->id) }}">Update</a>
                <a href="{{ route('mosquee_shared.show', $mosquee_shareds->id) }}">Detail</a>
                <button onclick="return confirm('Deleted?')">Delete</button>
            </form>
        @endforeach
    </ul>
</body>
</html>