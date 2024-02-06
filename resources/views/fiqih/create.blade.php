@extends('layouts.app')

@section('title', 'Tambah Fiqih')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('fiqih.index') }}">Fiqih</a></li>
        <li class="breadcrumb-item active">Tambah Fiqih</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Tambah Fiqih Baru</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('fiqih.store') }}" method="post" enctype="multipart/form-data">
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
                    <label for="source" class="col-md-4 col-form-label text-md-end">
                        PDF Document
                    </label>

                    <div class="col-md-8">
                        <div class="input-group @error('source') is-invalid @enderror">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="checkbox" aria-label="Checkbox for following text input" onchange="onChangeMedia(event)">
                                </div>
                            </div>
                            
                            <div class="custom-file">
                                <input type="file" name="source" class="custom-file-input" id="source">
                                <label class="custom-file-label" for="source">Choose file</label>
                            </div>
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

        function onChangeMedia(e) {
            const target = e.currentTarget ?? e.target;
            const current = target.parentElement.parentElement;
            const parent = current.parentElement;

            let child;
            if (target.checked) {
                child = `
                    <input type="text" name="source" class="form-control" id="source" placeholder="Kode Google Drive">
                `;
                
               const prefixhttp = `
                    <div class="input-group-text">
                        https://drive.google.com/file/d/
                    </div>
                `;
                $(prefixhttp).insertAfter(target.parentElement);
            } else {
                child = `
                    <div class="custom-file">
                        <input type="file" name="source" class="custom-file-input" id="source">
                        <label class="custom-file-label" for="source">Choose file</label>
                    </div>
                `;

                if (target.parentElement.nextElementSibling) {
                    target.parentElement.nextElementSibling.remove();
                }
            }

            current.nextElementSibling.remove();

            const el = $(child);
            el.insertAfter(current);
            if (target.checked) {
                const suffixquery = `
                    <div class="input-group-append">
                        <div class="input-group-text">
                            /view?usp=sharing
                        </div>
                    </div>
                `;
                $(suffixquery).insertAfter(el);
            } else {
                if (el.next().length > 0) {
                    el.next().remove();
                }
            }
        }
    </script>
@endpush
