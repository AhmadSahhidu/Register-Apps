@php
    use App\Models\RegisterCompetision;
@endphp
@extends('component.layout.app')
@push('style')
    <link href="{{ asset('./assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    @include('component.partial.alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Peserta Kompetisi</h1>
        <div>
            <a href="{{ route('competision.peserta_tambahan', $competision->id) }}"
                class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                    class="fas fa-users fa-sm text-white-50 mr-1"></i> Peserta Tambahan</a>
            @if ($competision->status !== 0)
                <a href="{{ route('competision.set_session', $competision->id) }}"
                    class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                        class="fas fa-plus fa-sm text-white-50 mr-1"></i>Atur Sesi Peserta</a>
            @endif


        </div>

    </div>

    <div class="row">
        <div class="col-md-3">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Total Gantangan</h6>
                </div>
                <div class="card-body">
                    <h2 class="text-center text-success">{{ $competision->count_gantangan }}</h2>
                    <h4 class="text-xs text-center">Total Seluruh Gantangan</h4>
                </div>
            </div>
        </div>
        @for ($i = 0; $i < $competision->count_session; $i++)
            @php
                $countPesertaSesi = RegisterCompetision::where('competision_id', $competision->id)
                    ->where('no_group', 1)
                    ->where('no_session', $i + 1)
                    ->count();
            @endphp
            <div class="col-md-3">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Jumlah Peserta Sesi {{ $i + 1 }}</h6>
                    </div>
                    <div class="card-body">
                        <h2 class="text-center text-success">{{ $countPesertaSesi }}</h2>
                        <h4 class="text-xs text-center">( Terdapat {{ $competision->count_gantangan - $countPesertaSesi }}
                            gantangan tersisa )</h4>
                    </div>
                </div>
            </div>
        @endfor
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Data Peserta Tidak Ada Sesi </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Lengkap</th>
                                    <th>No Handphone</th>
                                    <th>Alamat</th>
                                    <th>Anggota</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php

                                @endphp
                                @foreach ($peserta as $index => $items)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $items->anggota_name ?? '-' }}</td>
                                        <td>{{ $items->anggota_phone ?? '-' }}</td>
                                        <td>{{ $items->anggota_address ?? '-' }}
                                        </td>
                                        <td>
                                            @if ($items->anggota?->korwil_id !== null)
                                                {{ $items->anggota?->korwil->name ?? '-' }}
                                            @elseif ($items->anggota?->korda_id !== null)
                                                {{ $items->anggota?->korda->name ?? '-' }}
                                            @else
                                                Peserta Umum
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-circle btn-danger btnDelete"
                                                data-item-id="{{ $items->id }}" title="Hapus Data">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @for ($i = 0; $i < $competision->count_session; $i++)
            <div class="col-md-12">

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Data Peserta Sesi {{ $i + 1 }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable-{{ $i + 1 }}" width="100%"
                                cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Lengkap</th>
                                        <th>No Handphone</th>
                                        <th>Alamat</th>
                                        <th>Korwil</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $dataQuery = RegisterCompetision::query();
                                        $dataQuery->select(
                                            'register_competisions.*',
                                            'anggotas.name as anggota_name',
                                            'anggotas.phone as anggota_phone',
                                            'anggotas.address as anggota_address',
                                        );
                                        $dataQuery->join(
                                            'anggotas',
                                            'anggotas.id',
                                            '=',
                                            'register_competisions.anggota_id',
                                        );
                                        $dataQuery->where('register_competisions.no_session', $i + 1);
                                        $dataQuery->where('register_competisions.no_group', 1);
                                        $dataQuery->where('register_competisions.competision_id', $competision->id);

                                        $pesertaSesi = $dataQuery->get();
                                    @endphp
                                    @foreach ($pesertaSesi as $index => $items)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $items->anggota_name ?? '-' }}</td>
                                            <td>{{ $items->anggota_phone ?? '-' }}</td>
                                            <td>{{ $items->anggota_address ?? '-' }}
                                            </td>
                                            <td>
                                                @if ($items->anggota?->korwil_id !== null)
                                                    {{ $items->anggota?->korwil->name ?? '-' }}
                                                @elseif ($items->anggota?->korda_id !== null)
                                                    {{ $items->anggota?->korda->name ?? '-' }}
                                                @else
                                                    Peserta Umum
                                                @endif
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endfor
    </div>
@endsection
@push('script')
    <script src="{{ asset('./assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('./assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('./assets/js/demo/datatables-demo.js') }}"></script>
    <script>
        $(document).ready(function() {
            $("#dataTable-1").DataTable();
            $("#dataTable-2").DataTable();
            $("#dataTable-3").DataTable();
            $("#dataTable-4").DataTable();
            $(document).on('click', '.btnDelete', function() {
                var itemId = $(this).data('item-id');
                Swal.fire({
                    icon: 'question',
                    title: "Apakah anda akan menghapus data ini?",
                    showCancelButton: true,
                    confirmButtonText: "Ya",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('competision.delete_peserta') }}",
                            type: 'GET',
                            data: {
                                pesertaId: itemId
                            },
                            success: function() {
                                Swal.fire({
                                    title: "Deleted!",
                                    text: "Anda berhasil menghapus data.",
                                    icon: "success"
                                });
                                window.location.reload();
                            },
                            error: function() {
                                Swal.fire({
                                    title: "Failed!",
                                    text: "Anda kesalahan saat menghapus data.",
                                    icon: "error"
                                });
                            }
                        })
                    }
                });
            })
        })
    </script>
@endpush
