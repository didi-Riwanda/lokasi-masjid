@extends('layouts.app')

@section('title', 'Tambah Kajian')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('study.index') }}">Kajian</a></li>
        <li class="breadcrumb-item active">Tambah Kajian</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Tambah Kajian</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('study.store') }}" method="post" enctype="multipart/form-data">
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
                    <label for="category" class="col-md-4 col-form-label text-md-end">
                        Kategori
                    </label>

                    <div class="col-md-8">
                        <select id="category" class="form-control @error('category') is-invalid @enderror" name="category" value="{{ old('category') }}" required>
                            <option value="">--- NONE ---</option>
                        </select>

                        @error('category')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="col-form-label text-md-end">
                        Media Playlist (DEMO - Read Only)
                    </label>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="list-group overflow-auto" id="video-playlist-sources" style="height: 380px">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="list-group overflow-auto" id="video-playlist-selections" style="height: 380px">
                                @forelse ($media['playlist']['items'] as $item)
                                    @php
                                        $snippet = $item->snippet;
                                        $resource = $snippet->resourceId;
                                    @endphp
                                    <a href="https://www.youtube.com/watch?v={{ $resource->videoId }}" class="list-group-item list-group-item-action" data-id="{{ $item->id }}">
                                        <div class="d-flex flex-column w-100 justify-content-between">
                                            <h6 class="mb-1">{{ $snippet->title }}</h6>
                                            <small>3 days ago</small>
                                        </div>
                                    </a>
                                @empty

                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="media" class="col-md-4 col-form-label text-md-end">
                        URL Media
                    </label>

                    <div class="col-md-8">
                        <input id="media" type="text" class="form-control @error('media') is-invalid @enderror" name="media" value="{{ old('media') }}" required autocomplete="off">

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
    <!-- SortableJS and InteractJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/interactjs@1.10.19/dist/interact.min.js"></script>
    <script>
        const exists = [];
        new Sortable(document.querySelector('#video-playlist-sources'), {
            group: {
                name: 'shared',
            },
            animation: 150,
            scroll: true,
            sort: false,
            filter: (e, target) => {
                const id = target.getAttribute('data-id');
                return exists.includes(id);
            },
            onAdd: function (e) {
                e.clone.style.opacity = .5;

                const target = e.item;
                const id = target.getAttribute('data-id');

                const input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('name', 'medias[]');
                input.setAttribute('value', id);

                target.append(input);

                exists.push(id);
            },
        });
        new Sortable(document.querySelector('#video-playlist-selections'), {
            group: {
                name: 'shared',
                pull: 'clone',
                put: false,
            },
            animation: 150,
            scroll: true,
            sort: false,
            filter: (e, target) => {
                const id = target.getAttribute('data-id');
                return exists.includes(id);
            },
        });

        $('#video-playlist-selections > a.list-group-item').on('click', (e) => {
            e.preventDefault();

            const target = e.currentTarget;
            const id = target.getAttribute('data-id');
            if (!exists.includes(id)) {
                const clone = target.cloneNode(true);

                const input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('name', 'medias[]');
                input.setAttribute('value', id);

                clone.append(input);
                $('#video-playlist-sources').append(clone);

                target.style.opacity = .5;

                exists.push(id);
            }
        });
        $(document).on('click', '#video-playlist-sources > a.list-group-item', (e) => {
            e.preventDefault();

            const target = e.currentTarget;
            const id = target.getAttribute('data-id');
            if (exists.includes(id)) {
                const elitem = document.querySelector('#video-playlist-selections > a.list-group-item[data-id="' + id + '"]');
                if (elitem) {
                    elitem.style.opacity = null;
                }

                const index = exists.indexOf(id);
                exists.splice(index, 1);

                target.remove();
            }
        });
    </script>
@endpush
