<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use App\Models\Menu;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuController extends RoutingController
{
    /**
     * Display a listing of the menus.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menus = Menu::with('kategori')->get();
        return view('pages.admin.menu.index', compact('menus'));
    }

    /**
     * Show the form for creating a new menu.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = KategoriProduk::all();
        return view('pages.admin.menu.create', compact('categories'));
    }

    /**
     * Store a newly created menu in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_menu_222297'     => 'required|string|max:50|unique:menu_222297,kode_menu_222297',  // Added validation for manual ID
            'nama_222297'          => 'required|string|max:255',
            'deskripsi_222297'     => 'required|string',
            'harga_222297'         => 'required|numeric|min:0',
            'kode_kategori_222297' => 'required|exists:kategori_produk_222297,kode_kategori_222297',
            'jumlah_222297'        => 'required|integer|min:0',
            'image'                => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Store in public/images directory
            $image     = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->nama_222297) . '.' . $image->getClientOriginalExtension();

            // Move to public/images directory
            $image->move(public_path('images'), $imageName);

            // Store path relative to public directory
            $data['path_img_222297'] = $imageName;
        }

        Menu::create($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu added successfully!');
    }

    /**
     * Display the specified menu.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = Menu::with('kategori')->findOrFail($id);
        return view('pages.admin.menu.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified menu.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $menu       = Menu::findOrFail($id);
        $categories = KategoriProduk::all();
        return view('pages.admin.menu.edit', compact('menu', 'categories'));
    }

    /**
     * Update the specified menu in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'nama_222297'          => 'required|string|max:255',
            'deskripsi_222297'     => 'required|string',
            'harga_222297'         => 'required|numeric|min:0',
            'kode_kategori_222297' => 'required|exists:kategori_produk_222297,kode_kategori_222297',
            'jumlah_222297'        => 'required|integer|min:0',
            'image'                => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['image', '_token', '_method']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($menu->path_img_222297) {
                $oldImagePath = public_path($menu->path_img_222297);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $image     = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->nama_222297) . '.' . $image->getClientOriginalExtension();

            // Move to public/images directory
            $image->move(public_path('images'), $imageName);

            // Store path relative to public directory
            $data['path_img_222297'] = $imageName;
        }

        $menu->update($data);

        return redirect()->route('admin.menu.index')->with('success', 'Menu updated successfully!');
    }

    /**
     * Remove the specified menu from storage.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $menu = Menu::findOrFail($id);

            // Hapus gambar dari folder public jika ada
            // Catatan: Logika upload Anda menggunakan public_path(), jadi lebih konsisten menggunakan unlink() untuk menghapus.
            if ($menu->path_img_222297) {
                $imagePath = public_path('images/' . $menu->path_img_222297);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $menu->delete();

            return redirect()->route('admin.menu.index')->with('success', 'Menu deleted successfully!');
        } catch (QueryException $e) {
            // Cek kode error untuk foreign key constraint violation (kode '23000' untuk integrity constraint)
            if ($e->getCode() === '23000') {
                return redirect()
                    ->route('admin.menu.index')
                    ->with('error', 'Gagal menghapus menu. Menu ini sudah digunakan dalam transaksi.');
            }

            // Untuk error database lainnya
            return redirect()
                ->route('admin.menu.index')
                ->with('error', 'Terjadi kesalahan pada database saat menghapus menu.');
        }
    }
}
