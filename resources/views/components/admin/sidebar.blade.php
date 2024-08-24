<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('admin.dashboard') }}">
                <i class="mdi mdi-view-dashboard pr-2 icon-large"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('admin.barang.index') }}">
                <i class="mdi mdi-package pr-2 icon-large"></i>
                <span class="menu-title">Barang</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('admin.barang-masuk.index') }}">
                <i class="mdi mdi-arrow-down pr-2 icon-large"></i>
                <span class="menu-title">Barang Masuk</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('admin.barang-keluar.index') }}">
                <i class="mdi mdi-arrow-up pr-2 icon-large"></i>
                <span class="menu-title">Barang Keluar</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link py-2" href="{{ route('admin.transaksi.index') }}">
                <i class="mdi mdi-cart pr-2 icon-large"></i>
                <span class="menu-title">Transaksi</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#laporan" aria-expanded="false" aria-controls="laporan">
                <i class="mdi mdi-file-document pr-2 icon-large"></i>
                <span class="menu-title">Laporan</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="laporan">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.transaksi.laporan') }}"> Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.barang-masuk.laporan') }}"> Barang Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.barang-keluar.laporan') }}"> Barang Keluar</a>
                    </li>
                </ul>
            </div>
        </li>
        @if (isAdmin())
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#master_data" aria-expanded="false"
                    aria-controls="master_data">
                    <i class="mdi mdi-database pr-2 icon-large"></i>
                    <span class="menu-title">Master Data</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="master_data">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.users.index') }}"> User</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.jenis.index') }}"> Jenis Barang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin.satuan.index') }}"> Satuan Barang </a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif
    </ul>
</nav>
