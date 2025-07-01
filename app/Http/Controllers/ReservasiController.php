<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Reservasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class ReservasiController extends Controller
{
    /**
     * Menampilkan halaman reservasi dengan daftar meja.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Mengambil semua data meja untuk ditampilkan di view
        $mejas = Meja::all();
        return view('pages.users.reservasi', compact('mejas'));
    }

    /**
     * Menampilkan halaman admin reservasi dengan daftar reservasi.
     *
     * @return \Illuminate\View\View
     */
    public function adminIndex()
    {
        $reservasis = Reservasi::with('meja')->orderBy('created_at', 'desc')->paginate(15);
        return view('pages.admin.reservasi.index', compact('reservasis'));
    }

    public function adminCreate()
    {
        $mejas = Meja::all();
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

        $meja = Meja::find($request->nomor_meja);

        $dataToCreate                 = $request->all();
        $dataToCreate['jumlah_orang'] = $meja->kapasitas;

        Reservasi::create($dataToCreate);
        $meja->update(['status' => 'Dipesan']);

        return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil dibuat.');
    }

    public function adminShow($kode_reservasi)
    {
        $reservasi = Reservasi::with('meja')->findOrFail($kode_reservasi);
        return view('pages.admin.reservasi.show', compact('reservasi'));
    }

    public function adminEdit($kode_reservasi)
    {
        $reservasi = Reservasi::findOrFail($kode_reservasi);
        $mejas     = Meja::all();
        return view('pages.admin.reservasi.edit', compact('reservasi', 'mejas'));
    }

    public function adminUpdate(Request $request, $kode_reservasi)
    {
        $request->validate([
            'nama_pelanggan'    => 'required|string|max:255',
            'no_telepon'        => 'required|string|max:15',
            'tanggal_reservasi' => 'required|date|after_or_equal:today',
            'jam_reservasi'     => 'required|date_format:H:i',
            'nomor_meja'        => 'required|exists:meja,nomor_meja',
            'catatan'           => 'nullable|string',
        ]);

        $reservasi = Reservasi::findOrFail($kode_reservasi);
        $meja      = Meja::find($request->nomor_meja);

        $dataToUpdate                 = $request->all();
        $dataToUpdate['jumlah_orang'] = $meja->kapasitas;

        $reservasi->update($dataToUpdate);

        return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil diperbarui.');
    }

    public function adminDestroy($kode_reservasi)
    {
        $reservasi = Reservasi::findOrFail($kode_reservasi);
        $meja      = $reservasi->meja;
        $reservasi->delete();

        $adaReservasiLain = Reservasi::where('nomor_meja', $meja->nomor_meja)
            ->where('tanggal_reservasi', '>=', now()->toDateString())
            ->exists();

        if (!$adaReservasiLain) {
            $meja->update(['status' => 'Tersedia']);
        }

        return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil dihapus.');
    }

    /**
     * Menyimpan data reservasi baru dari form.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // Validasi lainnya...
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

        $meja = Meja::find($request->nomor_meja);

        // ... (logika cek konflik waktu reservasi)

        $dataToCreate                 = $request->all();
        // Tambahkan user_id dari pengguna yang sedang login
        $dataToCreate['email']        = Auth::user()->email;
        $dataToCreate['jumlah_orang'] = $meja->kapasitas;

        DB::beginTransaction();
        try {
            $reservasi = Reservasi::create($dataToCreate);
            $meja->update(['status' => 'Dipesan']);
            DB::commit();

            return redirect()
                ->route('reservasi.detail', ['kode_reservasi' => $reservasi->kode_reservasi])
                ->with('success', 'Reservasi Anda berhasil dibuat!');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat reservasi.')->withInput();
        }
    }

    // Metode show, update, dan destroy tetap sama (mengembalikan JSON)
    // Jika Anda ingin metode ini juga menggunakan view, beri tahu saya.
    public function show(Reservasi $reservasi)
    {
        return response()->json([
            'success' => true,
            'data'    => $reservasi->load('meja')
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
            $reservasi->update($request->all());
            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil diperbarui.',
                'data'    => $reservasi->load('meja')
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui reservasi.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Reservasi $reservasi)
    {
        DB::beginTransaction();
        try {
            $meja = $reservasi->meja;
            $reservasi->delete();

            $adaReservasiLain = Reservasi::where('nomor_meja', $meja->nomor_meja)
                ->where('tanggal_reservasi', '>=', Carbon::today()->toDateString())
                ->exists();

            if (!$adaReservasiLain) {
                $meja->update(['status' => 'Tersedia']);
            }
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Reservasi berhasil dibatalkan.'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membatalkan reservasi.',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function detail($kode_reservasi)
    {
        $reservasi = Reservasi::with('meja')->findOrFail($kode_reservasi);
        return view('pages.users.reservasi-detail', compact('reservasi'));
    }

    public function history()
    {
        // Mengambil data reservasi milik user yang sedang login
        $reservasi = Reservasi::where('email', Auth::user()->email)
            ->with('meja')
            ->latest('created_at')
            ->paginate(10);

        return view('pages.users.reservasi-history', compact('reservasi'));
    }
}
