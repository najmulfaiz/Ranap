@extends('layouts.main')

@section('title')
    Master Penjamin
@endsection

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline bg-white">
                    <h6 class="card-title font-weight-bold">Edit Penjamin</h6>
                </div>

                <form action="{{ route('penjamin.update', $penjamin->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control{{ $errors->has('nama') ? ' is-invalid' : '' }}" name="nama" autocomplete="off" value="{{ $penjamin->nama }}">
                        @if ($errors->has('nama'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('nama') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('penjamin.index') }}" class="btn btn-secondary btn-sm">Batal</a>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
