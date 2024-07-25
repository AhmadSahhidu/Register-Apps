@extends('component.layout.app')
@push('style')
    <link href="{{ asset('./assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    @include('component.partial.alert')
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pendaftaran Kompetisi</h1>

    </div>

    <div class="row">

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Pendaftaran</h6>
                </div>
                <div class="card-body">
                    <p class="text-sm text-info">Silahkan pilih anggota yang ingin didaftarkan.</p>
                    <form action="{{ route('register.process-register', $competision->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-12">
                                <select name="anggota_id" class="form-control mt-1" id="anggota_id">
                                    <option selected disabled>Pilih Anggota</option>
                                    @foreach ($anggota as $items)
                                        <option value="{{ $items->id }}">{{ $items->name }} ({{ $items->phone }}) -
                                            {{ $items->address }} </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <hr />
                                <button type="submit" class="btn btn-sm btn-success"><i
                                        class="fa fa-save mr-2"></i>Daftarkan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection
@push('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@push('script')
    <script src="{{ asset('./assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('./assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('./assets/js/demo/datatables-demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#anggota_id").select2();

        })
    </script>
@endpush
