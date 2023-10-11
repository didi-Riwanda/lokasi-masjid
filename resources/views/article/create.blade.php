@extends('layouts.app')

@section('title', 'Tambah Artikel')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('article.index') }}">Artikel</a></li>
        <li class="breadcrumb-item active">Tambah Artikel</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Tambah Artikel Baru</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('article.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <label for="title" class="col-md-4 col-form-label text-md-end">
                        Judul
                    </label>

                    <div class="col-md-8">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="off">

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                @for ($i = 0; $i < 5; $i++)
                    <div class="row mb-3">
                        <label for="image-{{ $i }}" class="col-md-4 col-form-label text-md-end">
                            Gambar {{ $i + 1 }}
                        </label>

                        <div class="col-md-8">
                            <div class="custom-file @error('images'.$i) is-invalid @enderror">
                                <input type="file" name="images[{{ $i }}]" class="custom-file-input" id="image-{{ $i }}">
                                <label class="custom-file-label" for="image-{{ $i }}">Choose file</label>
                            </div>

                            @error('images.'.$i)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                @endfor

                <div class="row mb-3">
                    <label for="body" class="col-md-4 col-form-label text-md-end">
                        Isi / Deskripsi
                    </label>

                    <div class="col-md-8">
                        <textarea id="body" type="text" class="form-control @error('body') is-invalid @enderror" name="body" autocomplete="off">{{ old('body') }}</textarea>

                        @error('body')
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
        });
    </script>
@endpush
