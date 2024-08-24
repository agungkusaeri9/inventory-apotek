@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Barang</h4>
                        @if (isAdmin())
                            <a href="{{ route('admin.barang.create') }}" class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                                Barang</a>
                        @endif
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Gambar</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Satuan</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Stok Minimal</th>
                                    @if (isAdmin())
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <img src="{{ $item->gambar() }}" class="img-fluid" alt="">
                                        </td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->jenis->nama }}</td>
                                        <td>{{ $item->satuan->nama }}</td>
                                        <td>{{ formatRupiah($item->harga) }}</td>
                                        <td>{{ $item->stok }}</td>
                                        <td>{{ $item->stok_minimal }}</td>
                                        @if (isAdmin())
                                            <td>
                                                <a href="{{ route('admin.barang.edit', $item->id) }}"
                                                    class="btn btn-sm py-2 btn-info">Edit</a>
                                                <form action="javascript:void(0)" method="post" class="d-inline"
                                                    id="formDelete">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btnDelete btn-sm py-2 btn-danger"
                                                        data-action="{{ route('admin.barang.destroy', $item->id) }}">Hapus</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
<x-Admin.Datatable />
