@extends('layouts.main')

@section('title')
    Master Tarif
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline bg-white">
                    <h6 class="card-title font-weight-bold">Edit Layanan</h6>
                </div>

                <form action="{{ route('tarif.update', $tarif->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" autocomplete="off" value="{{ $tarif->nama }}">
                        @if ($errors->has('nama'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nama') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="jenis_tarif_id">Jenis Layanan</label>
                        <select name="jenis_tarif_id" id="jenis_tarif_id" class="form-control{{ $errors->has('jenis_tarif_id') ? ' is-invalid' : '' }}">
                            <option value=""> -- Pilih Jenis Layanan -- </option>
                            @foreach($jenis_tarif as $jenis_tarif)
                                <option value="{{ $jenis_tarif->id }}" {{ $jenis_tarif->id == $tarif->jenis_tarif_id ? 'selected' : '' }}>{{ $jenis_tarif->nama }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('jenis_tarif_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('jenis_tarif_id') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group" id="fg_kelas" style="display: {{ $tarif->jenis_tarif_id == 1 ? 'block' : 'none' }};">
                        <label for="kelas">Kelas</label>
                        <select name="kelas" id="kelas" class="form-control{{ $errors->has('kelas') ? ' is-invalid' : '' }}">
                            <option value=""> -- Pilih Kelas -- </option>
                            @foreach($kelas as $kelas)
                                <option value="{{ $kelas }}" {{ $kelas == $tarif->kelas ? 'selected' : '' }}>{{ $kelas }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('kelas'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('kelas') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="tarif">Tarif</label>
                        <input type="number" class="form-control{{ $errors->has('tarif') ? ' is-invalid' : '' }}" name="tarif" autocomplete="off" value="{{ $tarif->tarif }}">
                        @if ($errors->has('tarif'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('tarif') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('tarif.index') }}" class="btn btn-secondary btn-sm">Batal</a>
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
        $(document).on('change', '#jenis_tarif_id', function(){
            if($(this).val() == 1) {
                $('#fg_kelas').show();
                $('#kelas').val('');
            } else {
                $('#fg_kelas').hide();
                $('#kelas').val('');
            }
        });
    </script>
@endsection