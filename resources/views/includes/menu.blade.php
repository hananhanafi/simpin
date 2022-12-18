<ul class="metismenu list-unstyled" id="side-menu">
    <li class="menu-title" data-key="t-menu">Menu</li>

    <li>
        <a href="{{ route('beranda') }}">
            <i data-feather="home"></i>
            <span data-key="t-dashboard">Beranda</span>
        </a>
    </li>


    <li class="menu-title mt-2" data-key="t-components">Master & Data</li>
    <li>
        <a href="javascript: void(0);" class="has-arrow">
            <i data-feather="grid"></i>
            <span data-key="t-apps">Master</span>
        </a>
        <ul class="sub-menu" aria-expanded="false">
            <li>
                <a href="{{ route('master.produk-kategori.index') }}">
                    <span data-key="t-calendar">Tipe Produk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('master.produk.index') }}">
                    <span data-key="t-calendar">Produk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('master.grade.index') }}">
                    <span data-key="t-calendar">Grade</span>
                </a>
            </li>
            <li>
                <a href="{{ route('master.departemen.index') }}">
                    <span data-key="t-calendar">Departemen</span>
                </a>
            </li>
            <li>
                <a href="{{ route('master.profit.index') }}">
                    <span data-key="t-calendar">Profit Center</span>
                </a>
            </li>
            <li>
                <a href="{{ route('master.sumber-dana.index') }}">
                    <span data-key="t-calendar">Sumber Dana</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="{{ request()->is('*data/anggota*') ? 'mm-active' : '' }}">
        <a href="javascript: void(0);" class="has-arrow {{ request()->is('*data/anggota*') ? 'mm-active' : '' }}">
            <i data-feather="users"></i>
            <span data-key="t-multi-level">Anggota</span>
        </a>
        <ul class="sub-menu {{ request()->is('*data/anggota*') ? 'mm-collapse mm-show' : '' }}" aria-expanded="true">
            <li {{ request()->is('*data/anggota*') ? 'mm-active' : '' }}>
                <a href="{{ route('data.anggota.index') }}" {{ request()->is('*data/anggota*') ? 'active' : '' }}>
                    <span data-key="t-calendar">Info</span>
                </a>
            </li>
            <li>
                <a href="{{ route('data.anggota.create') }}" {{ request()->is('*data/anggota/create') ? 'active' : '' }}>
                    <span data-key="t-calendar">Tambah Data Baru</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="{{ request()->is('*data/simpanan*') ? 'mm-active' : '' }}">
        <a href="javascript: void(0);" class="has-arrow {{ request()->is('*data/simpanan*') ? 'mm-active' : '' }}">
            <i data-feather="shopping-cart"></i>
            <span data-key="t-multi-level">Simpanan</span>
        </a>
        <ul class="sub-menu {{ request()->is('*data/simpanan*') ? 'mm-collapse mm-show' : '' }}" aria-expanded="true">
            <li class="{{ request()->is('*data/simpanan') ? 'mm-active' : '' }}">
                <a href="{{ route('data.simpanan.index') }}" {{ request()->is('*data/simpanan*') ? 'active' : '' }}>
                    <span data-key="t-calendar">Info</span>
                </a>
            </li>
            <li class="{{ request()->get('jenis') === 'simpas' ? 'mm-active' : '' }}">
                <a href="{{ route('data.simpanan.create') }}?jenis=simpas" {{ request()->get('jenis') == 'simpas' ? 'active' : '' }}>
                    <span data-key="t-calendar">Pembukaan SIMPAS</span>
                </a>
            </li>
            <li class="{{ request()->get('jenis') === 'ssb' ? 'mm-active' : '' }}">
                <a href="{{ route('data.simpanan.create') }}?jenis=ssb" {{ request()->is('*data/simpanan/create') ? 'active' : '' }}>
                    <span data-key="t-calendar">Pembukaan SSB</span>
                </a>
            </li>
            <li class="{{ request()->is('*data/simpanan') ? 'mm-active' : '' }}">
                <a href="{{ route('data.simpanan.index') }}" {{ request()->is('*data/simpanan*') ? 'active' : '' }}>
                    <span data-key="t-calendar">Pencairan</span>
                </a>
            </li>
            <li class="{{ request()->is('*data/simpanan/sertif') ? 'mm-active' : '' }}">
                <a href="{{ route('data.simpanan.sertif') }}" {{ request()->is('*data/simpanan/sertif*') ? 'active' : '' }}>
                    <span data-key="t-calendar">Sertifikat</span>
                </a>
            </li>
            {{-- <li>
                <a href="{{ route('data.simpanan.setor') }}" {{ request()->is('*data/simpanan/setor') ? 'active' : '' }}>
            <span data-key="t-calendar">Setor</span>
            </a>
    </li>
    <li>
        <a href="{{ route('data.simpanan.tarik') }}" {{ request()->is('*data/simpanan/tarik') ? 'active' : '' }}>
            <span data-key="t-calendar">Tarik</span>
        </a>
    </li> --}}
</ul>
</li>
<li class="{{ request()->is('*data/pinjaman*') ? 'mm-active' : '' }}">
    <a href="javascript: void(0);" class="has-arrow {{ request()->is('*data/pinjaman*') ? 'mm-active' : '' }}">
        <i data-feather="archive"></i>
        <span data-key="t-multi-level">Pinjaman</span>
    </a>
    <ul class="sub-menu {{ request()->is('*data/pinjaman*') ? 'mm-collapse mm-show' : '' }}" aria-expanded="true">
        <li {{ request()->is('*data/pinjaman*') ? 'mm-active' : '' }}>
            <a href="{{ route('data.pinjaman.index') }}" {{ request()->is('*data/pinjaman*') ? 'active' : '' }}>
                <span data-key="t-calendar">Info</span>
            </a>
        </li>
        <!-- <li {{ request()->is('*data/pinjaman*') ? 'mm-active' : '' }}>
            <a href="{{ route('data.pinjaman.simulasi') }}" {{ request()->is('*data/pinjaman/simulasi*') ? 'active' : '' }}>
                <span data-key="t-calendar">Simulasi</span>
            </a>
        </li> -->
        <!-- <li {{ request()->is('*data/pinjaman.plafon*') ? 'mm-active' : '' }}>
            <a href="{{ route('data.pinjaman.plafon') }}" {{ request()->is('*data/pinjaman.plafon*') ? 'active' : '' }}>
                <span data-key="t-calendar">Plafon</span>
            </a>
        </li> -->
        <li {{ request()->is('*data/pinjaman/create*') ? 'mm-active' : '' }}>
            <a href="{{ route('data.pinjaman.create') }}" {{ request()->is('*data/pinjaman/create*') ? 'active' : '' }}>
                <span data-key="t-calendar">Pengajuan</span>
            </a>
        </li>
        <li {{ request()->is('*data/pinjaman/pencairan*') ? 'mm-active' : '' }}>
            <a href="{{ route('data.pinjaman.pencairan') }}" {{ request()->is('*data/pinjaman/pencairan*') ? 'active' : '' }}>
                <span data-key="t-calendar">Pencairan</span>
            </a>
        </li>
        <li {{ request()->is('*data/pinjaman/pelunasan*') ? 'mm-active' : '' }}>
            <a href="{{ route('data.pinjaman.pelunasan') }}" {{ request()->is('*data/pinjaman/pelunasan*') ? 'active' : '' }}>
                <span data-key="t-calendar">Pelunasan</span>
            </a>
        </li>
    </ul>
</li>
<li class="{{ request()->is('*data/hrd*') ? 'mm-active' : '' }}">
    <a href="javascript: void(0);" class="has-arrow {{ request()->is('*data/hrd*') ? 'mm-active' : '' }}">
        <i data-feather="credit-card"></i>
        <span data-key="t-multi-level">Potongan HRD</span>
    </a>
    <ul class="sub-menu {{ request()->is('*data/hrd*') ? 'mm-collapse mm-show' : '' }}" aria-expanded="true">
        <li {{ request()->is('*data/hrd/imporHRD*') ? 'mm-active' : '' }}>
            <a href="{{ route('data.hrd.imporHRD') }}" {{ request()->is('*data/hrd/imporHRD*') ? 'active' : '' }}>
                <span data-key="t-calendar">Info</span>
            </a>
        </li>
    </ul>
</li>
<li class="{{ request()->is('*data/shu*') ? 'mm-active' : '' }}">
    <a href="javascript: void(0);" class="has-arrow {{ request()->is('*data/shu*') ? 'mm-active' : '' }}">
        <i data-feather="credit-card"></i>
        <span data-key="t-multi-level">SHU</span>
    </a>
    <ul class="sub-menu {{ request()->is('*data/shu*') ? 'mm-collapse mm-show' : '' }}" aria-expanded="true">
        <li {{ request()->is('*data/shu*') ? 'mm-active' : '' }}>
            <a href="{{ route('data.shu.index') }}" {{ request()->is('*data/shu*') ? 'active' : '' }}>
                <span data-key="t-calendar">Info</span>
            </a>
        </li>
        <li {{ request()->is('*data/shu*') ? 'mm-active' : '' }}>
            <a href="{{ route('data.shu.create') }}" {{ request()->is('*data/shu*') ? 'active' : '' }}>
                <span data-key="t-calendar">Perhitungan</span>
            </a>
        </li>
        <li {{ request()->is('*data/shu*') ? 'mm-active' : '' }}>
            <a href="{{ route('data.shu.rincian-anggota') }}" {{ request()->is('*data/shu*') ? 'active' : '' }}>
                <span data-key="t-calendar">Rincian Anggota</span>
            </a>
        </li>
    </ul>
</li>
<li class="{{ request()->is('*approval*') ? 'mm-active' : '' }}">
    <a href="javascript: void(0);" class="has-arrow {{ request()->is('*approval*') ? 'mm-active' : '' }}">
        <i data-feather="check-circle"></i>
        <span data-key="t-multi-level">Approval</span>
    </a>
    <ul class="sub-menu {{ request()->is('*approval*') ? 'mm-collapse mm-show' : '' }}" aria-expanded="true">
        <li {{ request()->is('*approval.produk*') ? 'mm-active' : '' }}>
            <a href="{{ route('approval.produk') }}" {{ request()->is('*approval/produk*') ? 'active' : '' }}>
                <span data-key="t-calendar">Produk</span>
            </a>
        </li>
        <li {{ request()->is('*approval.anggota*') ? 'mm-active' : '' }}>
            <a href="{{ route('approval.anggota') }}" {{ request()->is('*approval/anggota*') ? 'active' : '' }}>
                <span data-key="t-calendar">Anggota</span>
            </a>
        </li>
        <li {{ request()->is('*approval.simpanan*') ? 'mm-active' : '' }}>
            <a href="{{ route('approval.simpanan') }}" {{ request()->is('*approval/simpanan*') ? 'active' : '' }}>
                <span data-key="t-calendar">Simpanan</span>
            </a>
        </li>
        <li {{ request()->is('*approval.pinjaman*') ? 'mm-active' : '' }}>
            <a href="{{ route('approval.pinjaman') }}" {{ request()->is('*approval/pinjaman*') ? 'active' : '' }}>
                <span data-key="t-calendar">Pinjaman</span>
            </a>
        </li>
        <li {{ request()->is('*approval.shu*') ? 'mm-active' : '' }}>
            <a href="{{ route('approval.shu') }}" {{ request()->is('*approval/shu*') ? 'active' : '' }}>
                <span data-key="t-calendar">SHU</span>
            </a>
        </li>
    </ul>
</li>
<li class="{{ request()->is('*tutup-buku*') ? 'mm-active' : '' }}">
    <a href="javascript: void(0);" class="has-arrow {{ request()->is('*tutup-buku*') ? 'mm-active' : '' }}">
        <i data-feather="lock"></i>
        <span data-key="t-multi-level">Tutup Buku</span>
    </a>
    <ul class="sub-menu {{ request()->is('*tutup-buku*') ? 'mm-collapse mm-show' : '' }}" aria-expanded="true">
        <li {{ request()->is('*tutup-buku*') ? 'mm-active' : '' }}>
            <a href="#" {{ request()->is('*tutup-buku*') ? 'active' : '' }}>
                <span data-key="t-calendar">Harian</span>
            </a>
        </li>
        <li {{ request()->is('*tutup-buku*') ? 'mm-active' : '' }}>
            <a href="#" {{ request()->is('*tutup-buku*') ? 'active' : '' }}>
                <span data-key="t-calendar">Bulanan</span>
            </a>
        </li>
        <li {{ request()->is('*tutup-buku*') ? 'mm-active' : '' }}>
            <a href="#" {{ request()->is('*tutup-buku*') ? 'active' : '' }}>
                <span data-key="t-calendar">Tahunan</span>
            </a>
        </li>
    </ul>
</li>
<li class="{{ request()->is('*laporan*') ? 'mm-active' : '' }}">
    <a href="javascript: void(0);" class="has-arrow {{ request()->is('*laporan*') ? 'mm-active' : '' }}">
        <i data-feather="book-open"></i>
        <span data-key="t-multi-level">Laporan</span>
    </a>
    <ul class="sub-menu {{ request()->is('*laporan*') ? 'mm-collapse mm-show' : '' }}" aria-expanded="true">
        <li {{ request()->is('*laporan*') ? 'mm-active' : '' }}>
            <a href="{{ route('laporan.anggota') }}" {{ request()->is('*laporan/anggota*') ? 'active' : '' }}>
                <span data-key="t-calendar">Lap. Anggota</span>
            </a>
        </li>
        <li {{ request()->is('*laporan*') ? 'mm-active' : '' }}>
            <a href="{{ route('laporan.simpanan') }}" {{ request()->is('*laporan/simpanan*') ? 'active' : '' }}>
                <span data-key="t-calendar">Lap. Simpanan</span>
            </a>
        </li>
        <li {{ request()->is('*laporan*') ? 'mm-active' : '' }}>
            <a href="{{ route('laporan.simp-ssb') }}" {{ request()->is('*laporan/simp-ssb*') ? 'active' : '' }}>
                <span data-key="t-calendar">Lap. Simpanan SSB</span>
            </a>
        </li>
        <li {{ request()->is('*laporan*') ? 'mm-active' : '' }}>
            <a href="{{ route('laporan.simpas') }}" {{ request()->is('*laporan/simpas*') ? 'active' : '' }}>
                <span data-key="t-calendar">Lap. Simpanan Pasti</span>
            </a>
        </li>
        {{-- <li {{ request()->is('*laporan*') ? 'mm-active' : '' }}>
        <a href="{{ route('laporan.penutupan') }}" {{ request()->is('*laporan/penutupan*') ? 'active' : '' }}>
            <span data-key="t-calendar">Lap. Penutupan</span>
        </a>
</li> --}}

{{-- <li {{ request()->is('*laporan*') ? 'mm-active' : '' }}>
<a href="#" {{ request()->is('*laporan*') ? 'active' : '' }}>
    <span data-key="t-calendar">Lap. Simpanan </span>
</a>
</li> --}}


<li {{ request()->is('*laporan*') ? 'mm-active' : '' }}>
    <a href="#" {{ request()->is('*laporan*') ? 'active' : '' }}>
        <span data-key="t-calendar">Lap. Pembiayaan</span>
    </a>
</li>
<li {{ request()->is('*laporan*') ? 'mm-active' : '' }}>
    <a href="#" {{ request()->is('*laporan*') ? 'active' : '' }}>
        <span data-key="t-calendar">Lap. Asuransi</span>
    </a>
</li>
<li {{ request()->is('*laporan*') ? 'mm-active' : '' }}>
    <a href="#" {{ request()->is('*laporan*') ? 'active' : '' }}>
        <span data-key="t-calendar">Lap. Asuransi Per Produk</span>
    </a>
</li>
<li {{ request()->is('*laporan*') ? 'mm-active' : '' }}>
    <a href="#" {{ request()->is('*laporan*') ? 'active' : '' }}>
        <span data-key="t-calendar">Lap. Transaksi</span>
    </a>
</li>
</ul>
</li>
<li class="menu-title mt-2" data-key="t-components">Setting</li>
<li class="{{ request()->is('*data/pengguna*') ? 'mm-active' : '' }}">
    <a href="javascript: void(0);" class="has-arrow {{ request()->is('*data/pengguna*') ? 'mm-active' : '' }}">
        <i data-feather="users"></i>
        <span data-key="t-multi-level">Pengaturan User</span>
    </a>
    <ul class="sub-menu {{ request()->is('*data/pengguna*') ? 'mm-collapse mm-show' : '' }}" aria-expanded="true">
        <li {{ request()->is('*data/pengguna/*') ? 'mm-active' : '' }}>
            <a href="{{ route('data.pengguna.edit', Auth::user()->id) }}" data-key="t-level-1-1">Profil
                Pengguna</a>
        </li>
        <li {{ request()->is('*data/pengguna/*') ? 'mm-active' : '' }}>
            <a href="{{ route('data.pengguna.index') }}" data-key="t-level-1-1">Manajemen Pengguna</a>
        </li>
    </ul>
</li>
<li>
    <a href="{{ url('setting') }}">
        <i data-feather="home"></i>
        <span data-key="t-dashboard">Welcome Page</span>
    </a>
</li>

</ul>