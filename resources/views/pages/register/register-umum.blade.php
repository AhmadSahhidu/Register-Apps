@extends('component.layout.app')
@push('style')
    <link href="{{ asset('./assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    @include('component.partial.alert')
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pendaftaran Umum</h1>

    </div>

    <div class="row">

        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Pendaftaran</h6>
                </div>
                <div class="card-body">
                    <p class="text-sm text-info">Silahkan lengkapi form pendaftaran dibawah ini.</p>
                    <form action="{{ route('register.store_register_umum', $competision->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-6">
                                <span class="text-sm" for="name">Nama Lengkap</span>
                                <input type="text" name="name" class="form-control mt-1" />
                            </div>
                            <div class="col-md-6">
                                <span class="text-sm" for="name">No. Handphone</span>
                                <input type="text" name="phone" class="form-control mt-1" />
                            </div>
                            <div class="col-md-6 mt-2">
                                <span class="text-sm" for="name">Sesi</span>
                                <select class="form-control" name="session">
                                    @for ($i = 0; $i < $competision->count_session; $i++)
                                        <option value="{{ $i + 1 }}">Sesi {{ $i + 1 }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-6 mt-2">
                                <span class="text-sm" for="name">Alamat</span>
                                <input type="text" name="address" class="form-control mt-1" />
                            </div>
                            <div class="col-md-12">
                                <hr />
                                <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save mr-2"></i>Proses
                                    Pendaftaran</button>
                            </div>
                        </div>
                    </form>
                </div>
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
            $("#btnRegister").on('click', function() {
                var session = $("#session").val();
                if (session === '') {
                    Swal.fire({
                        icon: 'warning',
                        text: "Silahkan masukkan sesi lomba terlebih dahulu",
                    })
                } else {
                    window.location = "{{ route('register.session-register', $competision->id) }}" +
                        "?session=" +
                        session
                }
            })
        })
    </script>
@endpush
