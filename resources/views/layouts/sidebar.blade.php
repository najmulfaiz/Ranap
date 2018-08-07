<div class="sidebar-content">
    <div class="sidebar-user">
        <div class="card-body">
            <div class="media">
                <div class="mr-3">
                    <a href="#"><img src="/assets/global/images/placeholders/placeholder.jpg" width="38" height="38" class="rounded-circle" alt=""></a>
                </div>
                
                <div class="media-body">
                    <div class="media-title font-weight-semibold">{{ Auth::user()->name }}</div>
                    <div class="font-size-xs opacity-50">
                        <i class="icon-tree7 font-size-sm"></i> Administrator
                    </div>
                </div>

                <div class="ml-3 align-self-center">
                    <a href="#" class="text-white"><i class="icon-cog3"></i></a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main navigation -->
    <div class="card card-sidebar-mobile">
        <ul class="nav nav-sidebar" data-nav-type="accordion">

            <!-- Main -->
            <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link">
                    <i class="icon-home4"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link"><i class="icon-database2"></i> <span>Master</span></a>

                <ul class="nav nav-group-sub" data-submenu-title="Master">
                    <li class="nav-item"><a href="{{ route('dokter.index') }}" class="nav-link">Dokter</a></li>
                    <li class="nav-item"><a href="{{ route('ruang.index') }}" class="nav-link">Ruang</a></li>
                    <li class="nav-item"><a href="{{ route('tarif.index') }}" class="nav-link">Tarif</a></li>
                    <li class="nav-item"><a href="{{ route('penjamin.index') }}" class="nav-link">Penjamin</a></li>
                </ul>
            </li>

            <li class="nav-item">
                <a href="{{ route('pendaftaran.index') }}" class="nav-link">
                    <i class="icon-magazine"></i>
                    <span>Pendaftaran</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('ranap.index') }}" class="nav-link">
                    <i class="icon-bed2"></i>
                    <span>Ruang Rawat Inap</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('laboratorium.index') }}" class="nav-link">
                    <i class="icon-eyedropper3"></i>
                    <span>Laboratorium</span>
                </a>
            </li>

            {{-- <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link"><i class="icon-magazine"></i> <span>Pendaftaran</span></a>

                <ul class="nav nav-group-sub" data-submenu-title="Pendaftaran">
                    <li class="nav-item"><a href="#" class="nav-link">Pendaftaran Baru</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">List Pasien</a></li>
                </ul>
            </li> --}}

            {{-- <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link"><i class="icon-bed2"></i> <span>Ruang Rawat Inap</span></a>

                <ul class="nav nav-group-sub" data-submenu-title="Ruang Rawat Inap">
                    <li class="nav-item"><a href="#" class="nav-link">List Pasien</a></li>
                </ul>
            </li> --}}

            {{-- <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link"><i class="icon-eyedropper3"></i> <span>Laboratorium</span></a>

                <ul class="nav nav-group-sub" data-submenu-title="Laboratorium">
                    <li class="nav-item"><a href="#" class="nav-link">List Pasien</a></li>
                </ul>
            </li> --}}

            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link"><i class="icon-cabinet"></i> <span>Apotek</span></a>

                <ul class="nav nav-group-sub" data-submenu-title="Apotek">
                    <li class="nav-item"><a href="#" class="nav-link">List Pasien</a></li>
                </ul>
            </li>

            <li class="nav-item nav-item-submenu">
                <a href="#" class="nav-link"><i class="icon-cash4"></i> <span>Pembayaran</span></a>

                <ul class="nav nav-group-sub" data-submenu-title="Pembayaran">
                    <li class="nav-item"><a href="#" class="nav-link">List Pasien</a></li>
                </ul>
            </li>

            <!-- <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="icon-stack"></i>
                    <span>Upload Dokumen</span>
                </a>
            </li> -->

        </ul>
    </div>
</div>