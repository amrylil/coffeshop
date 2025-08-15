<?php
namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Services\MejaService;
use App\Services\ReservasiService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ReservasiController extends Controller
{
    protected $reservasiService;
    protected $mejaService;

    /**
     * Constructor untuk inject ReservasiService.
     *
     * @param ReservasiService $reservasiService
     */
    public function __construct(ReservasiService $reservasiService, MejaService $mejaService)
    {
        $this->reservasiService = $reservasiService;
        $this->mejaService      = $mejaService;
        $this->middleware('auth');
    }

    /**
     * Menampilkan halaman daftar semua reservasi untuk admin.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Reservasi/Index', [
            'reservations' => $this->reservasiService->getAll(),
        ]);
    }

    public function getAllMeja()
    {
        $mejas = $this->mejaService->getAll();
        return Inertia::render('Users/Reservasi', ['mejas' => $mejas]);
    }

    /**
     * Menampilkan form untuk membuat reservasi baru.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        // Anda bisa mengirimkan data pendukung seperti daftar user atau meja yang tersedia ke halaman create
        return Inertia::render('Admin/Reservasi/Create');
    }

    /**
     * Menyimpan reservasi baru ke database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_meja'        => 'required|exists:meja,nomor_meja',
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'jam_reservasi'     => 'required',
            'catatan'           => 'nullable|string|max:255',
        ]);

        try {
            $dataToCreate = array_merge($validatedData, [
                'user_id' => Auth::id(),
            ]);

            $this->reservasiService->create($dataToCreate);

            return Redirect::back()->with('success', 'Reservasi Anda berhasil dibuat!');

        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan form untuk mengedit data reservasi.
     *
     * @param  \App\Models\Reservasi  $reservasi
     * @return \Inertia\Response
     */
    public function edit(Reservasi $reservasi)
    {
        return Inertia::render('Admin/Reservasi/Edit', [
            'reservasi' => $reservasi->load(['user', 'meja']), // Kirim data reservasi beserta relasi
        ]);
    }

    /**
     * Memperbarui data reservasi di database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservasi  $reservasi
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Reservasi $reservasi)
    {
        $validatedData = $request->validate([
            'user_id'           => 'required|exists:users,id',
            'tanggal_reservasi' => 'required|date',
            'jam_reservasi'     => 'required',
            'nomor_meja'        => 'required|exists:meja,nomor_meja',
            'catatan'           => 'nullable|string|max:255',
        ]);

        try {
            $this->reservasiService->update($reservasi, $validatedData);
            return Redirect::route('admin.reservasi.index')->with('success', 'Reservasi berhasil diperbarui.');
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

    /**
     * Memperbarui status reservasi (misal: confirmed, cancelled).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservasi  $reservasi
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, Reservasi $reservasi)
    {
        $validatedData = $request->validate([
            'status' => 'required|string|in:pending,confirmed,cancelled,completed',
        ]);

        try {
            $this->reservasiService->updateStatus($reservasi, $validatedData['status']);
            return Redirect::back()->with('success', 'Status reservasi berhasil diperbarui.');
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }

    /**
     * Menghapus reservasi dari database.
     *
     * @param  \App\Models\Reservasi  $reservasi
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reservasi $reservasi)
    {
        try {
            $this->reservasiService->delete($reservasi);
            // Redirect ke halaman index setelah berhasil hapus
            return Redirect::route('admin.reservasi.index')->with('success', 'Reservasi berhasil dihapus.');
        } catch (Exception $e) {
            return Redirect::back()->with('error', $e->getMessage());
        }
    }
}