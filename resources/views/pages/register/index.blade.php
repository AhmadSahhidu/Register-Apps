@extends('component.layout.app')
@push('style')
    <link href="{{ asset('./assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    @include('component.partial.alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Kompetisi / Lomba</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">List Kompetisi / Lomba</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Tanggal</th>
                            <th>Jumlah Sesi</th>
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
                                <td>
                                    <a href="{{ route('register.session-register', $items->id) }}"
                                        class="btn btn-sm btn-success">
                                        Daftar
                                    </a>
                                    <a href="{{ route('register.list-peserta', $items->id) }}"
                                        class="btn btn-sm btn-primary">
                                        List Peserta
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

        })
    </script>
@endpush
