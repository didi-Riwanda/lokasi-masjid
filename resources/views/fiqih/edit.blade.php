@extends('layouts.app')

@section('title', 'Ubah Fiqih')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('fiqih.index') }}">Fiqih</a></li>
        <li class="breadcrumb-item active">Ubah Fiqih</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Ubah Fiqih Baru</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('fiqih.update', ['fiqih' => $fiqih->uuid]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="row mb-3">
                    <label for="title" class="col-md-4 col-form-label text-md-end">
                        Judul
                    </label>

                    <div class="col-md-8">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $fiqih->title) }}" required autocomplete="off">

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="source" class="col-md-4 col-form-label text-md-end">
                        PDF Document
                    </label>

                    <div class="col-md-8">
                        <div class="custom-file @error('source') is-invalid @enderror">
                            <input type="file" name="source" class="custom-file-input" id="source">
                            <label class="custom-file-label" for="source">Choose file</label>
                        </div>

                        @error('source.')
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
    <script src="{{ asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    <script>
        bsCustomFileInput.init();
    </script>
@endpush
