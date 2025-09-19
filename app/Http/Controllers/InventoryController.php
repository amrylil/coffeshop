<?php
namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Services\InventoryService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RoutingController;
use Inertia\Inertia;
use Inertia\Response;

class InventoryController extends RoutingController
{
    protected $inventoryService;

    /**
     * Constructor untuk meng-inject InventoryService.
     *
     * @param InventoryService $inventoryService
     */
    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Menampilkan halaman utama manajemen inventaris.
     */
    public function index(): Response
    {
        $inventories = $this->inventoryService->getAll();

        return Inertia::render('Admin/Inventory', [
            'inventories' => $inventories,
        ]);
    }

    /**
     * Menyimpan data inventaris baru dari form.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'kode_bahan' => 'required|string|max:50|unique:inventory,kode_bahan',
            'nama_bahan' => 'required|string|max:255',
            'satuan'     => 'required|string|max:50',
            'stok'       => 'required|numeric|min:0',
        ]);

        try {
            $this->inventoryService->create($validatedData);
            return redirect()->route('admin.inventory.index')->with('success', 'Bahan berhasil ditambahkan!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Memperbarui data inventaris yang ada.
     */
    public function update(Request $request, Inventory $inventory): RedirectResponse
    {
        $validatedData = $request->validate([
            'kode_bahan' => 'required|string|max:50|unique:inventory,kode_bahan,' . $inventory->kode_bahan . ',kode_bahan',
            'nama_bahan' => 'required|string|max:255',
            'satuan'     => 'required|string|max:50',
            'stok'       => 'required|numeric|min:0',
        ]);

        try {
            $this->inventoryService->update($inventory, $validatedData);
            return redirect()->route('admin.inventory.index')->with('success', 'Bahan berhasil diperbarui!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Menghapus data inventaris.
     */
    public function destroy(Inventory $inventory): RedirectResponse
    {
        try {
            $this->inventoryService->delete($inventory);
            return redirect()->route('admin.inventory.index')->with('success', 'Bahan berhasil dihapus!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}