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
                    <h6 class="card-title font-weight-bold">Detail Pasien</h6>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table width="100%">
                                <tr>
                                    <td class="font-weight-bold" width="20%">Nomor RM</td>
                                    <td>:</td>
                                    <td>{{ $pendaftaran->nomr }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Nama Pasien</td>
                                    <td>:</td>
                                    <td>{{ $pendaftaran->pasien->nama }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Alamat Pasien</td>
                                    <td>:</td>
                                    <td>{{ $pendaftaran->pasien->alamat }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Jenis Kelamin</td>
                                    <td>:</td>
                                    <td>{{ $pendaftaran->pasien->jenis_kelamin_text }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Umur</td>
                                    <td>:</td>
                                    <td>{{ $pendaftaran->pasien->umur }} Tahun</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">Penjamin</td>
                                    <td>:</td>
                                    <td>{{ $pendaftaran->penjamin->nama }}</td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold">DPJP</td>
                                    <td>:</td>
                                    <td>{{ $pendaftaran->dokter->nama }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr />
                    <table class="table table-striped table-hovered table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Tarif</th>
                                <th>Jenis Tarif</th>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
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
                'ajax': '{{ route('datatable.pembayaran.show', $pendaftaran->id) }}'
            });
        });
    </script>
@endsection