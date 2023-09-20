<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show</title>
</head>
<body>
    <ul>
        <li>{{ $mosquee->name }}</li>
        <li>{{ $mosquee->addrees }}</li>
        <li>{{ $mosquee->street }}</li>
        <li>{{ $mosquee->subdistrict }}</li>
        <li>{{ $mosquee->city }}</li>
        <li>{{ $mosquee->province }}</li>
        <li>{{ $mosquee_follower }}</li>
        <li>{{ $mosquee->mosquee_contact->phone }}</li>
        <li>
            <img src="{{ asset('storage/' . $mosquee->mosquee_image->source ) }}" alt="{{ $mosquee->name }}" width="100px">
        </li>
    </ul>
</body>
</html>