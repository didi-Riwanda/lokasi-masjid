<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail</title>
</head>
<body>
    <ul>
        <li>{{ $mosquee->name }}</li>
        <li>{{ $mosquee->addrees }}</li>
        <li>{{ $mosquee->street }}</li>
        <li>{{ $mosquee->subdistrict }}</li>
        <li>{{ $mosquee->city }}</li>
        <li>{{ $mosquee->province }}</li>
        <li>{{ $mosquee->latitude }}</li>
        <li>{{ $mosquee->longtitude }}</li>
        <li>{{ $mosquee->followers }}</li>
        <li>{{ $mosquee->shareds }}</li>
    </ul>

    <form action="{{ route('mosquee.destroy', $mosquee->id) }}" method="POST">
        @csrf
        @method('DELETE')

        <a href="{{ route('mosquee.edit', $mosquee->id) }}">Update</a>
        <button onclick="return confirm('Yakin hapus?')">Hapus</button>
    </form>
</body>
</html>