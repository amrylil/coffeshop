<?php
namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Services\KategoriProdukService;
use App\Services\KategoriService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class KategoriController extends Controller
{
    protected $kategoriProdukService;

    public function __construct(KategoriService $kategoriProdukService)
    {
        $this->kategoriProdukService = $kategoriProdukService;
    }

    public function index()
    {
        $categories = KategoriProduk::all();
        // return view('pages.admin.kategori.index', compact('categories'));
        return Inertia::render('Admin/Kategori', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('pages.admin.kategori.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([

            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'path_img'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            // Pass the file object directly to the service if it exists
            if ($request->hasFile('path_img')) {
                $validatedData['path_img'] = $request->file('path_img');
            }

            $this->kategoriProdukService->create($validatedData);
            return redirect()->route('admin.kategori.index')->with('success', 'Category created successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function edit(string $id)
    {
        $category = KategoriProduk::findOrFail($id);
        return view('pages.admin.kategori.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nama'      => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'path_img'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $category = KategoriProduk::findOrFail($id);

            if ($request->hasFile('path_img')) {
                $validatedData['path_img'] = $request->file('path_img');
            }

            $this->kategoriProdukService->update($category, $validatedData);
            return redirect()->route('admin.kategori.index')->with('success', 'Category updated successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $category = KategoriProduk::findOrFail($id);
            $this->kategoriProdukService->delete($category);
            return redirect()->route('admin.kategori.index')->with('success', 'Category deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('admin.kategori.index')->with('error', $e->getMessage());
        }
    }
}