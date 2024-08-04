@extends('component.layout.app')
@push('style')
    <link href="{{ asset('./assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    @include('component.partial.alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">List Kompetisi</h1>
        <a href="{{ route('competision.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Data</a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Kompetisi</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Tanggal</th>
                            <th>Total Sesi</th>
                            <th>Total Gantangan</th>
                            <th>Total Korwil</th>
                            <th>Total Peserta Korwil</th>
                            <th>Total Peserta Umum</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($competision as $index => $items)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $items->name }}</td>
                                <td>{{ $items->tgl ?? '-' }}</td>
                                <td>{{ $items->count_session ?? '-' }}</td>
                                <td>{{ $items->count_gantangan ?? '-' }}</td>
                                <td>{{ $items->count_korwil ?? '-' }}</td>
                                <td>{{ $items->count_korwil_per_session * $items->count_session ?? '-' }}</td>
                                <td>{{ $items->count_more_per_session ?? '-' }}</td>
                                <td>
                                    @if ($items->status === 0)
                                        <span class="btn btn-sm btn-success">Terbuka</span>
                                    @else
                                        <span class="btn btn-sm btn-danger">Tertutup</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('competision.show', $items->id) }}"
                                        class="btn btn-sm btn-circle btn-primary" title="Edit Data">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-circle btn-danger btnDelete"
                                        data-item-id="{{ $items->id }}" title="Hapus Data">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <a href="{{ route('competision.list-peserta', $items->id) }}"
                                        class="btn btn-sm btn-primary mt-2" title="Edit Data">
                                        Peserta
                                    </a>
                                    @if ($items->status === 0)
                                        <a href="{{ route('competision.close_register', $items->id) }}"
                                            class="btn btn-sm btn-warning mt-2" title="Edit Data">
                                            Tutup Pendaftaran
                                        </a>
                                    @endif

                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('./assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('./assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('./assets/js/demo/datatables-demo.js') }}"></script>
    <script>
        $(document).ready(function() {
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
                            url: "{{ route('competision.delete') }}",
                            type: 'GET',
                            data: {
                                competisionId: itemId
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
