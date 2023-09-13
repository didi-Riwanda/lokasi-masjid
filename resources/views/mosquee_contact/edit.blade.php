<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mosquee Contact Update</title>
</head>
<body>
    <form action="{{ route('mosquee_contact.update', $old_mosquee_contact->id) }}" method="POST">
        @csrf
        @method('PUT')

        <select name="mosquee_id" id="mosquee_id">
                <option>--Select--</option>
            @foreach ($all_mosquee as $mosquees)
                {{-- @if (old('mosquee_id', $old_mosquee_contact->mosquee_id) == $mosquees->id)
                    <option value="{{ $mosquees->id }}" selected>{{ $mosquees->name }}</option>
                @else
                    <option value="{{ $mosquees->id }}">{{ $mosquees->name }}</option>
                @endif --}}

                @if ($old_mosquee_contact->mosquee_id == $mosquees->id)
                    <option value="{{ $mosquees->id }}" selected>{{ $mosquees->name }}</option>
                @else
                    <option value="{{ $mosquees->id }}">{{ $mosquees->name }}</option>
                @endif
            @endforeach
        </select>
        <input type="text" name="name" id="name" value="{{ $old_mosquee_contact->name }}"> <label for="name">Name</label>
        <input type="text" name="phone" id="phone" value="{{ $old_mosquee_contact->phone }}"> <label for="phone">Phone</label>
        <input type="text" name="type" id="type" value="{{ $old_mosquee_contact->type }}"> <label for="type">Type</label>
        
        <button>Save</button>
    </form>
</body>
</html>
