@extends('layouts.app')

@section('title', 'Diklat')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Kajian</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Daftar Unit</h3>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div></div>
                <form action="{{ route('study.index') }}">
                    <input type="search" class="form-control" name="search" placeholder="Search">
                </form>
            </div>
            <div class="table-responsive">
                <table id="table1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Judul</th>
                            <th></th>
                    </thead>
                    <tbody>
                        @forelse ($paginate['data'] as $item)
                            <tr>
                                <td>{{ $item['title'] }}</td>
                                <td>{{ $item['url'] }}</td>
                                <td></td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="3">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer d-flex justify-content-between align-items-center">
            <div class="text-sm">
                Total {{ $paginate['meta']['count'] }}
            </div>

            <ul class="pagination pagination-sm m-0 ml-auto">
                <li class="page-item @if (empty($paginate['meta']['previous'])) disable @endif">
                    <a class="page-link" href="{{ route('study.index', ['cursor', $paginate['meta']['previous']]) }}">
                        &laquo;
                    </a>
                </li>
                <li class="page-item @if (empty($paginate['meta']['next'])) disable @endif">
                    <a class="page-link" href="{{ route('study.index', ['cursor', $paginate['meta']['next']]) }}">
                        &raquo;
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endsection

@push('windowhead')
    <!-- SweetAlert2 -->
    <link
        rel="preload"
        as="style"
        fetchpriority="high"
        onload="this.onload=null;this.rel='stylesheet'"
        href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}"
    >
    <!-- DataTables -->
    <link
        rel="preload"
        as="style"
        fetchpriority="high"
        onload="this.onload=null;this.rel='stylesheet'"
        href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}"
    >
    <link
        rel="preload"
        as="style"
        fetchpriority="high"
        onload="this.onload=null;this.rel='stylesheet'"
        href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}"
    >
    <link
        rel="preload"
        as="style"
        fetchpriority="high"
        onload="this.onload=null;this.rel='stylesheet'"
        href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}"
    >
@endpush

@push('windowbody')
    <!-- SweetAlert2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>

    @if (session('notification'))
        <script>
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            Toast.fire({
                icon: 'success',
                title: '{{ session('notification') }}'
            });
        </script>
    @endif
@endpush
