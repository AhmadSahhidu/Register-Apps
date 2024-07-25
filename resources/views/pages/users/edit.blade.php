@extends('component.layout.app')
@section('content')
    @include('component.partial.alert')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Input Pengguna</h1>
        <a href="{{ route('users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-warning shadow-sm"><i
                class="fas fa-backward fa-sm text-white-50 mr-1"></i> Kembali</a>
    </div>

    <div class="row">
        <div class="col-md-10 col-xl-10">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Input</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nama Pengguna</label>
                                    <input class="form-control" value="{{ $user->name }}" name="name" required />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Username</label>
                                    <input class="form-control" name="username" value="{{ $user->username }}" required />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="checkbox" name="cek_setpassword" id="cek-setpassword" />
                                    <label for="name">Ubah Password</label>

                                </div>
                            </div>
                            <div class="col-md-12 tmp-setpassword" style="display: none">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Password</label>
                                            <input class="form-control" name="password" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Konfirmasi Password</label>
                                            <input class="form-control" name="password_confirm" />
                                        </div>
                                    </div>
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
            $("#korwil_id").select2();
            $("#role_id").on('change', function() {
                var roles = $(this).val();
                if (roles === '3') {
                    $("#tmpKorwil").show();
                } else {
                    $("#tmpKorwil").hide();
                }
            });
            $("#cek-setpassword").on('click', function() {
                var checked = $(this).prop('checked');
                if (checked) {
                    $(".tmp-setpassword").show();
                } else {
                    $(".tmp-setpassword").hide();
                }
            });

        });
    </script>
@endpush
