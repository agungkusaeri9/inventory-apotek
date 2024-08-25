@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-4 grid-margin transparent">
            <div class="row">
                <div class="col-md-12 mb-4 stretch-card transparent">
                    <div class="card card-tale bg-success">
                        <div class="card-body">
                            <p class="mb-4">Transaksi Hari Ini</p>
                            <p class="fs-30 mb-2">{{ formatRupiah($count['transaksi_hari_ini']) }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin transparent">
            <div class="row">
                <div class="col-md-12 mb-4 stretch-card transparent">
                    <div class="card card-tale bg-primary">
                        <div class="card-body">
                            <p class="mb-4">Barang Masuk</p>
                            <p class="fs-30 mb-2">{{ $count['barang_masuk'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 grid-margin transparent">
            <div class="row">
                <div class="col-md-12 mb-4 stretch-card transparent">
                    <div class="card card-tale bg-secondary">
                        <div class="card-body">
                            <p class="mb-4">Barang Keluar</p>
                            <p class="fs-30 mb-2">{{ $count['barang_keluar'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
