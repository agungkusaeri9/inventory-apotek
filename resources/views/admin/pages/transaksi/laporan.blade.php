@extends('admin.layouts.app')
@section('content')
    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="mb-4">Laporan Transaksi</h5>
                    <form action="{{ route('admin.transaksi.print') }}" method="post">
                        @csrf
                        <div class='form-group mb-3 row'>
                            <div class="col-md-3">
                                <div class='form-group mb-3'>
                                    <label for='dari' class='mb-2'>Dari</label>
                                    <input type='date' name='dari'
                                        class='form-control @error('dari') is-invalid @enderror'
                                        value='{{ request('dari') ?? old('dari') }}'>
                                    @error('dari')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class='form-group mb-3'>
                                    <label for='sampai' class='mb-2'>Sampai</label>
                                    <input type='date' name='sampai'
                                        class='form-control @error('sampai') is-invalid @enderror'
                                        value='{{ request('sampai') ?? old('sampai') }}'>
                                    @error('sampai')
                                        <div class='invalid-feedback'>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md align-self-center mt-2">
                                <button class="btn btn-secondary text-white">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
