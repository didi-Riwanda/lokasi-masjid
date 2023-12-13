@extends('layouts.app')

@section('title', 'Tambah Lokasi Masjid')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mosquee.index') }}">Masjid</a></li>
        <li class="breadcrumb-item active">Tambah Masjid</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Tambah Lokasi Masjid Baru</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('mosquee.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">
                        Nama
                    </label>

                    <div class="col-md-8">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="off" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="district" class="col-md-4 col-form-label text-md-end">
                        Kecamatan
                    </label>

                    <div class="col-md-8">
                        <input id="district" type="text" class="form-control @error('district') is-invalid @enderror" name="district" value="{{ old('district') }}" required autocomplete="off">

                        @error('district')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="city" class="col-md-4 col-form-label text-md-end">
                        Kota
                    </label>

                    <div class="col-md-8">
                        <input id="city" type="text" class="form-control @error('city') is-invalid @enderror" name="city" value="{{ old('city') }}" required autocomplete="off">

                        @error('city')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="province" class="col-md-4 col-form-label text-md-end">
                        Provinsi
                    </label>

                    <div class="col-md-8">
                        <input id="province" type="text" class="form-control @error('province') is-invalid @enderror" name="province" value="{{ old('province') }}" required autocomplete="off">

                        @error('province')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="street" class="col-md-4 col-form-label text-md-end">
                        Jalan
                    </label>

                    <div class="col-md-8">
                        <input id="street" type="text" class="form-control @error('street') is-invalid @enderror" name="street" value="{{ old('street') }}" required autocomplete="off">

                        @error('street')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="address" class="col-md-4 col-form-label text-md-end">
                        Alamat
                    </label>

                    <div class="col-md-8">
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="off">

                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4 col-form-label text-md-end">
                        Koordinat
                    </label>

                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="latitude" class="col-md-4 col-form-label text-md-end">
                                    Latitude
                                </label>

                                <input id="latitude" type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" value="{{ old('latitude') }}" required autocomplete="off">

                                @error('latitude')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="longitude" class="col-md-4 col-form-label text-md-end">
                                    Longitude
                                </label>

                                <input id="longitude" type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" value="{{ old('longitude') }}" required autocomplete="off">

                                @error('longitude')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div id="map"></div>

                <div class="card">
                    <div class="card-body">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="mb-3">
                                <label for="choose-image-{{ $i }}" class="col-md-4 col-form-label text-md-end">
                                    Image {{ $i + 1 }}
                                </label>
                                <div class="custom-file @error('images.'.$i) is-invalid @enderror">
                                    <input type="file" name="images[{{ $i }}]" class="custom-file-input" id="choose-image-{{ $i }}">
                                    <label class="custom-file-label" for="choose-image-{{ $i }}">Choose file</label>
                                </div>

                                @error('images.'.$i)
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        @endfor
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
    {{-- <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: -34.397, lng: 150.644},
                zoom: 8
            });
        }
    </script>
    <script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgA1jv3K6Uol_ABVa0cBBInike8RxsIws&callback=initMap"></script> --}}
@endpush
