@extends('component.layout.app')
@push('style')
    <link href="{{ asset('./assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    @include('component.partial.alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Koordinasi Wilayah</h1>
        {{-- @if ($aksescreateCategory || $roleuser === 'Super Admin') --}}
        <a href="{{ route('korwil.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                class="fas fa-plus fa-sm text-white-50 mr-1"></i> Tambah Data</a>
        {{-- @endif --}}
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Korwil</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($korwil as $index => $items)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $items->name ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('korwil.show', $items->id) }}"
                                        class="btn btn-sm btn-circle btn-primary" title="Edit Data">
                                        <i class="fa fa-pen"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-circle btn-danger btnDelete"
                                        data-item-id="{{ $items->id }}" title="Hapus Data">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <a href="{{ route('korwil.anggota', $items->id) }}" class="btn btn-sm btn-primary"
                                        title="Edit Data">
                                        List Anggota
                                    </a>

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
                            url: "{{ route('korwil.delete') }}",
                            type: 'GET',
                            data: {
                                korwilId: itemId
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
                                    text: "Terjadi kesalahan saat menghapus data.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            });

        })
    </script>
@endpush
