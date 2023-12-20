@extends('layouts.app')

@section('title', 'Tambah Hadist')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hadist.index') }}">Hadist</a></li>
        <li class="breadcrumb-item active">Tambah Hadist</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Tambah Hadist</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('hadist.store') }}" method="post" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <label for="category" class="col-md-4 col-form-label text-md-end">
                        Kategori <span class="text-red">*</span>
                    </label>

                    <div class="col-md-8">
                        <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" required>
                            <option value="">--- NONE ---</option>
                            @php
                                $categories = \App\Models\Hadist::groupBy('category')->get();
                            @endphp
                            @foreach ($categories as $category)
                                <option value="{{ $category->category }}">{{ $category->category }}</option>
                            @endforeach
                        </select>

                        @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="title" class="col-md-4 col-form-label text-md-end">
                        Judul <span class="text-red">*</span>
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
                    <label for="text" class="col-md-4 col-form-label text-md-end">
                        Arabic <span class="text-red">*</span>
                    </label>

                    <div class="col-md-8">
                        <textarea id="text" class="form-control @error('text') is-invalid @enderror" name="text" value="{{ old('text') }}" required autocomplete="off"></textarea>
                        @error('text')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="latin" class="col-md-4 col-form-label text-md-end">
                        Latin (Optional)
                    </label>

                    <div class="col-md-8">
                        <textarea id="latin" class="form-control @error('latin') is-invalid @enderror" name="latin" value="{{ old('latin') }}" required autocomplete="off"></textarea>
                        @error('latin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="translation" class="col-md-4 col-form-label text-md-end">
                        Terjemahan <span class="text-red">*</span>
                    </label>

                    <div class="col-md-8">
                        <textarea id="translation" class="form-control @error('translation') is-invalid @enderror" name="translation" value="{{ old('translation') }}" required autocomplete="off"></textarea>
                        @error('translation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="noted" class="col-md-4 col-form-label text-md-end">
                        Catatan (Optional)
                    </label>

                    <div class="col-md-8">
                        <input id="noted" type="text" class="form-control @error('noted') is-invalid @enderror" name="noted" value="{{ old('noted') }}" required autocomplete="off">

                        @error('noted')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="source" class="col-md-4 col-form-label text-md-end">
                        Sumber <span class="text-red">*</span>
                    </label>

                    <div class="col-md-8">
                        <input id="source" type="text" class="form-control @error('source') is-invalid @enderror" name="source" value="{{ old('source') }}" required autocomplete="off">

                        @error('source')
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

@push('windowhead')
    <!-- Select2 -->
    <link
        rel="preload"
        as="style"
        fetchpriority="high"
        onload="this.onload=null;this.rel='stylesheet'"
        href="{{ asset('plugins/select2/css/select2.min.css') }}"
    >
    <link
        rel="preload"
        as="style"
        fetchpriority="high"
        onload="this.onload=null;this.rel='stylesheet'"
        href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}"
    >
@endpush

@push('windowbody')
    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        const elcategoryselect = $('select[name="category"]').select2({
            theme: 'bootstrap4',
            width: '100%',
            tags: true,
            {{-- createTag: (params) => {
                const term = $.trim(params.term);

                if (term === '') {
                    return null;
                }

                return {
                    id: term,
                    text: term + ' (new)',
                    value: term,
                    created: true,
                };
            },
            ajax: {
                url: '{{ route('category.index') }}',
                dataType: 'json',
                delay: 250,
                data: (params) => {
                    return {
                        search: params.term, // search term
                        cursor: params.cursor,
                        target: 'dzikir',
                    };
                },
                processResults: (data, params) => {
                    params.cursor = data.next || null;

                    return {
                        results: data.data.map(function(row) {
                            return {
                                'id': row.id,
                                'text': row.name,
                            };
                        }),
                        pagination: {
                            more: data.next !== null && data.next !== '',
                        },
                    };
                },
                transport: (params, success, failure) => {
                    const $request = $.ajax(params);

                    $request.then(success);
                    $request.fail(failure);

                    return $request;
                },
                cache: true,
            }, --}}
            placeholder: '--- NONE ---',
        });

        {{-- elcategoryselect.on('select2:select', (e) => {
            const choice = e.params.data;
            if (!Array.isArray(choice) && choice.created) {
                $.ajax({
                    url: '{{ route('category.store') }}',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        title: choice.value,
                        target: 'dzikir',
                    },
                    success: (res) => {
                        elcategoryselect.append(new Option(
                            choice.text,
                            res.id,
                            true,
                            true,
                        )).trigger('change');

                        elcategoryselect.trigger({
                            type: 'select2:select',
                            params: {
                                data: res,
                            },
                        });
                    },
                    error: (request, status, error) => {
                        console.log(request, status, error);
                    },
                });
            }
        }); --}}
    </script>
@endpush
