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

            <div class="row">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header header-elements-inline bg-white">
                            <h6 class="card-title font-weight-bold">Simulasi Rawat Inap</h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="kelas" class="col-form-label font-weight-bold">Kelas</label>
                                <select name="kelas" id="kelas" class="form-control">
                                    <option value=""> -- Pilih Kelas -- </option>
                                    <option value="I">I</option>
                                    <option value="II">II</option>
                                    <option value="III">III</option>
                                    <option value="VIP">VIP</option>
                                    <option value="VVIP">VVIP</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="ruang" class="col-form-label font-weight-bold">Ruang</label>
                                <select name="ruang" id="ruang" class="form-control">
                                    <option value=""> -- Pilih Ruang -- </option>
                                </select>
                            </div>
                            <hr />

                            <div class="form-group">
                                <label for="tindakan_1" class="col-form-label font-weight-bold">Tindakan Ruangan</label>
                                <select name="tindakan_1" id="tindakan_1" class="form-control tindakan" disabled="true">
                                    <option value=""> -- Pilih Tindakan -- </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="jumlah_1" class="col-form-label font-weight-bold">Jumlah</label>
                                <input type="text" name="jumlah_1" id="jumlah_1" class="form-control tindakan" disabled="true">
                            </div>

                            <button class="btn btn-outline-primary btn-sm btn-tambah tindakan" id="btn_tambah_1" disabled="true">Tambah</button>
                            <hr />

                            <div class="form-group">
                                <label for="tindakan_2" class="col-form-label font-weight-bold">Tindakan Laboratorium</label>
                                <select name="tindakan_2" id="tindakan_2" class="form-control tindakan" disabled="true">
                                    <option value=""> -- Pilih Tindakan -- </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="jumlah_2" class="col-form-label font-weight-bold">Jumlah</label>
                                <input type="text" name="jumlah_2" id="jumlah_2" class="form-control tindakan" disabled="true">
                            </div>

                            <button class="btn btn-outline-primary btn-sm btn-tambah tindakan" id="btn_tambah_2" disabled="true">Tambah</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header header-elements-inline bg-white">
                            <h6 class="card-title font-weight-bold">Rincian</h6>
                        </div>

                        <div class="card-body">
                            <h3 class="font-weight-bold">Grand Total : <span id="grand_total_text">0</span></h3>
                            <table class="table table-hovered table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <td>Nama Tindakan</td>
                                        <td>Tarif</td>
                                        <td>Jumlah</td>
                                        <td>Subtotal</td>
                                        <td>#</td>
                                    </tr>
                                </thead>
                                <tbody id="rincian"></tbody>
                            </table>
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
        $(document).on('change', '#kelas', function(){
            var kelas = $(this).val();

            if(kelas != ''){
                $.ajax({
                    url: '{{ route('api.ruang') }}/' + kelas,
                    dataType: 'json',
                    data: { },
                    success: function(data) {
                        $('#ruang').html('<option value=""> -- Pilih Ruang -- </option>');
                        $.each(data, function(index, value){
                            $('#ruang').append('<option value="' + value.id + '">' + value.nama + '</option>');
                        });
                    },
                    error: function(xhr) {
                        console.log(xhr);
                    }
                });
            } else {
                $('#ruang').html('<option value=""> -- Pilih Ruang -- </option>');
            }
        });

        $(document).on('change', '#ruang', function(){
            var ruang = $(this).val();
            var kelas = $('#kelas').val();

            if(ruang != '') {
                $('.tindakan').attr('disabled', false);
                load_tindakan(1, kelas);
                load_tindakan(2, null);
            } else {
                $('.tindakan').attr('disabled', true);
                $('#kelas').html('<option value=""> -- Pilih Ruang -- </option>');
            }
        });

        function load_tindakan(jenis, kelas){
            if(kelas == null) {
                var url = '{{ url('api/tindakan/') }}/' + jenis;
            } else {
                var url = '{{ url('api/tindakan/') }}/' + jenis + '/' + kelas;
            }

            $.ajax({
                url: url,
                dataType: 'json',
                data: { },
                success: function(data) {
                    $('#tindakan_' + jenis).html('<option value=""> -- Pilih Tindakan -- </option>');
                    $.each(data, function(index, value){
                        $('#tindakan_' + jenis).append('<option value="' + value.id + '">' + value.nama + '</option>');
                    });
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }

        $(document).on('click', '.btn-tambah', function(){
            var jenis = ($(this).attr('id')).replace('btn_tambah_', '');
            var tindakan = $('#tindakan_' + jenis).val();
            var jumlah = $('#jumlah_' + jenis).val();

            $.ajax({
                url: '{{ url('api/tarif/') }}/' + tindakan,
                dataType: 'json',
                data: { },
                success: function(data) {
                    $('#rincian').append('<tr>'+
                        '<td>'+ data.nama +'</td>'+
                        '<td>Rp. '+ data.tarif +'</td>'+
                        '<td>'+ jumlah +'</td>'+
                        '<td class="subtotal">Rp. '+ (data.tarif * jumlah) +'</td>'+
                        '<td><button class="btn btn-outline-danger btn-delete btn-sm" data-id="'+ 1 +'">Hapus</td>'+
                    '</tr>');

                    $('#tindakan_' + jenis).val('');
                    $('#jumlah_' + jenis).val('');

                    hitungGrandTotal();
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        });

        $(document).on('click', '.btn-delete', function(){
            var index = $('.btn-delete').index(this);
            $('#rincian tr').eq(index).remove();

            hitungGrandTotal();
        });

        function hitungGrandTotal()
        {
            var banyak = $('.subtotal').length;
            var total = 0;

            for(var i = 0; i < banyak; i++) {
                var value = ($('.subtotal').eq(i).html()).replace('Rp. ', '');
                console.log(value);

                total += parseFloat(value);
            }

            console.log(total);

            $('#grand_total_text').text('Rp. ' + total);
        }
    </script>
@endsection
