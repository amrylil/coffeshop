<?php
namespace App\Http\Controllers;

use App\Services\MejaService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class MejaController extends Controller
{
    protected $mejaService;

    public function __construct(MejaService $mejaService)
    {
        $this->mejaService = $mejaService;
    }

    public function index()
    {
        $mejas = $this->mejaService->getAll();
        return Inertia::render('Users/Reservasi', ['mejas' => $mejas]);
    }

    public function create()
    {
        return view('pages.admin.meja.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nomor_meja_222297' => 'nullable|string|max:50|unique:meja,nomor_meja_222297',
            'kapasitas_222297'  => 'required|integer|min:1',
            'status_222297'     => 'required|string|max:50',
        ]);

        try {
            $this->mejaService->create($validatedData);
            return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil ditambahkan!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $meja = $this->mejaService->findById($id);
        return view('pages.admin.meja.show', compact('meja'));
    }

    public function edit($id)
    {
        $meja = $this->mejaService->findById($id);
        return view('pages.admin.meja.edit', compact('meja'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'kapasitas_222297' => 'required|integer|min:1',
            'status_222297'    => 'required|string|max:50',
        ]);

        try {
            $meja = $this->mejaService->findById($id);
            $this->mejaService->update($meja, $validatedData);
            return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil diperbarui!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $meja = $this->mejaService->findById($id);
            $this->mejaService->delete($meja);
            return redirect()->route('admin.meja.index')->with('success', 'Meja berhasil dihapus!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $validatedData = $request->validate([
            'status_222297' => 'required|string|in:kosong,dipesan,digunakan',
        ]);

        try {
            $meja    = $this->mejaService->findById($id);
            $message = $this->mejaService->updateStatus($meja, $validatedData['status_222297']);
            return redirect()->route('admin.meja.index')->with('success', $message);
        } catch (Exception $e) {
            return redirect()->route('admin.meja.index')->with('error', $e->getMessage());
        }
    }
}