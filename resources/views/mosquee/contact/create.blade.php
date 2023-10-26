@extends('layouts.app')

@section('title', 'Tambah Kontak Masjid')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mosquee.index') }}">Masjid</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mosquee.contact.index', ['mosquee' => $mosquee->uuid]) }}">Kontak Masjid</a></li>
        <li class="breadcrumb-item active">Tambah Kontak Masjid</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Tambah Dzikir</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('mosquee.contact.store', ['mosquee' => $mosquee->uuid]) }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">
                        Nama
                    </label>

                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="off">

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="phone" class="col-md-4 col-form-label text-md-end">
                        No. Handphone
                    </label>

                    <div class="col-md-8">
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="off">

                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="type" class="col-md-4 col-form-label text-md-end">
                        Jenis
                    </label>

                    <div class="col-md-8">
                        <input id="type" type="text" class="form-control @error('type') is-invalid @enderror" name="type" value="{{ old('type') }}" required autocomplete="off">

                        @error('type')
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
