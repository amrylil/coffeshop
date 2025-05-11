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
      'nama_222297'      => 'required|string|max:255',
      'deskripsi_222297' => 'nullable|string',
      'path_img_222297'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->only(['nama_222297', 'deskripsi_222297']);

    if ($request->hasFile('path_img_222297')) {
      $path                    = $request->file('path_img_222297')->store('kategori', 'public');
      $data['path_img_222297'] = $path;
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
      'nama_222297'      => 'required|string|max:255',
      'deskripsi_222297' => 'nullable|string',
      'path_img_222297'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $category = KategoriProduk::findOrFail($id);
    $data     = $request->only(['nama_222297', 'deskripsi_222297']);

    if ($request->hasFile('path_img_222297')) {
      // Delete old image if exists
      if ($category->path_img_222297) {
        Storage::disk('public')->delete($category->path_img_222297);
      }

      $path                    = $request->file('path_img_222297')->store('kategori', 'public');
      $data['path_img_222297'] = $path;
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
    if ($category->path_img_222297) {
      Storage::disk('public')->delete($category->path_img_222297);
    }

    $category->delete();

    return redirect()
      ->route('admin.kategori.index')
      ->with('success', 'Category deleted successfully!');
  }
}
