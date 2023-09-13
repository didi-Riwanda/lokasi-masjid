<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Create</title>
</head>
<body>
    <form action="{{ route('mosquee_images.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <select name="mosquee_id" id="mosquee_id">
                <option>--Select--</option>
            @foreach ($mosquee as $mosquees)
                <option value="{{ $mosquees->id }}">{{ $mosquees->name }}</option>
            @endforeach
        </select>

        <img class="img-preview">
        <input type="file" name="source" id="source" onchange="previewImage()"> <label for="source">Source</label>
        <input type="text" name="type" id="type"> <label for="type">Type</label>

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