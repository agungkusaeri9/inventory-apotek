@extends('admin.layouts.app')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <form action="javascript:void(0)" method="post">
                <div class="card">
                    <div class="card-body">
                        @csrf
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="form-group row">
                                                <label for="tanggal"
                                                    class="col-sm-4 col-form-label font-weight-bold">Tanggal</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="tanggal"
                                                        placeholder="col-form-label"
                                                        value="<?= Carbon\Carbon::now()->translatedFormat('d/m/Y H:i:s') ?>"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="kasir"
                                                    class="col-sm-4 col-form-label font-weight-bold">Kasir</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control" id="kasir"
                                                        placeholder="col-form-label" value="<?= auth()->user()->name ?>"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <div class="form-group row">
                                                <label for="jumlah"
                                                    class="col-sm-3 col-form-label font-weight-bold">Barang</label>
                                                <div class="col-sm-9">
                                                    <select name='barang_id' id='barang_id'
                                                        class='form-control @error('barang_id') is-invalid @enderror'>
                                                        <option value='' selected disabled>Pilih Barang</option>
                                                        @foreach ($data_barang as $barang)
                                                            <option value='{{ $barang->id }}'>
                                                                {{ $barang->nama }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('barang_id')
                                                        <div class='invalid-feedback'>
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="jumlah"
                                                    class="col-sm-3 col-form-label font-weight-bold">Jumlah</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" id="jumlah"
                                                        placeholder="Jumlah" value="1">
                                                </div>
                                            </div>
                                            <div class="form-group mt-2 float-right">
                                                <button class="btn btn-primary px-5 btnTambah">Tambah</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="card">
                                    <div class="card-body">
                                        <h3 class="text-right mb-3"><?= $kode_baru ?? 'INV001' ?></h3>
                                        <div class="display-4 text-right mt-5 displayTotalHarga">
                                            0
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2 ">
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table list_barang">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Nama Produk</th>
                                                    <th>Harga</th>
                                                    <th>Jumlah</th>
                                                    <th>Total Harga</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="sub_total" class="col-sm-4 col-form-label font-weight-bold">Sub
                                                Total</label>
                                            <div class="col-sm-8">
                                                <input type="number" class="form-control" id="sub_total" value=""
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="diskon"
                                                class="col-sm-4 col-form-label font-weight-bold">Diskon</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="diskon" value="0">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="total"
                                                class="col-sm-4 col-form-label font-weight-bold">Total</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="total" value=""
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="tunai"
                                                class="col-sm-4 col-form-label font-weight-bold">Tunai</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="tunai" value="">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="kembalian"
                                                class="col-sm-4 col-form-label font-weight-bold">Kembalian</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control" id="kembalian" value=""
                                                    readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="card">
                                    <div class="card-body">
                                        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-lg btn-danger">
                                            Batal
                                        </a>
                                        <br>
                                        <br>
                                        <br>
                                        <button class="btn btn-lg btn-success btnSimpanTransaksi">Simpan Transaksi</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
<x-Admin.Sweetalert />
@push('styles')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(function() {
            let table = $('.list_barang').DataTable({
                columnDefs: [{
                    targets: -1,
                    data: null,
                    defaultContent: "<button class='btn btn-sm btn-danger hapusButton'>Hapus</button>",
                }],
            });

            $('.btnTambah').on('click', function() {
                let id = $("#barang_id").val();
                let jumlah = $('#jumlah').val();
                console.log(id);
                $.ajax({
                    url: "{{ route('admin.barang.getByIdJson') }}",
                    type: 'GET',
                    data: {
                        barang_id: id
                    },
                    dataType: 'JSON',
                    success: function(res) {
                        let data = res.data;
                        let dataArray = [];
                        dataArray.push({
                            barang_id: data.id,
                            nama: data.nama,
                            harga: data.harga,
                            jumlah: jumlah,
                            total_harga: (jumlah * data.harga)
                        });
                        tambahDataKeLocalStorage(dataArray);

                        tampilkanData('list_barang');
                    },
                    error: function(errors) {
                        console.error("AJAX request failed:");
                    }
                })
            })

            function formatAngka(angka) {
                if (typeof angka === 'string') {
                    return parseInt(angka.replace(/[^0-9]/g, ''), 10);
                }
                return angka;
            }

            function formatRupiah(inputAngka) {
                return 'Rp ' + inputAngka.toLocaleString('id-ID');
                // return inputAngka;
            }


            function hitungTotal() {
                let table = $('.list_barang').DataTable();
                let totalKeseluruhan = 0;

                // Mengakses data dalam DataTable
                table.rows().every(function() {
                    let data = this.data();
                    let harga = formatAngka(data[2]); // Mengambil harga dari kolom yang sesuai
                    let jumlah = parseInt(data[3]);
                    let total = harga * jumlah;

                    // Menyimpan total pada kolom yang sesuai
                    table.cell(this, 4).data(formatRupiah(total));

                    totalKeseluruhan += total;
                });

                // Mengatur total keseluruhan pada elemen dengan ID 'totalKeseluruhan'
                $('.displayTotalHarga').text(formatRupiah(totalKeseluruhan));
                $('#sub_total').val(totalKeseluruhan);
                $('#total').val(totalKeseluruhan);
            }

            function tambahDataKeLocalStorage(data) {
                // Mendapatkan data yang sudah ada di localStorage
                var existingData = JSON.parse(localStorage.getItem('list_barang')) || [];
                // Menambahkan data baru ke array existingData
                existingData.push(data);
                // Menyimpan data ke localStorage
                localStorage.setItem('list_barang', JSON.stringify(existingData));
            }

            function tambahDataKeTabel(data) {
                var table = $('.list_barang').DataTable();
                table.row.add([
                    table.rows().count() + 1,
                    data[0].nama,
                    formatRupiah(data[0].harga),
                    data[0].jumlah,
                    formatRupiah(data[0].total_harga)
                ]).draw();

                hitungTotal();
            }


            function tampilkanData(key) {
                try {
                    let storedData = localStorage.getItem(key);

                    if (storedData) {
                        let retrievedData = JSON.parse(storedData);
                        // Inisialisasi DataTable
                        table.clear();

                        if (retrievedData.length > 0) {
                            // Jika ada data, tambahkan data ke DataTable
                            retrievedData.forEach(function(data) {
                                let data2 = data[0];
                                tambahDataKeTabel(data);
                            });
                        }

                        // hitungTotal();

                    } else {
                        // Jika tidak ada data yang disimpan di localStorage, tambahkan baris kosong ke DataTable
                        console.log("Tidak ada data yang disimpan di localStorage.");
                    }
                } catch (error) {
                    console.error("Terjadi kesalahan:", error);
                }
            }

            function hapusData(data, key) {
                try {
                    let storedData = localStorage.getItem(key);

                    if (storedData) {
                        let retrievedData = JSON.parse(storedData);
                        console.log(retrievedData);

                        // Cari indeks data berdasarkan data yang diklik
                        let index = retrievedData.findIndex(function(d, i) {
                            i = i + 1;
                            return i === data[0];
                        });
                        if (index >= 0) {
                            // Hapus data dari array
                            retrievedData.splice(index, 1);
                            localStorage.setItem(key, JSON.stringify(retrievedData));
                            table.clear().draw();
                            hitungTotal();
                        } else {
                            console.log("Data tidak ditemukan.");
                        }

                        // Tampilkan data terbaru
                        tampilkanData(key);
                    } else {
                        console.log("Tidak ada data yang disimpan di localStorage.");
                    }
                } catch (error) {
                    console.error("Terjadi kesalahan:", error);
                }
            }



            $('.list_barang tbody').on('click', 'button.hapusButton', function() {
                let data = $('.list_barang').DataTable().row($(this).parents('tr')).data();
                hapusData(data, "list_barang");
            });

            // diskon
            $('#diskon').on('input', function() {
                let sub_total = $('#sub_total').val();
                let diskon = $(this).val();
                let total = sub_total - diskon;
                $('#total').val(total);
            })

            // tunai dan kembalian
            $('#tunai').on('input', function() {
                let tunai = $(this).val();
                let total = $('#total').val();
                let kembalian = tunai - total;
                $('#kembalian').val(kembalian);
            })

            // tombol simpan transaksi
            $('.btnSimpanTransaksi').on('click', function() {
                let storedData = localStorage.getItem('list_barang');
                let data = JSON.parse(storedData);
                let sub_total = $("#sub_total").val();
                let total = $("#total").val();
                let tunai = $('#tunai').val();
                let kembalian = $('#kembalian').val();
                // let id_customer = $('#id_customer').val();
                let diskon = $('#diskon').val();


                $.ajax({
                    url: '{{ route('admin.transaksi.store') }}',
                    type: 'POST',
                    dataType: 'JSON',
                    data: {
                        data: data,
                        sub_total,
                        total,
                        tunai,
                        kembalian,
                        // id_customer,
                        diskon
                    },
                    success: function(response) {
                        if (response.status) {
                            localStorage.removeItem('list_barang');
                            Swal.fire({
                                title: "Berhasil!",
                                text: response.message,
                                icon: "success",
                                button: "OK",
                            }).then((willReload) => {
                                if (willReload) {
                                    window.location.href =
                                        '{{ route('admin.transaksi.index') }}';
                                }
                            });
                        } else {
                            Swal.fire({
                                title: "Error!",
                                text: response.message,
                                icon: "error",
                                button: "OK",
                            });
                        }
                    },
                    error: function(err) {
                        console.log(err);
                    }
                })
            })

            tampilkanData('list_barang');
            hitungTotal();
        })
    </script>
@endpush
