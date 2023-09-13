<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mosquee Images</title>
</head>
<body>
    <a href="{{ route('mosquee_images.create') }}">Create</a>
    <ul>
        @foreach ($all_mosquee_images as $mosquee_images)

            <li><img width="100px" src="{{ asset('storage/' . $mosquee_images->source) }}" alt=""></li>
            <li>{{ $mosquee_images->mosquee->addrees }}</li>
            <li>{{ $mosquee_images->mosquee->name }}</li>

            <form action="{{ route('mosquee_images.destroy', $mosquee_images->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <a href="{{ route('mosquee_images.edit', $mosquee_images->id) }}">Update</a>

                <button onclick="return confirm('Delete?')">Delete</button>
            </form>
        @endforeach
    </ul>
</body>
</html>