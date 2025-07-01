<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KategoriProduk;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RoutingController;
use Illuminate\Support\Facades\Storage;

class KategoriProdukController extends RoutingController
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $categories = KategoriProduk::all();
    return view('pages.admin.kategori.index', compact('categories'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('pages.admin.kategori.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    $request->validate([
      'kode_kategori' => 'required|string|max:50|unique:kategori_produk,kode_kategori',  // Added validation for manual category ID
      'nama'          => 'required|string|max:255',
      'deskripsi'     => 'nullable|string',
      'path_img'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->only(['kode_kategori', 'nama', 'deskripsi']);

    if ($request->hasFile('path_img')) {
      $path             = $request->file('path_img')->store('kategori', 'public');
      $data['path_img'] = $path;
    }

    KategoriProduk::create($data);

    return redirect()
      ->route('admin.kategori.index')
      ->with('success', 'Category created successfully!');
  }

  /**
   * Display the specified resource.
   */
  public function show(string $id)
  {
    $category = KategoriProduk::with('menu')->findOrFail($id);
    return view('pages.admin.kategori.show', compact('category'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(string $id)
  {
    $category = KategoriProduk::findOrFail($id);
    return view('pages.admin.kategori.edit', compact('category'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, string $id)
  {
    $request->validate([
      'nama'      => 'required|string|max:255',
      'deskripsi' => 'nullable|string',
      'path_img'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $category = KategoriProduk::findOrFail($id);
    $data     = $request->only(['nama', 'deskripsi']);

    if ($request->hasFile('path_img')) {
      // Delete old image if exists
      if ($category->path_img) {
        Storage::disk('public')->delete($category->path_img);
      }

      $path             = $request->file('path_img')->store('kategori', 'public');
      $data['path_img'] = $path;
    }

    $category->update($data);

    return redirect()
      ->route('admin.kategori.index')
      ->with('success', 'Category updated successfully!');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(string $id)
  {
    $category = KategoriProduk::findOrFail($id);

    // Check if category has related menus
    if ($category->menu()->count() > 0) {
      return redirect()
        ->route('admin.kategori.index')
        ->with('error', 'Cannot delete category that has menu items. Remove or reassign menu items first.');
    }

    // Delete image if exists
    if ($category->path_img) {
      Storage::disk('public')->delete($category->path_img);
    }

    $category->delete();

    return redirect()
      ->route('admin.kategori.index')
      ->with('success', 'Category deleted successfully!');
  }
}
