@extends('layouts.main')

@section('title')
    Simulasi
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
                    <h6 class="card-title font-weight-bold">Simulasi Rawat Inap</h6>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="ruang" class="form-label font-weight-bold">Tindakan Ruang</label>
                                <input type="text" name="ruang" id="ruang" class="form-control">
                            </div>
                            <h3 class="mt-2 font-weight-bold">Grand Total : <span id="grand_total_text">0</span></h3>
                        </div>
                        <div class="col-md-3 offset-1">
                            <div class="form-group">
                                <label for="laboratorium" class="form-label font-weight-bold">Tindakan Laboratorium</label>
                                <input type="text" name="laboratorium" id="laboratorium" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3 offset-1">
                            <div class="form-group">
                                <label for="obat" class="form-label font-weight-bold">Obat</label>
                                <input type="text" name="obat" id="obat" class="form-control">
                                <input type="hidden" name="hna" id="hna" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="jumlah" class="form-label font-weight-bold">Jumlah</label>
                                <input type="text" name="jumlah" id="jumlah" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header header-elements-inline bg-white">
                            <h6 class="card-title font-weight-bold">Rincian Tindakan</h6>
                        </div>

                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hovered">
                                <thead>
                                    <tr>
                                        <th>Nama Tindakan</th>
                                        <th>Tarif</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody id="rincian_tindakan"></tbody>
                            </table>
                            <h3 class="mt-2 font-weight-bold">Total : <span id="tindakan_total_text">0</span></h3>
                            <input type="hidden" name="tindakan_total" id="tindakan_total" value="0">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header header-elements-inline bg-white">
                            <h6 class="card-title font-weight-bold">Rincian Obat</h6>
                        </div>

                        <div class="card-body">
                            <table class="table table-striped table-bordered table-hovered">
                                <thead>
                                    <tr>
                                        <th>Nama Obat</th>
                                        <th>Harga</th>
                                        <th>Jumlah</th>
                                        <th>Subtotal</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody id="rincian_obat"></tbody>
                            </table>
                            <h3 class="mt-2 font-weight-bold">Total : <span id="obat_total_text">0</span></h3>
                            <input type="hidden" name="obat_total" id="obat_total" value="0">
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
            $('#ruang').autocomplete({
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
                        '<td>' + nama + '</td>'+
                        '<td><input type="hidden" name="tarif" class="tarif" value="' + tarif + '" readonly />' + tarif + '</td>'+
                        '<td><button class="btn btn-danger btn-sm btn-delete-tindakan">Delete</button></td>'+
                    '</tr>';
                    $('#rincian_tindakan').append(tag);

                    $(this).val("");
                    hitungRincianTindakan();
                    return false;
                }
            });

            $('#laboratorium').autocomplete({
                source: '{{ route('autocomplete.tindakan', 2) }}',
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
                        '<td>' + nama + '</td>'+
                        '<td><input type="hidden" name="tarif" class="tarif" value="' + tarif + '" readonly />' + tarif + '</td>'+
                        '<td><button class="btn btn-danger btn-sm btn-delete-tindakan">Delete</button></td>'+
                    '</tr>';
                    $('#rincian_tindakan').append(tag);

                    $(this).val("");
                    hitungRincianTindakan();
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
                    $('#hna').val(ui.item.hna);
                    $(this).val(ui.item.value);

                    $('#jumlah').focus();
                    return false;
                }
            });
        });

        $(document).on('click', '.btn-delete-tindakan', function(){
            var index = $('.btn-delete-tindakan').index(this);
            $('#rincian_tindakan tr').eq(index).remove();

            hitungRincianTindakan();
        });

        $(document).on('click', '.btn-delete-obat', function(){
            var index = $('.btn-delete-obat').index(this);
            $('#rincian_obat tr').eq(index).remove();

            hitungRincianObat();
        });

        $(document).on('keypress', '#jumlah', function(e){
            if(e.keyCode == 13) {
                var nama = $('#obat').val();
                var hna = $('#hna').val();
                var jumlah = $(this).val();
                var total = parseInt(hna) * parseInt(jumlah);
                
                var tag = '<tr>'+
                    '<td>' + nama + '</td>'+
                    '<td><input type="hidden" name="harga" class="harga" value="' + hna + '" readonly />' + hna + '</td>'+
                    '<td><input type="hidden" name="jumlah" class="jumlah" value="' + jumlah + '" readonly />' + jumlah + '</td>'+
                    '<td><input type="hidden" name="subtotal" class="subtotal" value="' + total + '" readonly />' + total + '</td>'+
                    '<td><button class="btn btn-danger btn-sm btn-delete-obat">Delete</button></td>'+
                '</tr>';
                $('#rincian_obat').append(tag);

                $('#obat').val('').focus();
                $('#hna').val('');
                $(this).val('');
                hitungRincianObat();
            }
        });

        function hitungRincianTindakan()
        {
            var banyak = $('.tarif').length;
            var total = 0;

            for(var i = 0; i < banyak; i++) {
                total += parseFloat( $('.tarif').eq(i).val() );
            }

            $('#tindakan_total_text').text(total);
            $('#tindakan_total').val(total);
            hitungGrandTotal();
        }

        function hitungRincianObat()
        {
            var banyak = $('.subtotal').length;
            var total = 0;

            for(var i = 0; i < banyak; i++) {
                total += parseFloat( $('.subtotal').eq(i).val() );
            }

            $('#obat_total_text').text(total);
            $('#obat_total').val(total);
            hitungGrandTotal();
        }

        function hitungGrandTotal()
        {
            var tindakan = $('#tindakan_total').val();
            var obat = $('#obat_total').val();
            var total = parseInt(tindakan) + parseInt(obat);

            $('#grand_total_text').text(total);
        }
    </script>
@endsection
