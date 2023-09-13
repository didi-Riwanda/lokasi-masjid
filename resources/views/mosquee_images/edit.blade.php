<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update</title>
</head>
<body>
    {{-- @dd($old_mosquee_images->source) --}}
    <form action="{{ route('mosquee_images.update', $old_mosquee_images->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <select name="mosquee_id" id="mosquee_id">
                <option>--Select--</option>
            @foreach ($all_mosquee as $mosquees)
                @if(old('mosquee_id', $old_mosquee_images->mosquee_id) == $mosquees->id)
                    <option value="{{ $mosquees->id }}" selected>{{ $mosquees->name }}</option>
                @else
                    <option value="{{ $mosquees->id }}">{{ $mosquees->name }}</option>
                @endif
            @endforeach
        </select>

        
        <label for="source">Source Image</label>
        <input type="hidden" name="oldImage" value="{{ $old_mosquee_images->source }}">

        @if ($old_mosquee_images->source)
            <img src="{{ asset('storage/' . $old_mosquee_images->source) }}" >
        @else
            <img class="img-preview">
        @endif

        <input type="file" class="form-control @error('source') is-invalid @enderror" id="source" name="source" onchange="previewImage()">

            {{-- @error('image')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror --}}
        
        <input type="text" name="type" id="type" value="{{ $old_mosquee_images->type }}"> <label for="type">Type</label>
        
        

        <button>Save</button>
    </form>

    <script>
        function previewImage(){
            const image = document.querySelector('#source');
            const imgPreview = document.querySelector('.img-preview');
       
            imgPreview.style.display = 'block';
       
            const oFReader = new FileReader();
            oFReader.readAsDataURL(source.files[0]);
       
            oFReader.onload = function(oFREvent){
               imgPreview.src = oFREvent.target.result;
           }
       }
    </script>
</body>
</html>