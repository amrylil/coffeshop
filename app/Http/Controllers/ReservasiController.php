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
        $reservasis = Reservasi::with('meja')->orderBy('created_at_222297', 'desc')->paginate(15);
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
            'nama_pelanggan_222297'    => 'required|string|max:255',
            'no_telepon_222297'        => 'required|string|max:15',
            'tanggal_reservasi_222297' => 'required|date|after_or_equal:today',
            'jam_reservasi_222297'     => 'required|date_format:H:i',
            'nomor_meja_222297'        => 'required|exists:meja_222297,nomor_meja_222297',
            'catatan_222297'           => 'nullable|string',
        ]);

        $meja = Meja::find($request->nomor_meja_222297);

        $dataToCreate                        = $request->all();
        $dataToCreate['jumlah_orang_222297'] = $meja->kapasitas_222297;

        Reservasi::create($dataToCreate);
        $meja->update(['status_222297' => 'Dipesan']);

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
            'nama_pelanggan_222297'    => 'required|string|max:255',
            'no_telepon_222297'        => 'required|string|max:15',
            'tanggal_reservasi_222297' => 'required|date|after_or_equal:today',
            'jam_reservasi_222297'     => 'required|date_format:H:i',
            'nomor_meja_222297'        => 'required|exists:meja_222297,nomor_meja_222297',
            'catatan_222297'           => 'nullable|string',
        ]);

        $reservasi = Reservasi::findOrFail($kode_reservasi);
        $meja      = Meja::find($request->nomor_meja_222297);

        $dataToUpdate                        = $request->all();
        $dataToUpdate['jumlah_orang_222297'] = $meja->kapasitas_222297;

        $reservasi->update($dataToUpdate);

        return redirect()->route('admin.reservasi.index')->with('success', 'Reservasi berhasil diperbarui.');
    }

    public function adminDestroy($kode_reservasi)
    {
        $reservasi = Reservasi::findOrFail($kode_reservasi);
        $meja      = $reservasi->meja;
        $reservasi->delete();

        $adaReservasiLain = Reservasi::where('nomor_meja_222297', $meja->nomor_meja_222297)
            ->where('tanggal_reservasi_222297', '>=', now()->toDateString())
            ->exists();

        if (!$adaReservasiLain) {
            $meja->update(['status_222297' => 'Tersedia']);
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
            'nama_pelanggan_222297'    => 'required|string|max:255',
            'no_telepon_222297'        => 'required|string|max:15',
            'tanggal_reservasi_222297' => 'required|date|after_or_equal:today',
            'jam_reservasi_222297'     => 'required|date_format:H:i',
            'nomor_meja_222297'        => 'required|string|exists:meja_222297,nomor_meja_222297',
            'catatan_222297'           => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $meja = Meja::find($request->nomor_meja_222297);

        // ... (logika cek konflik waktu reservasi)

        $dataToCreate                        = $request->all();
        // Tambahkan user_id dari pengguna yang sedang login
        $dataToCreate['email_222297']        = Auth::user()->email_222297;
        $dataToCreate['jumlah_orang_222297'] = $meja->kapasitas_222297;

        DB::beginTransaction();
        try {
            $reservasi = Reservasi::create($dataToCreate);
            $meja->update(['status_222297' => 'Dipesan']);
            DB::commit();

            return redirect()
                ->route('reservasi.detail', ['kode_reservasi' => $reservasi->kode_reservasi_222297])
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
            'nama_pelanggan_222297' => 'sometimes|required|string|max:255',
            'jumlah_orang_222297'   => 'sometimes|required|integer|min:1',
            'catatan_222297'        => 'nullable|string',
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

            $adaReservasiLain = Reservasi::where('nomor_meja_222297', $meja->nomor_meja_222297)
                ->where('tanggal_reservasi_222297', '>=', Carbon::today()->toDateString())
                ->exists();

            if (!$adaReservasiLain) {
                $meja->update(['status_222297' => 'Tersedia']);
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
        $reservasi = Reservasi::where('email_222297', Auth::user()->email_222297)
            ->with('meja')
            ->latest('created_at_222297')
            ->paginate(10);

        return view('pages.users.reservasi-history', compact('reservasi'));
    }
}
