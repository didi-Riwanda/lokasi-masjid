@extends('layouts.app')

@section('title', 'Ubah Kategori')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('category.index') }}">Kategori</a></li>
        <li class="breadcrumb-item active">Ubah Kategori</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Ubah Kategori</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('category.update', ['category' => $category->uuid]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="row mb-3">
                    <label for="title" class="col-md-4 col-form-label text-md-end">
                        Judul
                    </label>

                    <div class="col-md-8">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $category->name) }}" required autocomplete="off">

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="target" class="col-md-4 col-form-label text-md-end">
                        Relasi
                    </label>

                    <div class="col-md-8">
                        <select id="target" class="form-control @error('target') is-invalid @enderror" name="target">
                            <option @if (old('target', $category->type) === 'article') selected @endif value="article">Artikel</option>
                            <option @if (old('target', $category->type) === 'hadist') selected @endif value="hadist">Hadist</option>
                            <option @if (old('target', $category->type) === 'study') selected @endif value="study">Kajian</option>
                        </select>

                        @error('target')
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
