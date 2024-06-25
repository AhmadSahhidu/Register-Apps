@extends('component.layout.app')
@push('style')
    <link href="{{ asset('./assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endpush
@section('content')
    @include('component.partial.alert')
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pendaftaran Kompetisi</h1>
        <p class="mt-2">Infomasi: Setiap korwil hanya bisa mendaftarkan <b
                class="text-info">{{ $competision->count_korwil_per_session }}
                peserta </b>
            persesinya, ini
            sudah menjadi peraturan dari panitia. Jika ingin mendaftarkan lebih silahkan hubungi panitia terkait dengan
            kompetisi tersebut.</p>
    </div>

    <div class="row">
        @if (!request('session'))
            <div class="col-md-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Sesi Lomba</h6>
                    </div>
                    <div class="card-body">
                        <p>Silahkan pilih sesi lomba yang ingin anda ikuti.</p>
                        <select class="form-control" id="session" required>
                            <option value="">Pilih Sesi Lomba</option>
                            @for ($i = 0; $i < $competision->count_session; $i++)
                                <option value="{{ $i + 1 }}">Sesi {{ $i + 1 }}</option>
                            @endfor
                        </select>
                        <button type="button" id="btnRegister" class="btn btn-sm btn-success mt-3">Daftar</button>
                    </div>
                </div>
            </div>
        @endif
        @if (request('session'))
            <div class="col-md-8">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Form Pendaftaran</h6>
                    </div>
                    <div class="card-body">
                        <p class="text-sm text-info">Silahkan lengkapi form pendaftaran dibawah ini.</p>
                        <form action="{{ route('register.process-register', $competision->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="row">
                                <div class="col-md-6">
                                    <span class="text-sm" for="name">Nama Lengkap</span>
                                    <input type="hidden" name="session" value="{{ request('session') }}"
                                        class="form-control mt-1" />
                                    <input type="" name="name" class="form-control mt-1" />
                                </div>
                                <div class="col-md-6">
                                    <span class="text-sm" for="name">No. Handphone</span>
                                    <input type="text" name="phone" class="form-control mt-1" />
                                </div>
                                <div class="col-md-12">
                                    <span class="text-sm" for="name">Alamat</span>
                                    <input type="text" name="address" class="form-control mt-1" />
                                </div>
                                <div class="col-md-12">
                                    <hr />
                                    <button type="submit" class="btn btn-sm btn-success">Proses Pendaftaran</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif

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
