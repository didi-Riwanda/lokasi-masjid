@extends('layouts.app')

@section('title', 'Ubah Dzikir')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('dzikir.index') }}">Dzikir</a></li>
        <li class="breadcrumb-item active">Ubah Dzikir</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Ubah Dzikir</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('dzikir.update', ['dzikir' => $dzikir['id']]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="row mb-3">
                    <label for="category" class="col-md-4 col-form-label text-md-end">
                        Kategori
                    </label>

                    <div class="col-md-8">
                        @php
                            $category = App\Models\Category::where('uuid', old('category', $dzikir['category']))->first();
                        @endphp
                        <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" required>
                            <option value="">--- NONE ---</option>
                            @if (! empty($category))
                                <option value="{{ $category->uuid }}" selected>{{ $category->name }}</option>
                            @endif
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
                        Judul
                    </label>

                    <div class="col-md-8">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $dzikir['title']) }}" required autocomplete="off">

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="arabic" class="col-md-4 col-form-label text-md-end">
                        Arabic
                    </label>

                    <div class="col-md-8">
                        <textarea id="arabic" class="form-control @error('arabic') is-invalid @enderror" name="arabic" required autocomplete="off">{{ old('arabic', $dzikir['arabic']) }}</textarea>
                        @error('arabic')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="latin" class="col-md-4 col-form-label text-md-end">
                        Latin
                    </label>

                    <div class="col-md-8">
                        <textarea id="latin" class="form-control @error('latin') is-invalid @enderror" name="latin" required autocomplete="off">{{ old('latin', $dzikir['latin']) }}</textarea>
                        @error('latin')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="translation" class="col-md-4 col-form-label text-md-end">
                        Terjemahan
                    </label>

                    <div class="col-md-8">
                        <textarea id="translation" class="form-control @error('translation') is-invalid @enderror" name="translation" required autocomplete="off">{{ old('translation', $dzikir['translation']) }}</textarea>
                        @error('translation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="notes" class="col-md-4 col-form-label text-md-end">
                        Catatan
                    </label>

                    <div class="col-md-8">
                        <input id="notes" type="text" class="form-control @error('notes') is-invalid @enderror" name="notes" value="{{ old('notes', $dzikir['notes']) }}" required autocomplete="off">

                        @error('notes')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="fawaid" class="col-md-4 col-form-label text-md-end">
                        Fawaid
                    </label>

                    <div class="col-md-8">
                        <textarea id="fawaid" class="form-control @error('fawaid') is-invalid @enderror" name="fawaid" required autocomplete="off">{{ old('fawaid', $dzikir['fawaid']) }}</textarea>
                        @error('fawaid')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="source" class="col-md-4 col-form-label text-md-end">
                        Sumber
                    </label>

                    <div class="col-md-8">
                        <input id="source" type="text" class="form-control @error('source') is-invalid @enderror" name="source" value="{{ old('source', $dzikir['source']) }}" required autocomplete="off">

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
            createTag: (params) => {
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
            },
            placeholder: '--- NONE ---',
        });

        elcategoryselect.on('select2:select', (e) => {
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
        });
    </script>
@endpush
