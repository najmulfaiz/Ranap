@extends('layouts.main')

@section('title')
    Ruang Rawat Inap
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if (session('pesan'))
                <div class="alert alert-primary alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert"><span>×</span></button>
                    {{ session('pesan') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header header-elements-inline bg-white">
                    <h6 class="card-title font-weight-bold">Daftar Pasien Hari Ini</h6>
                </div>

                <div class="card-body">
                    <table class="table table-hovered table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Ruang</th>
                                <th>Tanggal Masuk</th>
                                <th>Opsi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            var oTable = $('.table').DataTable( {
                'processing': true,
                'serverSide': true,
                'ajax': '{{ route('datatable.pembayaran') }}'
            });
        });
    </script>
@endsection
