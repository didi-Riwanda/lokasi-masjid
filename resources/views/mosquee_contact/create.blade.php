<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mosquee Contact</title>
</head>
<body>
    <form action="{{ route('mosquee_contact.store') }}" method="POST">
        @csrf
        
        <select name="mosquee_id" id="mosquee_id">
                <option>--Select--</option>
            @foreach ($all_mosquees as $mosquees)
                <option value="{{ $mosquees->id }}">{{ $mosquees->name }}</option>
            @endforeach
        </select>
        <input type="text" name="name" id="name"> <label for="name">Name</label>
        <input type="text" name="phone" id="phone"> <label for="phone">Phone</label>
        <input type="text" name="type" id="type"> <label for="type">Type</label>
        
        <button>Save</button>
    </form>
</body>
</html>