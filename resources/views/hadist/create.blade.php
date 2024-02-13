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
                        <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" required>
                            <option value="">--- NONE ---</option>
                            @php
                                $categories = \App\Models\Hadist::groupBy('category')->get();
                            @endphp
                            @foreach ($categories as $category)
                                @php
                                    $selected = old('category') === $category->category;
                                @endphp
                                <option value="{{ $category->category }}" {{ $selected ? 'selected' : '' }}>{{ $category->category }}</option>
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
                        <div class="input-group">
                            <select id="source" class="form-control @error('source') is-invalid @enderror" name="source" required>
                                <option value="">--- NONE ---</option>

                                @if (old('source')) 
                                    <option value="{{ old('source') }}" selected>{{ old('source') }}</option>
                                @endif
                            </select>

                            <div class="input-group-append">
                                <button class="btn btn-outline-secondary" type="button"  data-toggle="modal" data-target="#form-source">
                                    Add
                                </button>
                            </div>
                        </div>

                        @error('source')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                 <div class="row mb-3">
                    <label for="narrator" class="col-md-4 col-form-label text-md-end">
                        Perawi <span class="text-red">*</span>
                    </label>

                    <div class="col-md-8">
                        <select id="narrator" class="form-control @error('narrator') is-invalid @enderror" name="narrator" multiple required>
                            <option value="">--- NONE ---</option>

                            @if (old('narrator')) 
                                <option value="{{ old('narrator') }}" selected>{{ old('narrator') }}</option>
                            @endif
                        </select>

                        @error('narrator')
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
    <!-- Modal -->
    <div class="modal fade" id="form-source" tabindex="-1" role="dialog" aria-labelledby="form-source-modal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="form-source-modal">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input type="text" class="form-control" name="name" required autocomplete="off" placeholder="Nama Sumber">

                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control" name="author" required autocomplete="off" placeholder="Penulis">

                        <span class="invalid-feedback" role="alert">
                            <strong></strong>
                        </span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="form-source-save">Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        const elnarratorselect = $('select[name="narrator"]').select2({
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
                    text: term,
                    value: term,
                    created: true,
                };
            },
            ajax: {
                url: '{{ route('hadist.narrators') }}',
                dataType: 'json',
                delay: 250,
                data: (params) => {
                    return {
                        q: params.term, // search term
                        cursor: params.cursor,
                    };
                },
                processResults: (data, params) => {
                    params.cursor = data.next_cursor || null;

                    return {
                        results: data.data.map(function(row) {
                            return {
                                'id': row.uuid,
                                'text': row.name,
                            };
                        }),
                        pagination: {
                            more: data.next_cursor !== null && data.next_cursor !== '',
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
        elnarratorselect.on('select2:select', (e) => {
            const choice = e.params.data;
            if (!Array.isArray(choice) && choice.created) {
                $.ajax({
                    url: '{{ route('hadist.narrators') }}',
                    method: 'post',
                    dataType: 'json',
                    data: {
                        name: choice.value,
                    },
                    success: (res) => {
                        elnarratorselect.val(choice).trigger('change');
                        elnarratorselect.trigger({
                            type: 'select2:unselect',
                            params: {
                                data: choice,
                            },
                        });
                        
                        elnarratorselect.append(new Option(
                            choice.text,
                            res.id,
                            true,
                            true,
                        )).trigger('change');
                    },
                    error: (request, status, error) => {
                        console.log(request, status, error);
                    },
                });
            }
        });

        const elsourceselect = $('select[name="source"]').select2({
            theme: 'bootstrap4',
            ajax: {
                url: '{{ route('hadist.sources') }}',
                dataType: 'json',
                delay: 250,
                data: (params) => {
                    return {
                        q: params.term, // search term
                        cursor: params.cursor,
                    };
                },
                processResults: (data, params) => {
                    params.cursor = data.next_cursor || null;

                    return {
                        results: data.data.map(function(row) {
                            return {
                                'id': row.uuid,
                                'text': `[${row.name}] ${row.author}`,
                                'data': row,
                            };
                        }),
                        pagination: {
                            more: data.next_cursor !== null && data.next_cursor !== '',
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
    </script>
    <script>
        $(function () {
            function getInputs(el) {
                function recursive(el, inputs = []) {
                    if (typeof el !== 'undefined') {
                        for (let i = 0; i < el.childNodes.length; i++) {
                            const child = el.childNodes[i];

                            if (child instanceof HTMLElement) {
                                if (child.tagName.toLowerCase() === 'input') {
                                    inputs.push(child);

                                    continue;
                                }

                                inputs.push(...recursive(child));
                            }
                        }
                    }
                    return inputs;
                }

                if (typeof el !== 'undefined') {
                    return recursive(el);
                }

                return [];
            }

            $('#form-source-save').on('click', function (e) {
                const target = e.currentTarget;
                const elbtnclose = target.parentElement.querySelector('.btn-close');
                const elform = target.parentElement.parentElement.querySelector('.modal-body');
                const elinputs = getInputs(elform);
                const elinputname = elinputs[0];
                const elinputauthor = elinputs[1];

                $.ajax({
                    method: 'post',
                    url: '{{ route('hadist.sources') }}',
                    data: {
                        name: elinputname.value,
                        author: elinputauthor.value,
                    },
                    success: function(response) {
                        elbtnclose.click();
                    },
                    error: function(request, status, error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endpush
