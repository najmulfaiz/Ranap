@extends('layouts.main')

@section('title')
    Master Obat
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline bg-white">
                    <h6 class="card-title font-weight-bold">Tambah Obat</h6>
                </div>

                <form action="{{ route('obat.store') }}" method="post">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" autocomplete="off" value="{{ old('nama') }}">
                        @if ($errors->has('nama'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nama') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="hna">HNA</label>
                        <input type="number" class="form-control{{ $errors->has('hna') ? ' is-invalid' : '' }}" name="hna" autocomplete="off" value="{{ old('hna') }}">
                        @if ($errors->has('hna'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('hna') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('obat.index') }}" class="btn btn-secondary btn-sm">Batal</a>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
