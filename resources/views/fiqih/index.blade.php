@extends('layouts.app')

@section('title', 'Fiqih')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Fiqih</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Fiqih</h3>

                <a href="{{ route('fiqih.create') }}" class="btn btn-secondary btn-sm">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div></div>
                <form action="{{ route('fiqih.index') }}">
                    <input type="search" class="form-control" name="search" placeholder="Search">
                </form>
            </div>
            <div class="table-responsive">
                <table id="table1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Dokumen</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paginate['data'] as $item)
                            <tr>
                                <td>{{ $item['title'] }}</td>
                                <td>
                                    @if ($item['source']['found'])
                                        <a href="{{ $item['source']['path'] }}">Download</a>
                                    @else
                                        Not found
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('fiqih.edit', ['fiqih' => $item['uuid']]) }}" class="btn btn-warning">
                                        Ubah
                                    </a>
                                    <form action="{{ route('fiqih.destroy', ['fiqih' => $item['uuid']]) }}" method="post">
                                        @csrf
                                        @method('delete')

                                        <button type="submit" class="btn btn-danger">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="4">Data tidak ditemukan.</td>
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
                <li class="page-item @if (empty($paginate['meta']['previous'])) disabled @endif">
                    <a class="page-link" href="{{ route('fiqih.index', ['cursor' => $paginate['meta']['previous'], 'search' => request()->search]) }}">
                        &laquo;
                    </a>
                </li>
                <li class="page-item @if (empty($paginate['meta']['next'])) disabled @endif">
                    <a class="page-link" href="{{ route('fiqih.index', ['cursor' => $paginate['meta']['next'], 'search' => request()->search]) }}">
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
