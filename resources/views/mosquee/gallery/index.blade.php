@extends('layouts.app')

@section('title', 'Masjid')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mosquee.index') }}">Masjid</a></li>
        <li class="breadcrumb-item active">Galleri</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="card-title">Daftar Masjid</h3>

                <a href="{{ route('mosquee.gallery.create', ['mosquee' => request()->mosquee]) }}" class="btn btn-secondary btn-sm">Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div></div>
                <form action="{{ route('mosquee.gallery.index', ['mosquee' => request()->mosquee]) }}">
                    <input type="search" class="form-control" name="search" placeholder="Search">
                </form>
            </div>
            <div class="table-responsive">
                <table id="table1" class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paginate['data'] as $item)
                            <tr>
                                <td>
                                    @if (Storage::exists($item['source']))
                                        <img src="{{ route('image.url', ['path' => $item['source']]) }}" />
                                    @else
                                        Gambar Tidak Ada
                                    @endif
                                </td>
                                <td>{{ $item['type'] }}</td>
                                <td>
                                    <a href="{{ route('mosquee.gallery.edit', ['mosquee' => $item['mosquee'], 'gallery' => $item['id']]) }}" class="btn btn-warning">
                                        Ubah
                                    </a>
                                    <form action="{{ route('mosquee.gallery.destroy', ['mosquee' => $item['mosquee'], 'gallery' => $item['id']]) }}" method="post">
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
                                <td colspan="6">Data tidak ditemukan.</td>
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
                    <a class="page-link" href="{{ route('mosquee.gallery.index', ['mosquee' => request()->mosquee, 'cursor' => $paginate['meta']['previous'], 'search' => request()->search]) }}">
                        &laquo;
                    </a>
                </li>
                <li class="page-item @if (empty($paginate['meta']['next'])) disabled @endif">
                    <a class="page-link" href="{{ route('mosquee.gallery.index', ['mosquee' => request()->mosquee, 'cursor' => $paginate['meta']['next'], 'search' => request()->search]) }}">
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
