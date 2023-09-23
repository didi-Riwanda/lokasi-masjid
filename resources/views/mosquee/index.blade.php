<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mosquee</title>
</head>
<body>


    @if ( $message = Session::get('success') )
        <p>{{ $message }}</p>
    @endif

    <a href="{{ route('mosquee.create') }}">Create</a>
    <ul>
        @foreach ($all_mosquee as $mosquees)
            <li>{{ $mosquees->name }}</li>
            {{-- <li>{{ $mosquees->mosquee_follower->uuid }}</li> --}}
            <li>{{ $mosquees->addrees }}</li>
            <li>{{ $mosquees->street }}</li>
            <li>{{ $mosquees->subdistrict }}</li>
            <li>{{ $mosquees->city }}</li>
            <li>{{ $mosquees->province }}</li>
            <li>{{ $mosquees->latitude }}</li>
            <li>{{ $mosquees->longtitude }}</li>
            <li>{{ $mosquees->followers }}</li>
            <li>{{ $mosquees->shareds }}</li>
            {{-- <li>{{ $mosquees->mosquee_follower->id }}</li> --}}
            {{-- <li>{{ $mosquees->mosquee_contact->id }}</li> --}}
              {{-- <li> --}}
                {{-- @php
                    $m = $mosquees->mosquee_image->source
                @endphp
                @if ($m) --}}
                    {{-- <img src="{{ asset('storage/' . $mosquees->mosquee_image->source ) }}" alt=""> --}}
                {{-- @else
                    <img src="{{ asset('storage/mosquee_images/uniks.png' ) }}" alt="">
                @endif --}}
            {{-- </li> --}}
            {{-- <li>{{ $mosquees->mosquee_contact->name }}</li> --}}

            <form action="{{ route('mosquee.destroy', $mosquees->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <a href="/mosquee/{{ $mosquees->uuid }}">Show</a>
                <a href="{{ route('mosquee.edit', $mosquees->id) }}">Update</a>

                <button onclick="return confirm('Yakin Data di Hapus?')">Delete</button>
            </form>
        @endforeach
    </ul>
</body>
</html>
