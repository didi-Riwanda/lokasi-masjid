<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>All Data</title>
</head>
<body>
    <ul>
        {{-- @foreach ($all_data as $mosquees) --}}
            {{-- <li>{{ $mosquees->mosquee->name }}</li>
            <li>{{ $mosquees->mosquee->addrees }}</li> --}}
            {{-- @foreach ($all_mosquee as $mosquee)
                <li>{{ $mosquee->id }}</li>
            @endforeach --}}
            {{-- <li>{{ $mosquees->mosquee->street }}</li>
            <li>{{ $mosquees->mosquee->city }}</li>
            <li>{{ $mosquees->mosquee->province }}</li> --}}
            {{-- <li>
                <img width="100px" src="{{ asset('storage/' . $mosquees->mosquee->mosquee_image->source) }}" alt="">
            </li> --}}
            {{-- <li>{{ $mosquees->mosquee->mosquee_contact->name }}</li>
            <li>{{ $mosquees->mosquee->mosquee_contact->phone }}</li>
            <li>{{ $mosquee }}</li> --}}
            {{-- @foreach ($mosquee_follower as $m) 
                    <li>{{ $m->id }}</li>
            @endforeach --}}

            {{-- <a href="/m/{{ $mosquees->id }}">Detail</a>
            <br>
            <br>
            <br>
        @endforeach --}}
    </ul> <br><br><br>

    <ul>
        @foreach ($all_mosquee as $mosquees)
            <li>{{ $mosquees->name }}</li>
            <li>{{ $mosquees->addrees }}</li> 
            <li>
                <a href="/mosquee/detail/{{ $mosquees->uuid }}">
                    <img width="100px" src="{{ asset('storage/' . $mosquees->mosquee_image->source ) }}" >
                </a>
            </li>
            <li>{{ $mosquees->latitude }}</li>
            <li>{{ $mosquees->longtitude }}</li>
            <br><br><br>
        @endforeach
    </ul>
</body>
</html>