<?php
namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Menu;
use App\Services\MenuService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class MenuController extends Controller
{
    protected $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    public function index()
    {
        $menus      = Menu::with('kategori')->latest()->get();
        $categories = KategoriProduk::all(); // <-- TAMBAHKAN: Ambil semua kategori

        return Inertia::render('Admin/Menu', [
            'menus'      => $menus,
            'categories' => $categories, // <-- TAMBAHKAN: Kirim kategori ke frontend
            'flash'      => [
                'success' => session('success'),
                'error'   => session('error'),
            ],
        ]);
    }

    public function create()
    {
        $categories = KategoriProduk::all();
        return view('pages.admin.menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama'          => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'harga'         => 'required|numeric|min:0',
            'kode_kategori' => 'required|exists:kategori_produk,kode_kategori',
            'jumlah'        => 'required|integer|min:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Pass the file object directly if it exists
        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image');
        }

        try {
            $this->menuService->create($validatedData);
            return redirect()->route('admin.menu.index')->with('success', 'Menu added successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($id)
    {
        $menu       = Menu::findOrFail($id);
        $categories = KategoriProduk::all();
        return view('pages.admin.menu.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $menu          = Menu::findOrFail($id);
        $validatedData = $request->validate([
            'nama'          => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'harga'         => 'required|numeric|min:0',
            'kode_kategori' => 'required|exists:kategori_produk,kode_kategori',
            'jumlah'        => 'required|integer|min:0',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image');
        }

        try {
            $this->menuService->update($menu, $validatedData);
            return redirect()->route('admin.menu.index')->with('success', 'Menu updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $menu = Menu::findOrFail($id);
            $this->menuService->delete($menu);
            return redirect()->route('admin.menu.index')->with('success', 'Menu deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('admin.menu.index')->with('error', $e->getMessage());
        }
    }
}