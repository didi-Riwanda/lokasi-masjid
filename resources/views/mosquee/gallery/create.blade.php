@extends('layouts.app')

@section('title', 'Tambah Lokasi Masjid')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mosquee.index') }}">Masjid</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mosquee.gallery.index', ['mosquee' => request()->mosquee]) }}">Galleri</a></li>
        <li class="breadcrumb-item active">Tambah Gambar</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Tambah Lokasi Masjid Baru</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('mosquee.gallery.store', ['mosquee' => request()->mosquee]) }}" method="post" enctype="multipart/form-data">
                @csrf

                @forelse (old('images', []) as $key => $image)
                    <div class="row mb-3" id="imageClone">
                        <label for="choose-image-{{ $key }}" class="col-md-4 col-form-label text-md-end">
                            Gambar {{ $key + 1 }}
                        </label>
                        <div class="custom-file @error('images.'.$key) is-invalid @enderror">
                            <input type="file" name="images[]" class="custom-file-input" id="choose-image-{{ $key }}">
                            <label class="custom-file-label" for="choose-image-{{ $key }}">Choose file</label>
                        </div>

                        @error('images.'.$key)
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @empty
                    <div class="row mb-3" id="imageClone">
                        <label for="choose-image-0" class="col-md-4 col-form-label text-md-end">
                            Gambar 1
                        </label>
                        <div class="custom-file @error('images.0') is-invalid @enderror">
                            <input type="file" name="images[]" class="custom-file-input" id="choose-image-0">
                            <label class="custom-file-label" for="choose-image-0">Choose file</label>
                        </div>

                        @error('images.0')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                @endforelse

                <button type="button" id="addImage" class="btn btn-block btn-warning mb-3">Tambah Gambar</button>

                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ url()->previous() }}" class="btn btn-warning text-white">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('windowbody')
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        bsCustomFileInput.init();

        index = 0;
        document.querySelector('#addImage').addEventListener('click', function(e) {
            index++;

            const copy = document.getElementById('imageClone');
            const clone = copy.cloneNode(true);
            
            clone.removeAttribute('id');
            
            const label = clone.querySelector('label[for="choose-image-0"]')
            label.setAttribute('for', `choose-image-${index}`);
            label.innerText = `Gambar ${index + 1}`;

            // const imageWrapper = clone.querySelector('custom-file');
            const imageLabel = clone.querySelector('.custom-file > label[for="choose-image-0"]');
            imageLabel.setAttribute('for', `choose-image-${index}`);
            const imageInput = clone.querySelector('.custom-file > input[id="choose-image-0"]');
            imageInput.setAttribute('id', `choose-image-${index}`);


            $(e.currentTarget).before(clone);

            bsCustomFileInput.init();
        });
    </script>
@endpush
