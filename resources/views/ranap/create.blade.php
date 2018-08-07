@extends('layouts.main')

@section('title')
    Pendaftaran
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline bg-white">
                    <h6 class="card-title font-weight-bold">Pendaftaran Pasien Baru</h6>
                </div>

                <form action="{{ route('pendaftaran.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jenis">Jenis Pasien</label>
                                <select name="jenis" id="jenis" class="form-control">
                                    <option value="1">Pasien Baru</option>
                                    <option value="2">Pasien Lama</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="nomr">Nomor Rekam Medis</label>
                                <div class="input-group">
                                    @if(old('jenis') == 2)
                                        <input type="text" id="nomr" class="form-control{{ $errors->has('nomr') ? ' is-invalid' : '' }}" name="nomr" autocomplete="off" value="{{ old('nomr') }}">
                                    @else
                                        <input type="text" id="nomr" class="form-control{{ $errors->has('nomr') ? ' is-invalid' : '' }}" name="nomr" autocomplete="off" value="-- NOMOR OTOMATIS --" readonly>
                                    @endif
                                    <span class="input-group-append">
                                        <button class="btn btn-light" id="btn_cari" type="button">Cari</button>
                                    </span>
                                </div>

                                @if ($errors->has('nomr'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nomr') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="nama">Nama Pasien</label>
                                <input type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" autocomplete="off" value="{{ old('nama') }}">
                                @if ($errors->has('nama'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nama') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input type="text" class="form-control{{ $errors->has('tempat_lahir') ? ' is-invalid' : '' }}" name="tempat_lahir" autocomplete="off" value="{{ old('tempat_lahir') }}">
                                @if ($errors->has('tempat_lahir'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tempat_lahir') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                                <input type="date" class="form-control{{ $errors->has('tanggal_lahir') ? ' is-invalid' : '' }}" name="tanggal_lahir" autocomplete="off" value="{{ old('tanggal_lahir') }}">
                                @if ($errors->has('tanggal_lahir'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tanggal_lahir') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="d-block font-weight-semibold">Jenis Kelamin {{ $errors->first('jenis_kelamin') }}</label>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="jenis_kelamin" value="1" {{ old('jenis_kelamin') == 1 ? 'selected' : '' }}>
                                        Laki-laki
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="jenis_kelamin" value="2" {{ old('jenis_kelamin') == 2 ? 'selected' : '' }}>
                                        Perempuan
                                    </label>
                                </div>
                                @if ($errors->has('jenis_kelamin'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('jenis_kelamin') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea name="alamat" id="alamat" rows="5" class="form-control{{ $errors->has('alamat') ? ' is-invalid' : '' }}">{{ old('alamat') }}</textarea>
                                @if ($errors->has('alamat'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('alamat') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="provinsi_id">Provinsi</label>
                                <select name="provinsi_id" id="provinsi_id" class="form-control{{ $errors->has('provinsi_id') ? ' is-invalid' : '' }}">
                                    <option value=""> -- Pilih Provinsi -- </option>
                                </select>
                                @if ($errors->has('provinsi_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('provinsi_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="kabupaten_id">Kabupaten</label>
                                <select name="kabupaten_id" id="kabupaten_id" class="form-control{{ $errors->has('kabupaten_id') ? ' is-invalid' : '' }}">
                                    <option value=""> -- Pilih Kabupaten -- </option>
                                </select>
                                @if ($errors->has('kabupaten_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('kabupaten_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="kecamatan_id">Kecamatan</label>
                                <select name="kecamatan_id" id="kecamatan_id" class="form-control{{ $errors->has('kecamatan_id') ? ' is-invalid' : '' }}">
                                    <option value=""> -- Pilih Kecamatan -- </option>
                                </select>
                                @if ($errors->has('kecamatan_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('kecamatan_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="kelurahan_id">Kelurahan</label>
                                <select name="kelurahan_id" id="kelurahan_id" class="form-control{{ $errors->has('kelurahan_id') ? ' is-invalid' : '' }}">
                                    <option value=""> -- Pilih Kelurahan -- </option>
                                </select>
                                @if ($errors->has('kelurahan_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('kelurahan_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="golongan_darah">Golongan Darah</label>
                                <select name="golongan_darah" id="golongan_darah" class="form-control{{ $errors->has('golongan_darah') ? ' is-invalid' : '' }}">
                                    <option value=""> -- Pilih Golongan Darah -- </option>
                                    @foreach($goldar as $goldar)
                                        <option value="{{ $goldar }}" {{ $goldar == old('golongan_darah') ? 'selected' : '' }}>{{ $goldar }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('golongan_darah'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('golongan_darah') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="diagnosis_masuk">Diagnosis Masuk</label>
                                <input type="text" name="diagnosis_masuk" id="diagnosis_masuk" class="form-control{{ $errors->has('diagnosis_masuk') ? ' is-invalid' : '' }}" value="{{ old('diagnosis_masuk') }}" />
                                @if ($errors->has('diagnosis_masuk'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('diagnosis_masuk') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="kelas_id">Kelas</label>
                                <select name="kelas_id" id="kelas_id" class="form-control{{ $errors->has('kelas_id') ? ' is-invalid' : '' }}">
                                    <option value=""> -- Pilih Kelas -- </option>
                                    @foreach($kelas as $kelas)
                                        <option value="{{ $kelas }}" {{ $kelas == old('kelas_id') ? 'selected' : '' }}>{{ $kelas }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('kelas_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('kelas_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="ruang_id">Ruang</label>
                                <select name="ruang_id" id="ruang_id" class="form-control{{ $errors->has('ruang_id') ? ' is-invalid' : '' }}">
                                    <option value=""> -- Pilih Ruang -- </option>
                                </select>
                                @if ($errors->has('ruang_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ruang_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="dokter_id">Dokter</label>
                                <select name="dokter_id" id="dokter_id" class="form-control{{ $errors->has('dokter_id') ? ' is-invalid' : '' }}">
                                    <option value=""> -- Pilih Dokter -- </option>
                                    @foreach($dokter as $dokter)
                                        <option value="{{ $dokter->id }}" {{ $dokter->id == old('dokter_id') ? 'selected' : '' }}>{{ $dokter->nama }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('dokter_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('dokter_id') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="penjamin_id">Penjamin</label>
                                <select name="penjamin_id" id="penjamin_id" class="form-control{{ $errors->has('penjamin_id') ? ' is-invalid' : '' }}">
                                    <option value=""> -- Pilih Penjamin -- </option>
                                    @foreach($penjamin as $penjamin)
                                        <option value="{{ $penjamin->id }}" {{ $penjamin->id == old('penjamin_id') ? 'selected' : '' }}>{{ $penjamin->nama }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('penjamin_id'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('penjamin_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('dokter.index') }}" class="btn btn-secondary btn-sm">Batal</a>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            load_select('provinsi', '', '');
        });

        $(document).on('change', '#jenis', function(){
            if($(this).val() == 2) {
                $('#nomr').val('').removeAttr('readonly');
            } else {
                $('#nomr').val('-- NOMOR OTOMATIS --').attr('readonly');
            }
        });

        $(document).on('click', '#btn_cari', function(){
            var jenis = $('#jenis').val();
            var nomr = $('#nomr').val();

            if(jenis == 2) {
                cari_pasien(nomr, function(res){
                    if(res.length) {
                        var pasien = res[0];
                        $('input[name=nama]').val(pasien.nama);
                        $('input[name=tempat_lahir]').val(pasien.tempat_lahir);
                        $('input[name=tanggal_lahir]').val(pasien.tanggal_lahir);
                        $('input[name=jenis_kelamin][value=' + pasien.jenis_kelamin + ']').prop('checked', true);
                        $('textarea[name=alamat]').val(pasien.alamat);
                        $('select[name=provinsi_id]').val(pasien.provinsi_id);
                        load_select('kabupaten', pasien.provinsi_id, pasien.kabupaten_id);
                        load_select('kecamatan', pasien.kabupaten_id, pasien.kecamatan_id);
                        load_select('kelurahan', pasien.kecamatan_id, pasien.kelurahan_id);
                    } else {
                        console.log('Ora Ketemu');
                    }
                });
            }
        });

        $(document).on('change', '#kelas_id', function(){
            var kelas = $(this).val();
            if(kelas) {
                load_ruang(kelas);
            } else {
                $('#ruang_id').html('<option value=""> -- Pilih Ruang -- </option>');
            }
        });

        $(document).on('change', '#provinsi_id', function(){
            var id = $(this).val();

            if(id) {
                load_select('kabupaten', id, '');
            } else {
                $('#kabupaten_id').html('<option value=""> -- Pilih Kabupaten -- </option>');
                $('#kecamatan_id').html('<option value=""> -- Pilih Kecamatan -- </option>');
                $('#kelurahan_id').html('<option value=""> -- Pilih Kelurahan -- </option>');
            }
        });

        $(document).on('change', '#kabupaten_id', function(){
            var id = $(this).val();

            if(id) {
                load_select('kecamatan', id, '');
            } else {
                $('#kecamatan_id').html('<option value=""> -- Pilih Kecamatan -- </option>');
                $('#kelurahan_id').html('<option value=""> -- Pilih Kelurahan -- </option>');
            }
        });

        $(document).on('change', '#kecamatan_id', function(){
            var id = $(this).val();

            if(id) {
                load_select('kelurahan', id, '');
            } else {
                $('#kelurahan_id').html('<option value=""> -- Pilih Kelurahan -- </option>');
            }
        });

        function load_daerah(api, res)
        {
            $.ajax({
                url: api,
                dataType: 'json',
                data: { },
                success: function(data) {
                    res(data);
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }

        function load_select(jenis, foreign_id, selected) {
            if(!jenis) return;

            switch(jenis) {
                case 'provinsi':
                    api = '{{ route('api.provinsi') }}';
                    break;
                case 'kabupaten':
                    api = '{{ route('api.kabupaten') }}/' + foreign_id;
                    break;
                case 'kecamatan':
                    api = '{{ route('api.kecamatan') }}/' + foreign_id;
                    break;
                case 'kelurahan':
                    api = '{{ route('api.kelurahan') }}/' + foreign_id;
                    break;
            }

            load_daerah(api, function(res){
                $('#' + jenis + '_id').html('<option value=""> -- Pilih ' + ucfirst(jenis) + ' -- </option>');
                $.each(res, function(index, value){
                    if(value.id == selected) {
                        $('#' + jenis + '_id').append('<option value="' + value.id + '" selected>' + value.name + '</option>');
                    } else {
                        $('#' + jenis + '_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                    }
                });
            });
        }

        function ucfirst(string) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }

        function cari_pasien(nomr, res) {
            $.ajax({
                url: '{{ route('api.pasien') }}',
                dataType: 'json',
                data: { nomr: nomr },
                success: function(data) {
                    res(data);
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }

        function load_ruang(kelas) {
            $.ajax({
                url: '{{ route('api.ruang') }}/' + kelas,
                dataType: 'json',
                data: { },
                success: function(data) {
                    $('#ruang_id').html('<option value=""> -- Pilih Ruang -- </option>');
                    $.each(data, function(index, value){
                        $('#ruang_id').append('<option value="' + value.id + '">' + value.nama + '</option>');
                    });
                },
                error: function(xhr) {
                    console.log(xhr);
                }
            });
        }
    </script>
@endsection