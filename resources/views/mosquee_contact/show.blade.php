<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Show Data</title>
</head>
<body>
    <ul>
        <li>{{ $mosquee_contact->mosquee->name }}</li>
        <li>{{ $mosquee_contact->name }}</li>
        <li>{{ $mosquee_contact->phone }}</li>
    </ul>
</body>
</html>