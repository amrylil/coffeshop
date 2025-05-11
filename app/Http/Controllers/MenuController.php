<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use App\Models\Menu;
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
            'kode_menu_222297'     => 'required|string|unique:menu_222297,kode_menu_222297',
            'nama_222297'          => 'required|string|max:255',
            'deskripsi_222297'     => 'required|string',
            'harga_222297'         => 'required|numeric|min:0',
            'kode_kategori_222297' => 'required|exists:kategori_produk,kode_kategori_222297',
            'jumlah_222297'        => 'required|integer|min:0',
            'image'                => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except('image');

        // Handle image upload
        if ($request->hasFile('image')) {
            $image     = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->nama_222297) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/menu_images', $imageName);
            $data['path_img_222297'] = 'menu_images/' . $imageName;
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
            'kode_kategori_222297' => 'required|exists:kategori_produk,kode_kategori_222297',
            'jumlah_222297'        => 'required|integer|min:0',
            'image'                => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->except(['image', '_token', '_method']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($menu->path_img_222297) {
                Storage::delete('public/' . $menu->path_img_222297);
            }

            $image     = $request->file('image');
            $imageName = time() . '_' . Str::slug($request->nama_222297) . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/menu_images', $imageName);
            $data['path_img_222297'] = 'menu_images/' . $imageName;
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
        $menu = Menu::findOrFail($id);

        // Delete menu image
        if ($menu->path_img_222297) {
            Storage::delete('public/' . $menu->path_img_222297);
        }

        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu deleted successfully!');
    }
}
