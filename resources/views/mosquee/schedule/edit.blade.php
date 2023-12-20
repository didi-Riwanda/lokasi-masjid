@extends('layouts.app')

@section('title', 'Ubah Jadwal Masjid')

@section('breadcrumb')
    <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mosquee.index') }}">Masjid</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mosquee.schedule.index', ['mosquee' => $mosquee->uuid]) }}">Jadwal Masjid</a></li>
        <li class="breadcrumb-item active">Ubah Jadwal Masjid</li>
    </ol>
@endsection

@section('content')
    <div class="card card-info">
        <div class="card-header">
            <h3 class="card-title">Ubah Dzikir</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('mosquee.schedule.update', ['mosquee' => $mosquee->uuid, 'schedule' => $schedule->id]) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <div class="row mb-3">
                    <label for="title" class="col-md-4 col-form-label text-md-end">
                        Judul
                    </label>

                    <div class="col-md-8">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $schedule->title) }}" required autocomplete="off">

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="speakers" class="col-md-4 col-form-label text-md-end">
                        Pembicara
                    </label>

                    <div class="col-md-8">
                        <input id="speakers" type="text" class="form-control @error('speakers') is-invalid @enderror" name="speakers" value="{{ old('speakers', $schedule->speakers) }}" required autocomplete="off">

                        @error('speakers')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="day" class="col-md-4 col-form-label text-md-end">
                        Hari
                    </label>

                    <div class="col-md-8">
                        <select id="day" class="form-control @error('day') is-invalid @enderror" name="day" required>
                            <option value="">--- NONE ---</option>
                            @php
                                $days = [
                                    'monday' => 'Senin',
                                    'tuesday' => 'Selasa',
                                    'wednesday' => 'Rabu',
                                    'thursday' => 'Kamis',
                                    'friday' => 'Jum\'at',
                                    'saturday' => 'Sabtu',
                                    'sunday' => 'Ahad / Minggu',
                                ];
                            @endphp
                            @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $row)
                                <option value="{{ $row }}" @if (old('day', $schedule->day) === $row) selected @endif>
                                    {{ $days[$row] }}
                                </option>
                            @endforeach
                        </select>

                        @error('day')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="type" class="col-md-4 col-form-label text-md-end">
                        Jenis
                    </label>

                    <div class="col-md-8">
                        <div class="form-group clearfix @error('type') is-invalid @enderror @error('type') is-invalid @enderror">
                            <div class="icheck-success d-inline mr-3">
                                <input type="radio" class="type-check" name="type" value="kajian" @if (old('type', $schedule->type) === 'kajian') checked @else checked @endif id="checkboxSuccess1">
                                <label for="checkboxSuccess1">
                                    Kajian
                                </label>
                            </div>
                            <div class="icheck-success d-inline mr-3">
                                <input type="radio" class="type-check" name="type" value="tahsin" @if (old('type', $schedule->type) === 'tahsin') checked @endif id="checkboxSuccess2">
                                <label for="checkboxSuccess2">
                                    Tahsin
                                </label>
                            </div>
                            <div class="icheck-success d-inline mr-3">
                                <input type="radio" class="type-check" name="type" value="tahfidz" @if (old('type', $schedule->type) === 'tahfidz') checked @endif id="checkboxSuccess3">
                                <label for="checkboxSuccess3">
                                    Tahfidz
                                </label>
                            </div>
                            <div class="icheck-success d-inline">
                                <input type="radio" class="type-check" name="type" value="dauroh" @if (old('type', $schedule->type) === 'dauroh') checked @endif id="checkboxSuccess4">
                                <label for="checkboxSuccess4">
                                    Dauroh
                                </label>
                            </div>
                        </div>

                        @error('type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="start_time" class="col-md-4 col-form-label text-md-end">
                        Waktu Mulai
                    </label>

                    <div class="col-md-8">
                        <div class="input-group date @error('start_time') is-invalid @enderror" id="starttime" data-target-input="nearest">
                            <input id="start_time" type="text" class="form-control datetimepicker-input @error('start_time') is-invalid @enderror" name="start_time" value="{{ old('start_time') }}" required autocomplete="off" data-target="#starttime" readonly>
                            <div class="input-group-append" data-target="#starttime" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>

                        @error('start_time')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="end_time" class="col-md-4 col-form-label text-md-end">
                        Waktu Selesai
                    </label>

                    <div class="col-md-8">
                        <div class="input-group date @error('end_time') is-invalid @enderror" id="endtime" data-target-input="nearest">
                            <input id="end_time" type="text" class="form-control datetimepicker-input @error('end_time') is-invalid @enderror" name="end_time" value="{{ old('end_time') }}" required autocomplete="off" data-target="#endtime" readonly>
                            <div class="input-group-append" data-target="#endtime" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>

                        @error('end_time')
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
    <!-- Tempusdominus Bootstrap 4 -->
    <link
        rel="preload"
        as="style"
        fetchpriority="high"
        onload="this.onload=null;this.rel='stylesheet'"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}"
    >
    <!-- iCheck for checkboxes and radio inputs -->
    <link
        rel="preload"
        as="style"
        fetchpriority="high"
        onload="this.onload=null;this.rel='stylesheet'"
        href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}"
    >
@endpush

@push('windowbody')
    <!-- momentjs -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

    <script>
        @php
            $startTime = \Illuminate\Support\Carbon::parse($schedule->times);
            $endTime = \Illuminate\Support\Carbon::parse($schedule->times);
        @endphp
        // Date and time picker
        $('#starttime').datetimepicker({
            defaultDate: '{{ $startTime->format('Y-m-d H:i') }}',
            icons: {
                time: 'far fa-clock'
            },
            format: 'YYYY-MM-DD HH:mm',
            minDate: moment(),
        });
        $('#endtime').datetimepicker({
            defaultDate: '{{ $endTime->addSeconds($schedule->duration)->format('Y-m-d H:i') }}',
            icons: {
                time: 'far fa-clock'
            },
            format: 'YYYY-MM-DD HH:mm',
            useCurrent: false,
        });
        $('#starttime').on('change.datetimepicker', function (e) {
            console.log(e.date);
            $('#endtime').datetimepicker('minDate', e.date);
        });
        $('#endtime').on('change.datetimepicker', function (e) {
            $('#starttime').datetimepicker('maxDate', e.date);
        });

        @if (in_array($schedule->type, ['tahfidz', 'tahsin']))
            $('input[name="title"]').attr({
                disabled: true,
            });
            $('input[name="speakers"]').attr({
                disabled: true,
            });
        @endif
        $('.type-check').on('change', function() {
            const boxes = [
                'checkboxSuccess1', // Kajian
                'checkboxSuccess2', // Tahsin
                'checkboxSuccess3', // Tahfidz
                'checkboxSuccess4', // Dauroh
            ];
            const target = this;
            const id = target.id;

            if (boxes.includes(id) && ['checkboxSuccess2', 'checkboxSuccess3'].includes(id)) {
                $('input[name="title"]').attr({
                    disabled: true,
                });
                $('input[name="speakers"]').attr({
                    disabled: true,
                });
            } else {
                $('input[name="title"]').attr({
                    disabled: false,
                });
                $('input[name="speakers"]').attr({
                    disabled: false,
                });
            }
        });
    </script>
@endpush

