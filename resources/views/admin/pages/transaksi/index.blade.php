@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h4 class="card-title mb-3">Transaksi</h4>
                        <a href="{{ route('admin.transaksi.create') }}" class="btn my-2 mb-3 btn-sm py-2 btn-primary">Tambah
                            Transaksi</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table dtTable table-hover" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Invoice</th>
                                    <th>Sub Total</th>
                                    <th>Diskon</th>
                                    <th>Total</th>
                                    <th>Tunai</th>
                                    <th>Kembalian</th>
                                    <th>Created</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($items as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->invoice }}</td>
                                        <td>Rp {{ number_format($item->sub_total, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->diskon, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->tunai, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($item->kembalian, 0, ',', '.') }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>
                                            <a href="{{ route('admin.transaksi.show', $item->invoice) }}"
                                                class="btn btn-sm py-2 btn-warning">Detail</a>
                                        </td>
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
