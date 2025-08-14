<?php
namespace App\Http\Controllers;

use App\Http\Services\ReservasiService;
use App\Models\Reservasi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class ReservasiController extends Controller
{
    protected $reservasiService;

    /**
     * Constructor untuk inject ReservasiService.
     *
     * @param ReservasiService $reservasiService
     */
    public function __construct(ReservasiService $reservasiService)
    {
        $this->reservasiService = $reservasiService;
    }

    public function index()
    {
        $mejas = $this->reservasiService->getAllMeja();
        return Inertia::render('Users/Reservasi', [
            'mejas' => $mejas,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelanggan'    => 'required|string|max:255',
            'no_telepon'        => 'required|string|max:15',
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'jam_reservasi'     => 'required|date_format:H:i',
            'nomor_meja'        => 'required|string|exists:meja,nomor_meja',
            'catatan'           => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            $reservasi = $this->reservasiService->createUserReservation($validator->validated());
            return redirect()
                ->route('reservasi.detail', ['kode_reservasi' => $reservasi->kode_reservasi])
                ->with('success', 'Reservasi Anda berhasil dibuat!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat reservasi.')->withInput();
        }
    }

    public function detail($kode_reservasi)
    {
        $reservasi = $this->reservasiService->getReservationByCode($kode_reservasi);
        return view('pages.users.reservasi-detail', compact('reservasi'));
    }

    /**
     * Menampilkan riwayat reservasi pengguna.
     */
    public function history()
    {
        $reservasi = $this->reservasiService->getUserHistory();
        return view('pages.users.reservasi-history', compact('reservasi'));
    }

    // =================================================================
    // Metode untuk Admin Panel
    // =================================================================

    /**
     * Menampilkan halaman utama reservasi admin.
     */
    public function adminIndex()
    {
        $reservasis = $this->reservasiService->getAdminReservations();
        return view('pages.admin.reservasi.index', compact('reservasis'));
    }

    /**
     * Menampilkan form untuk membuat reservasi baru oleh admin.
     */
    public function adminCreate()
    {
        $mejas = $this->reservasiService->getAllMeja();
        return view('pages.admin.reservasi.create', compact('mejas'));
    }

    public function adminStore(Request $request)
    {
        $request->validate([
            'nama_pelanggan'    => 'required|string|max:255',
            'no_telepon'        => 'required|string|max:15',
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'jam_reservasi'     => 'required|date_format:H:i',
            'nomor_meja'        => 'required|exists:meja,nomor_meja',
            'catatan'           => 'nullable|string',
        ]);

        try {
            $this->reservasiService->createAdminReservation($request->all());
            return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil dibuat.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat reservasi.')->withInput();
        }
    }

    public function adminShow($kode_reservasi)
    {
        $reservasi = $this->reservasiService->getReservationByCode($kode_reservasi);
        return view('pages.admin.reservasi.show', compact('reservasi'));
    }

    /**
     * Menampilkan form edit reservasi di panel admin.
     */
    public function adminEdit($kode_reservasi)
    {
        $reservasi = $this->reservasiService->getReservationByCode($kode_reservasi);
        $mejas     = $this->reservasiService->getAllMeja();
        return view('pages.admin.reservasi.edit', compact('reservasi', 'mejas'));
    }

    public function adminUpdate(Request $request, $kode_reservasi)
    {
        $request->validate([
            'nama_pelanggan'    => 'required|string|max:255',
            'no_telepon'        => 'required|string|max:15',
            'tanggal_reservasi' => 'required|date',
            'jam_reservasi'     => 'required|date_format:H:i',
            'nomor_meja'        => 'required|exists:meja,nomor_meja',
            'catatan'           => 'nullable|string',
        ]);

        try {
            $this->reservasiService->updateAdminReservation($kode_reservasi, $request->all());
            return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil diperbarui.');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui reservasi.')->withInput();
        }
    }

    public function adminDestroy($kode_reservasi)
    {
        try {
            $this->reservasiService->deleteReservation($kode_reservasi);
            return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil dihapus.');
        } catch (Exception $e) {
            return redirect()->route('admin.reservasi.index')->with('error', 'Gagal menghapus reservasi.');
        }
    }

    public function show(Reservasi $reservasi)
    {
        return response()->json([
            'success' => true,
            'data'    => $reservasi->load('meja'),
        ]);
    }

    public function update(Request $request, Reservasi $reservasi)
    {
        $validator = Validator::make($request->all(), [
            'nama_pelanggan' => 'sometimes|required|string|max:255',
            'jumlah_orang'   => 'sometimes|required|integer|min:1',
            'catatan'        => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        try {
            $updatedReservasi = $this->reservasiService->updateUserReservation($reservasi, $validator->validated());
            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil diperbarui.',
                'data'    => $updatedReservasi,
            ]);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal memperbarui reservasi.'], 500);
        }
    }

    public function destroy(Reservasi $reservasi)
    {
        try {
            $this->reservasiService->deleteReservation($reservasi->kode_reservasi);
            return response()->json(['success' => true, 'message' => 'Reservasi berhasil dibatalkan.']);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Gagal membatalkan reservasi.'], 500);
        }
    }
}