@extends('component.layout.app')
@include('component.partial.alert')
@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Kompetisi / Lomba</h1>
        <a href="{{ route('korwil.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i
                class="fas fa-backward fa-sm text-white-50 mr-1"></i> Kembali</a>
    </div>

    <div class="row">
        <div class="col-md-12 col-xl-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('competision.update', $competision->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="code">Nama Lomba</label>
                                    <input class="form-control" value="{{ $competision->name }}" name="name" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Tanggal</label>
                                    <input type="date" class="form-control" value="{{ $competision->tgl }}"
                                        name="tgl" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Jumlah Sesi</label>
                                    <input type="number" min="1" value="{{ $competision->count_session }}"
                                        class="form-control" name="count_session" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Jumlah Gantangan</label>
                                    <input type="number" readonly value="{{ $competision->count_gantangan }}"
                                        min="0" class="form-control" name="count_gantangan" required />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="name">Jumlah Korwil Yang Ikut</label>
                                    <input type="number" min="0" value="{{ $competision->count_korwil }}"
                                        class="form-control" name="count_korwil" required />
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-sm btn-success"><i class="fa fa-save mr-2"></i>Simpan</button>
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
            $("#store_id").select2();
        });
    </script>
@endpush
