@extends('layouts.app')

@section('title', 'Ubah Galleri Masjid')

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
            <h3 class="card-title">Ubah Galleri Masjid {{ $mosquee->name }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('mosquee.gallery.update', ['gallery' => $gallery->id, 'mosquee' => $mosquee->uuid]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('put')

                <div class="row mb-3">
                    <label for="image" class="col-md-4 col-form-label text-md-end">
                        Gambar
                    </label>

                    <div class="col-md-8">
                        <div class="custom-file @error('image') is-invalid @enderror">
                            <input type="file" name="image" class="custom-file-input" id="image">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>

                        @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ url()->previous() }}" class="btn btn-warning text-white">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('windowbody')
    <script src="{{ mix('js/textfieldeditor.js') }}"></script>
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        bsCustomFileInput.init();
    </script>
    <script>
        window.createTextEditor('#body', {
            ckfinder: {
                options: {
                    resourceType: 'Images',
                },
                {{-- uploadUrl: '{{ route('image.upload').'?_token='.csrf_token() }}', --}}
            },
        }, (editor) => {
            const text = $(editor.getData()).text();

            editor.model.document.on('change', () => {
            });
        });
    </script>
@endpush
