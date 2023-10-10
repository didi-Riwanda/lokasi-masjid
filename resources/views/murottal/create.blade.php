@extends('layouts.app')

@section('title', 'Tambah Murottal')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('murottal.index') }}">Murottal</a></li>
        <li class="breadcrumb-item active">Tambah Murottal</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Tambah Murottal Baru</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('murottal.store') }}" method="post" enctype="multipart/form-data">
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

                <div class="row mb-3">
                    <label for="qari" class="col-md-4 col-form-label text-md-end">
                        Qari
                    </label>

                    <div class="col-md-8">
                        <input id="qari" type="text" class="form-control @error('qari') is-invalid @enderror" name="qari" value="{{ old('qari') }}" required autocomplete="off">

                        @error('qari')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="media" class="col-md-4 col-form-label text-md-end">
                        Media
                    </label>

                    <div class="col-md-8">
                        <div class="custom-file @error('media') is-invalid @enderror">
                            <input type="file" name="media" class="custom-file-input" id="media">
                            <label class="custom-file-label" for="media">Choose file</label>
                        </div>

                        @error('media.')
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
