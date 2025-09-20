<?php
namespace App\Services;

use App\Models\Inventory;
use App\Models\ItemTransaksi;
use App\Models\Meja;
use App\Models\Reservasi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class DashboardService
 * @package App\Services
 */
class DashboardService
{
    /**
     * Mengumpulkan semua data yang diperlukan untuk halaman dashboard.
     *
     * @return array
     */
    public function getDashboardData(): array
    {
        return [
            'kpi'                 => $this->getKpiStats(),
            'penjualanPerJam'     => $this->getPenjualanPerJam(),
            'tipePesanan'         => $this->getTipePesanan(),
            'stokKritis'          => $this->getStokKritis(),
            'pesananTerbaru'      => $this->getPesananTerbaru(),
            'menuTerlarisBulanan' => $this->getMenuTerlarisBulanan(),
            'statistikMeja'       => $this->getStatistikMeja(),    // <-- DATA BARU
            'reservasiHariIni'    => $this->getReservasiHariIni(), // <-- DATA BARU
        ];
    }

    /**
     * Menghitung statistik KPI dengan perbandingan hari sebelumnya.
     */
    private function getKpiStats(): array
    {
        $today     = Carbon::today();
        $yesterday = Carbon::yesterday();

        $transaksiHariIni = Transaksi::whereDate('created_at', $today)
            ->whereIn('status', ['paid', 'lunas', 'selesai']);

        $transaksiKemarin = Transaksi::whereDate('created_at', $yesterday)
            ->whereIn('status', ['paid', 'lunas', 'selesai']);

        $pendapatanHariIni      = (float) $transaksiHariIni->sum('total_harga');
        $jumlahTransaksiHariIni = $transaksiHariIni->count();
        $pendapatanKemarin      = (float) $transaksiKemarin->sum('total_harga');

        $rataRata = $jumlahTransaksiHariIni > 0 ? $pendapatanHariIni / $jumlahTransaksiHariIni : 0;

        $perubahanPendapatan = $pendapatanKemarin > 0
            ? (($pendapatanHariIni - $pendapatanKemarin) / $pendapatanKemarin) * 100
            : ($pendapatanHariIni > 0 ? 100 : 0);

        $menuTerlaris = ItemTransaksi::whereHas('transaksi', function ($query) use ($today) {
            $query->whereDate('created_at', $today)->whereIn('status', ['paid', 'lunas', 'selesai']);
        })
            ->select('kode_menu', DB::raw('SUM(jumlah) as total_terjual'))
            ->groupBy('kode_menu')
            ->orderByDesc('total_terjual')
            ->with('menu:kode_menu,nama')
            ->first();

        return [
            'pendapatanHariIni'   => $pendapatanHariIni,
            'transaksiHariIni'    => $jumlahTransaksiHariIni,
            'rataRataTransaksi'   => $rataRata,
            'perubahanPendapatan' => round($perubahanPendapatan, 2),
            'menuTerlarisHariIni' => $menuTerlaris ?
            ['nama' => $menuTerlaris->menu->nama, 'terjual' => (int) $menuTerlaris->total_terjual] :
            ['nama' => 'N/A', 'terjual' => 0],
        ];
    }

    /**
     * Mengambil statistik penggunaan meja.
     */
    private function getStatistikMeja(): array
    {
        $mejas = Meja::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        return [
            'total'     => $mejas->sum(),
            'kosong'    => $mejas->get('kosong', 0),
            'digunakan' => $mejas->get('digunakan', 0),
            'dipesan'   => $mejas->get('dipesan', 0),
        ];
    }

    /**
     * Mengambil reservasi untuk hari ini.
     */
    private function getReservasiHariIni(int $limit = 5): array
    {
        return Reservasi::with('user:id,name')
            ->whereDate('tanggal_reservasi', Carbon::today())
            ->orderBy('jam_reservasi', 'asc')
            ->limit($limit)
            ->get()
            ->map(fn($reservasi) => [
                'pelanggan' => $reservasi->user->name,
                'jam'       => Carbon::parse($reservasi->jam_reservasi)->format('H:i'),
                'meja'      => $reservasi->nomor_meja,
            ])
            ->all();
    }

    /**
     * Mengambil data penjualan per jam untuk hari ini.
     */
    private function getPenjualanPerJam(): array
    {
        $sales = Transaksi::whereDate('created_at', Carbon::today())
            ->whereIn('status', ['paid', 'lunas', 'selesai'])
            ->select(DB::raw('HOUR(created_at) as jam'), DB::raw('SUM(total_harga) as total'))
            ->groupBy('jam')
            ->orderBy('jam')
            ->pluck('total', 'jam')
            ->all();

        // Siapkan rentang jam operasional (misal: 08:00 - 22:00)
        $labels = range(8, 22);
        $data   = [];
        foreach ($labels as $hour) {
            $data[] = $sales[$hour] ?? 0;
        }

        return [
            'labels' => array_map(fn($h) => str_pad($h, 2, '0', STR_PAD_LEFT), $labels),
            'data'   => $data,
        ];
    }

    /**
     * Mengelompokkan transaksi berdasarkan tipe pembayaran (misal: Tunai vs Online).
     */
    private function getTipePesanan(): array
    {
        $types = Transaksi::whereMonth('created_at', Carbon::now()->month)
            ->whereIn('status', ['paid', 'lunas', 'selesai'])
            ->select('jenis_pembayaran', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_pembayaran')
            ->pluck('total', 'jenis_pembayaran')
            ->mapWithKeys(function ($total, $jenis) {
                $label = strtolower($jenis) === 'tunai' ? 'Tunai (Kasir)' : 'Online';
                return [$label => $total];
            })->all();

        return [
            'labels' => array_keys($types),
            'data'   => array_values($types),
        ];
    }

    /**
     * Mengambil daftar bahan yang stoknya menipis.
     */
    private function getStokKritis(int $limit = 5, int $threshold = 10): array
    {
        return Inventory::where('stok', '<=', $threshold)
            ->orderBy('stok', 'asc')
            ->limit($limit)
            ->get(['nama_bahan', 'stok', 'satuan'])
            ->map(fn($item) => [
                'nama' => $item->nama_bahan,
                'sisa' => $item->stok,
                'unit' => $item->satuan,
            ])->all();
    }

    /**
     * Mengambil 5 transaksi terakhir.
     */
    private function getPesananTerbaru(int $limit = 5): array
    {
        return Transaksi::with(['pengguna:id,name', 'items.menu:kode_menu,nama'])
            ->whereIn('status', ['paid', 'lunas', 'selesai'])
            ->latest()
            ->limit($limit)
            ->get()
            ->map(fn($transaksi) => [
                'id'        => $transaksi->kode_transaksi,
                'pelanggan' => $transaksi->pengguna->name ?? 'N/A',
                'total'     => $transaksi->total_harga,
                'waktu'     => $transaksi->created_at->diffForHumans(),
                'items'     => $transaksi->items->pluck('menu.nama')->all(),
            ])->all();
    }

    /**
     * Mengambil daftar menu terlaris bulan ini.
     */
    private function getMenuTerlarisBulanan(int $limit = 5): array
    {
        return ItemTransaksi::whereHas('transaksi', function ($query) {
            $query->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year)
                ->whereIn('status', ['paid', 'lunas', 'selesai']);
        })
            ->select('kode_menu', DB::raw('SUM(jumlah) as total_terjual'))
            ->groupBy('kode_menu')
            ->orderByDesc('total_terjual')
            ->with('menu:kode_menu,nama')
            ->limit($limit)
            ->get()
            ->map(fn($item) => [
                'nama'    => $item->menu->nama,
                'terjual' => (int) $item->total_terjual,
            ])->all();
    }
}