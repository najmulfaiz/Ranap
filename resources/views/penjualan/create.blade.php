@extends('layouts.main')

@section('title')
    Penjualan Apotek
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
                    <h6 class="card-title font-weight-bold">Penjualan</h6>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label for="pasien" class="col-md-3">Pasien</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="pasien" id="pasien">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nomr" class="col-md-3">Nomor Rekam Medis</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="nomr" id="nomr" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="nama" class="col-md-3">Nama</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="nama" id="nama" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="alamat" class="col-md-3">Alamat</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="alamat" id="alamat" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="penjamin" class="col-md-3">Penjamin</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="penjamin" id="penjamin" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="ruang" class="col-md-3">Ruang</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="ruang" id="ruang" readonly>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="dokter" class="col-md-3">Dokter</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="dokter" id="dokter" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 offset-1">
                            <div class="form-group row">
                                <label for="obat" class="col-md-3">Nama Obat</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="obat" id="obat">
                                    <input type="hidden" class="form-control" name="hna" id="hna">
                                    <input type="hidden" class="form-control" name="obat_id" id="obat_id">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jumlah" class="col-md-3">Jumlah</label>
                                <div class="col-md-9">
                                    <input type="number" class="form-control" name="jumlah" id="jumlah">
                                </div>
                            </div>
                            <h1 class="font-weight-bold">Total : <span id="total_text">0</span></h1>
                            <hr />
                            <form id="form_item" method="post" action="{{ route('penjualan.store') }}">
                                @csrf
                                <input type="text" class="form-control" name="pendaftaran_id" id="pendaftaran_id" readonly>
                                <input type="text" class="form-control" name="total" id="total" readonly>
                                <table class="table table-bordered table-striped table-hovered">
                                    <thead>
                                        <tr>
                                            <th>Nama Obat</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Subtotal</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table_item"></tbody>
                                </table>
                                <hr>
                                <button type="button" class="btn btn-primary btn-sm" id="btn-simpan">Simpan</button>
                            </form>
                        </div>
                    </div>
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
            $('#pasien').autocomplete({
                source: '{{ route('autocomplete.pendaftaran') }}',
                search: function() {
                    $(this).parent().addClass('ui-autocomplete-processing');
                },
                open: function() {
                    $(this).parent().removeClass('ui-autocomplete-processing');
                },
                select: function (event, ui) {        
                    var id = ui.item.id;

                    $('#pendaftaran_id').val(id);
                    $('#nomr').val(ui.item.nomr);
                    $('#nama').val(ui.item.nama);
                    $('#alamat').val(ui.item.alamat);
                    $('#penjamin').val(ui.item.penjamin);
                    $('#ruang').val(ui.item.ruang);
                    $('#dokter').val(ui.item.dokter);

                    $(this).val(ui.item.value);
                    $('#obat').focus();
                    
                    return false;
                }
            });

            $('#obat').autocomplete({
                source: '{{ route('autocomplete.obat') }}',
                search: function() {
                    $(this).parent().addClass('ui-autocomplete-processing');
                },
                open: function() {
                    $(this).parent().removeClass('ui-autocomplete-processing');
                },
                select: function (event, ui) {        
                    var id = ui.item.id;
                    
                    $('#obat_id').val(ui.item.id);
                    $('#hna').val(ui.item.hna);
                    
                    $(this).val(ui.item.value);
                    $('#jumlah').focus();
                    return false;
                }
            });
        });

        $(document).on('keypress', '#jumlah', function(e){
            var key = e.which;
            if(key == 13) {
                var id = $('#obat_id').val();
                var nama = $('#obat').val();
                var hna = $('#hna').val();
                var jumlah = $(this).val();
                var subtotal = hna * jumlah;

                var tag = '<tr>'+
                    '<td>'+nama+'<input type="hidden" class="form-control obat_id" name="obat_id[]" value="'+id+'"></td>'+
                    '<td>'+hna+'<input type="hidden" class="form-control hna" name="hna[]" value="'+hna+'"></td>'+
                    '<td>'+jumlah+'<input type="hidden" class="form-control jumlah" name="jumlah[]" value="'+jumlah+'"></td>'+
                    '<td>'+subtotal+'<input type="hidden" class="form-control subtotal" name="subtotal[]" value="'+subtotal+'"></td>'+
                    '<td><button class="btn btn-danger btn-sm btn-hapus">Hapus</button></td>'+
                '</tr>';
                $('#table_item').append(tag);

                $('#obat').val('').focus();
                $('#obat_id').val('');
                $('#hna').val('');
                $(this).val('');
                hitungTotal();
            };
        });

        $(document).on('click', '.btn-hapus', function(){
            var index = $('.btn-hapus').index(this);
            $('#table_item tr').eq(index).remove();
            hitungTotal();
        });

        function hitungTotal()
        {
            var banyak = $('.subtotal').length;
            var total = 0;

            for(var i = 0; i < banyak; i++) {
                total += parseFloat( $('.subtotal').eq(i).val() );
            }

            $('#total_text').text(total);
            $('#total').val(total);
        }

        $(document).on('click', '#btn-simpan', function(){
            var pendaftaran_id = $('#pendaftaran_id').val();
            var banyak = $('.subtotal').length;

            if(pendaftaran_id != '' && banyak > 0) {
                $('#form_item').submit();
            } else {
                alert('Lengkapi form untuk menyimpan data.');
            }
        });
    </script>
@endsection
