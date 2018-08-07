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
                    <h6 class="card-title font-weight-bold">Tindakan Pasien</h6>
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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tindakan">Cari Tindakan</label>
                                <input type="text" nama="tindakan" id="tindakan" class="form-control">
                            </div>
                        </div>
                    </div>
                    <hr />
                    <form action="{{ route('pembayaran.tindakan') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $pendaftaran->id }}" name="pendaftaran_id" readonly>
                        <input type="hidden" value="1" name="jenis_tarif_id" readonly>
                        <table class="table table-striped table-hovered table-bordered">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Tarif</th>
                                    <th>Opsi</th>
                                </tr>
                            </thead>
                            <tbody id="table_rincian"></tbody>
                        </table>
                        <button class="btn btn-primary btn-sm mt-2">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/global/js/plugins/extensions/jquery_ui/widgets.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            $('#tindakan').autocomplete({
                source: '{{ route('autocomplete.tindakan', 1) }}',
                search: function() {
                    $(this).parent().addClass('ui-autocomplete-processing');
                },
                open: function() {
                    $(this).parent().removeClass('ui-autocomplete-processing');
                },
                select: function (event, ui) {        
                    var id = ui.item.id;
                    var nama = ui.item.value;
                    var tarif = ui.item.tarif;
                    var tag = '<tr>'+
                        '<td><input type="hidden" name="tarif_id[]" value="' + id + '" readonly />' + nama + '</td>'+
                        '<td><input type="hidden" name="tarif[]" value="' + tarif + '" readonly />' + tarif + '</td>'+
                        '<td><button class="btn btn-danger btn-sm btn-delete">Delete</button></td>'+
                    '</tr>';
                    $('#table_rincian').append(tag);

                    $(this).val("");
                    return false;
                }
            });
        });

        $(document).on('click', '.btn-delete', function(){
            var index = $('.btn-delete').index(this);
            $('#table_rincian tr').eq(index).remove();
        });
    </script>
@endsection
