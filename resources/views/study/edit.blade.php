@extends('layouts.app')

@section('title', 'Ubah Kajian')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('study.index') }}">Kajian</a></li>
        <li class="breadcrumb-item active">Ubah Kajian</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Ubah Kajian</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('study.update', ['study' => $study['id']]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="row mb-3">
                    <label for="title" class="col-md-4 col-form-label text-md-end">
                        Judul
                    </label>

                    <div class="col-md-8">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $study['title']) }}" required autocomplete="off">

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="category" class="col-md-4 col-form-label text-md-end">
                        Kategori
                    </label>

                    <div class="col-md-8">
                        @php
                            $category = App\Models\Category::where('uuid', old('category', $study['category']))->first();
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
                    <label for="ustadz" class="col-md-4 col-form-label text-md-end">
                        Ustadz
                    </label>

                    <div class="col-md-8">
                        <input id="ustadz" type="text" class="form-control @error('ustadz') is-invalid @enderror" name="ustadz" value="{{ old('ustadz', $study['ustadz']) }}" required autocomplete="off">

                        @error('ustadz')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="media" class="col-md-4 col-form-label text-md-end">
                        URL Media
                    </label>

                    <div class="col-md-8">
                        <input id="media" type="text" class="form-control @error('media') is-invalid @enderror" name="media" value="{{ old('media', $study['url']) }}" required autocomplete="off">

                        @error('media')
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
                        target: 'study',
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
                        target: 'study',
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
