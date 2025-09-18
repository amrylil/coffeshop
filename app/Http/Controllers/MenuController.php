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
        $menus      = Menu::with('kategori')->latest('created_at')->get();
        $categories = KategoriProduk::all();

        return Inertia::render('Admin/Menu', [
            'menus'      => $menus,
            'categories' => $categories,
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
            'status'        => 'required|in:available,unavailable',
            'path_img'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // handle upload gambar
        if ($request->hasFile('path_img')) {
            $validatedData['path_img'] = $request->file('path_img')->store('menu', 'public');
        }

        try {
            $this->menuService->create($validatedData);
            return redirect()->route('admin.menu.index')->with('success', 'Menu added successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit($kode_menu)
    {
        $menu       = Menu::findOrFail($kode_menu);
        $categories = KategoriProduk::all();
        return view('pages.admin.menu.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, $kode_menu)
    {
        $menu = Menu::findOrFail($kode_menu);

        $validatedData = $request->validate([
            'nama'          => 'required|string|max:255',
            'deskripsi'     => 'required|string',
            'harga'         => 'required|numeric|min:0',
            'kode_kategori' => 'required|exists:kategori_produk,kode_kategori',
            'status'        => 'required|in:available,unavailable',
            'path_img'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('path_img')) {
            $validatedData['path_img'] = $request->file('path_img')->store('menu', 'public');
        }

        try {
            $this->menuService->update($menu, $validatedData);
            return redirect()->route('admin.menu.index')->with('success', 'Menu updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy($kode_menu)
    {
        try {
            $menu = Menu::findOrFail($kode_menu);
            $this->menuService->delete($menu);
            return redirect()->route('admin.menu.index')->with('success', 'Menu deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('admin.menu.index')->with('error', $e->getMessage());
        }
    }
}