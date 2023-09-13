<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mosquee Contact</title>
</head>
<body>

    @if ( $message = Session::get('success'))
        <p>{{ $message }}</p>
    @endif

    <a href="{{ route('mosquee_contact.create') }}">Create</a>
    <ul>
        @foreach ($all_mosquee_contact as $mosquee_contacts)
            <li>{{ $mosquee_contacts->mosquee->name }}</li>
            <li>{{ $mosquee_contacts->name }}</li>
            <li>{{ $mosquee_contacts->phone }}</li>
            <li>{{ $mosquee_contacts->type }}</li>

            <form action="{{ route('mosquee_contact.destroy', $mosquee_contacts->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <a href="{{ route('mosquee_contact.edit', $mosquee_contacts->id) }}">Update</a>
                <a href="{{ route('mosquee_contact.show', $mosquee_contacts->id) }}">Detail</a>
                <button onclick="return confirm('Deleted?')">Delete</button>
            </form>
        @endforeach
    </ul>
</body>
</html>
