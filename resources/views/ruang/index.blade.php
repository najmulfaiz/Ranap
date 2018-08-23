@extends('layouts.main')

@section('title')
    Master Ruang
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
                    <h6 class="card-title font-weight-bold">Daftar Ruang</h6>
                    <div class="header-elements">
                        <a href="{{ route('ruang.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> &nbsp; Tambah</a>
                    </div>
                </div>

                <div class="card-body">
                    <table class="table table-hovered table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Kelas</th>
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
                'ajax': '{{ route('datatable.ruang') }}'
            });
        });

        $(document).on('click', '.btn-hapus', function(){
            var _token = $('meta[name=csrf-token]').attr('content');
            var id = $(this).attr('data-id');

            if(confirm('Apakah anda yakin?')) {
                $.ajax({
                    url: '{{ route('ruang.index') }}/' + id,
                    dataType: 'json',
                    type: 'post',
                    data: {
                        _token: _token,
                        _method: 'DELETE'
                    },
                    success: function(data) {
                        if(!data.error) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.status);
                    }
                });
            }
        });
    </script>
@endsection
