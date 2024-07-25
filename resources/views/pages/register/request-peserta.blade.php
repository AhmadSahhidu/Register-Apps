@extends('component.layout.app')
@section('content')
    @include('component.partial.alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Peserta Tambahan Lomba</h1>
        <a href="{{ route('register.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i
                class="fas fa-backward fa-sm text-white-50 mr-1"></i> Kembali</a>
    </div>

    <div class="row">
        <div class="col-md-8 col-xl-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Peserta Tambahan</h6>
                </div>
                <div class="card-body">
                    <p class="text-sm text-info">Silahkan pilih anggota yang ingin ditambahkan.</p>
                    <form action="{{ route('register.proses-peserta-tambahan', $competision->id) }}" method="POST">
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
                                        class="fa fa-save mr-2"></i>Tambahkan</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#anggota_id").select2();
        });
    </script>
@endpush
