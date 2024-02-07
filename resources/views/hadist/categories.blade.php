@extends('layouts.app')

@section('title', 'Tambah Hadist')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('hadist.index') }}">Hadist</a></li>
        <li class="breadcrumb-item active">Bab Hadist</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Tambah Hadist</h3>
        </div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-12">
                        @php
                            $categories = \App\Models\Hadist::select(['category', 'source', DB::raw('count(*) as total')])->groupBy('category')->orderBy('ordered')->get();
                        @endphp
                        <ul class="list-group sorters">
                            @foreach ($categories as $category)
                                <li class="list-group-item d-flex justify-content-between align-items-center" data-id="{{ $category->category }}">
                                    [{{ $category->source }}] {{ $category->category }}
                                    <div>
                                        <span class="badge badge-primary badge-pill">{{ $category->total }}</span>
                                        &nbsp;
                                        <button type="button" class="btn btn-sm btn-danger delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>

                                    <input type="hidden" name="categories[]" readonly value="{{ $category->category }}" />
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <input type="hidden" id="sorting" readonly />

                <div class="d-flex align-items-center justify-content-between">
                    <a href="{{ url()->previous() }}" class="btn btn-warning text-white">Kembali</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('windowhead')
@endpush

@push('windowbody')
    <!-- Axios -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.6.5/axios.min.js"></script>
    <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-sortablejs@latest/jquery-sortable.js"></script>
    
    <script>
        $('.sorters').sortable({
            animation: 150,
            swap: true,
	        swapClass: 'disabled', // The class applied to the hovered swap item
	        invertSwap: true,
            multiDrag: true, // Enable multi-drag
            selectedClass: 'active', // The class applied to the selected items
            fallbackTolerance: 3, // So that we can select items on mobile
            onEnd: function(e) {
                update();
            },
        });

        function update() {
            $('#sorting').val($('.sorters').sortable('toArray').join('#|#'));
        }
        update();


        let loading = false;
        $('.delete').on('click', function(e) {
            if (!loading) {
                loading = true;

                const target = e.currentTarget;
                const parent = target.parentElement.parentElement;
                const category = parent.getAttribute('data-id');
                axios.delete('{{ url('/hadist/categories') }}', {
                    params: {
                        category: category,
                    },
                }).then(function(res) {
                    loading = false;

                    if (res.status == 200 && res.data['result'] == 'success') {
                    }

                    window.location.reload();
                }).catch(function(e) {
                    loading = false;
                });
            }
        });
    </script>
@endpush
