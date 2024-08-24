@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-5">Tambah Barang Keluar</h4>
                    <form action="{{ route('admin.barang-keluar.store') }}" method="post">
                        @csrf
                        <div class='form-group mb-3'>
                            <label for='barang_id' class='mb-2'>Barang</label>
                            <select name="barang_id" id="barang_id"
                                class="form-control @error('barang_id') is-invalid @enderror">
                                <option value="" selected disabled>Pilih Barang</option>
                                @foreach ($data_barang as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->nama }}</option>
                                @endforeach
                            </select>
                            @error('barang_id')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='kode' class='mb-2'>Kode</label>
                            <input type='text' name='kode' class='form-control @error('kode') is-invalid @enderror'
                                value='{{ old('kode') }}' readonly>
                            @error('kode')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='jenis' class='mb-2'>Jenis</label>
                            <input type='text' name='jenis' class='form-control @error('jenis') is-invalid @enderror'
                                value='{{ old('jenis') }}' readonly>
                            @error('jenis')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='satuan' class='mb-2'>Satuan</label>
                            <input type='text' name='satuan' class='form-control @error('satuan') is-invalid @enderror'
                                value='{{ old('satuan') }}' readonly>
                            @error('satuan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='stok' class='mb-2'>Stok</label>
                            <input type='text' name='stok' class='form-control @error('stok') is-invalid @enderror'
                                value='{{ old('stok') }}' readonly>
                            @error('stok')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='jumlah' class='mb-2'>Jumlah</label>
                            <input type='number' name='jumlah' class='form-control @error('jumlah') is-invalid @enderror'
                                value='{{ old('jumlah') }}'>
                            @error('jumlah')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class='form-group mb-3'>
                            <label for='keterangan' class='mb-2'>Keterangan</label>
                            <textarea name='keterangan' id='keterangan' cols='30' rows='3'
                                class='form-control @error('keterangan') is-invalid @enderror'>{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class='invalid-feedback'>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group text-right">
                            <a href="{{ route('admin.barang-keluar.index') }}" class="btn btn-warning">Batal</a>
                            <button class="btn btn-primary">Tambah Barang Keluar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('assets/vendors/select2/select2.min.js') }}"></script>
    <script>
        $(function() {

            $('#barang_id').select2({
                theme: 'bootstrap'
            })

            $('#barang_id').on('change', function() {
                let barang_id = $(this).val();

                $.ajax({
                    url: '{{ route('admin.barang.getByIdJson') }}',
                    data: {
                        barang_id
                    },
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.status) {
                            $('input[name=satuan]').val(data.data.satuan.nama);
                            $('input[name=jenis]').val(data.data.jenis.nama);
                            $('input[name=stok]').val(data.data.stok);
                            $('input[name=kode]').val(data.data.kode);
                        }
                    }
                })
            })
        })
    </script>
@endpush
