@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Edit Barang</h4>
                    <form action="{{ route('admin.barang.update', $item->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('patch')
                        <div class='form-group mb-3'>
                            <label for='gambar' class='mb-2'>Gambar</label>
                            <input type='file' name='gambar' class='form-control @error('gambar') is-invalid @enderror'
                                value='{{ old('gambar') }}'>
                            @error('gambar')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='kode' class='mb-2'>Kode</label>
                            <input type='text' kode='kode' class='form-control @error('kode') is-invalid @enderror'
                                value='{{ $item->kode }}' readonly>
                            @error('kode')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='nama' class='mb-2'>Nama</label>
                            <input type='text' name='nama' class='form-control @error('nama') is-invalid @enderror'
                                value='{{ $item->nama ?? old('nama') }}'>
                            @error('nama')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='jenis_id' class='mb-2'>Jenis</label>
                            <select name="jenis_id" id="jenis_id"
                                class="form-control @error('jenis_id') is-invalid @enderror">
                                <option value="" selected disabled>Pilih Jenis</option>
                                @foreach ($data_jenis as $jenis)
                                    <option @selected($jenis->id == $item->jenis_id) value="{{ $jenis->id }}">{{ $jenis->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jenis_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='satuan_id' class='mb-2'>Satuan</label>
                            <select name="satuan_id" id="satuan_id"
                                class="form-control @error('satuan_id') is-invalid @enderror">
                                <option value="" selected disabled>Pilih Satuan</option>
                                @foreach ($data_satuan as $satuan)
                                    <option @selected($satuan->id == $item->satuan_id) value="{{ $satuan->id }}">{{ $satuan->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('satuan_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='harga' class='mb-2'>Harga <span class='text-danger'>*</span></label>
                            <input type='number' name='harga' id='harga'
                                class='form-control @error('harga') is-invalid @enderror'
                                value='{{ $item->harga ?? old('harga') }}'>
                            @error('harga')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='stok_awal' class='mb-2'>Stok Awal</label>
                            <input type='number' name='stok_awal'
                                class='form-control @error('stok_awal') is-invalid @enderror'
                                value='{{ $item->stok_awal ?? old('stok_awal') }}' readonly>
                            @error('stok_awal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='stok_minimal' class='mb-2'>Stok Minimal</label>
                            <input type='number' name='stok_minimal'
                                class='form-control @error('stok_minimal') is-invalid @enderror'
                                value='{{ $item->stok_minimal ?? old('stok_minimal') }}'>
                            @error('stok_minimal')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='deskripsi' class='mb-2'>Deskripsi</label>
                            <textarea name='deskripsi' id='deskripsi' cols='30' rows='3'
                                class='form-control @error('deskripsi') is-invalid @enderror'>{{ $item->deskripsi ?? old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('admin.barang.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Update Barang</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
