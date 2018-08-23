@extends('layouts.main')

@section('title')
    Ruang Rawat Inap
@endsection

@section('content')

<!-- resume modal -->
<div id="modal_resume_medis" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Resume Medis</h5>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="resume_medis">Resume Medis</label>
                    <textarea name="resume_medis" id="resume_medis" rows="5" class="form-control">{{ $pendaftaran->resume }}</textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button type="button" class="btn bg-primary" id="simpan_resume_medis">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- resume modal -->

<!-- resume modal -->
<div id="modal_resume_pulang" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Resume Pulang</h5>
            </div>

            <div class="modal-body">
                <div class="form-group">
                    <label for="status">Status Pulang</label>
                    <select name="status" id="status" class="form-control">
                        <option value=""> -- Status Pulang -- </option>
                        <option value="1">Atas Izin Dokter</option>
                        <option value="2">Atas Permintaan Sendiri</option>
                        <option value="3">Kabur</option>
                        <option value="4">Dirujuk ke Rumah Sakit lain</option>
                        <option value="5">Meninggal Dunia</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">Close</button>
                <button type="button" class="btn bg-primary" id="simpan_resume_pulang">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- resume modal -->

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
                                    <td class="font-weight-bold" width="25%">Nomor RM</td>
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
                                <tr>
                                    <td class="font-weight-bold">Diagnosis Masuk</td>
                                    <td>:</td>
                                    <td>{{ $pendaftaran->diagnosis_masuk }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <hr />
                    <a href="{{ route('ranap.pembayaran', $pendaftaran->id) }}" class="btn btn-primary btn-sm">Daftar Pembayaran</a>
                    <a href="{{ route('ranap.tindakan', $pendaftaran->id) }}" class="btn btn-primary btn-sm">Tambah Tindakan</a>
                    <button class="btn btn-primary btn-sm" id="btn_resume_medis">Resume Medis</button>
                    <button class="btn btn-primary btn-sm" id="btn_resume_pulang">Resume Pulang</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).on('click', '#btn_resume_medis', function(){
            $('#modal_resume_medis').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        $(document).on('click', '#btn_resume_pulang', function(){
            $('#modal_resume_pulang').modal({
                backdrop: 'static',
                keyboard: false
            });
        });

        $(document).on('click', '#simpan_resume_medis', function(){
            var resume_medis = $('#resume_medis').val();
            
            if(resume_medis != '') {
                $.ajax({
                    url: '{{ route('ranap.resume', $pendaftaran->id) }}',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        _token: _token,
                        _method: 'PATCH',
                        resume_medis: resume_medis
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
            } else {
                alert('Form masih kosong');
            }
        });

        $(document).on('click', '#simpan_resume_pulang', function(){
            var _token = $('meta[name=csrf-token]').attr('content');
            var status = $('#status').val();
            
            if(status != '') {
                if(confirm('Apakah anda yakin untuk memulangkan pasien ini?')) {
                    $.ajax({
                        url: '{{ route('ranap.pulang', $pendaftaran->id) }}',
                        dataType: 'json',
                        type: 'post',
                        data: {
                            _token: _token,
                            _method: 'PATCH',
                            status: status
                        },
                        success: function(data) {
                            if(!data.error) {
                                window.location = '{{ route('ranap.index') }}';
                            }
                        },
                        error: function(xhr) {
                            console.log(xhr.status);
                        }
                    });
                }
            } else {
                alert('Status belum dipilih');
            }
        });
    </script>
@endsection
