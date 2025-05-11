<?php

namespace App\Http\Controllers;

use App\Models\KategoriProduk;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as RoutingController;

class UserMenuController extends RoutingController
{
  /**
   * Display a listing of the menus with filter and search.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    // Get all categories for the filter
    $categories = KategoriProduk::all();

    // Start with a base query
    $query = Menu::with('kategori')->where('jumlah_222297', '>', 0);

    // Apply category filter if provided
    if ($request->has('category') && $request->category != 'all') {
      $query->where('kode_kategori_222297', $request->category);
    }

    // Apply search if provided
    if ($request->has('search') && !empty($request->search)) {
      $searchTerm = $request->search;
      $query->where(function ($q) use ($searchTerm) {
        $q
          ->where('nama_222297', 'like', "%{$searchTerm}%")
          ->orWhere('deskripsi_222297', 'like', "%{$searchTerm}%");
      });
    }

    // Apply sorting
    $sortField     = $request->sort_by ?? 'nama_222297';
    $sortDirection = $request->sort_direction ?? 'asc';
    $query->orderBy($sortField, $sortDirection);

    // Get paginated results
    $menus = $query->paginate(12);

    return view('pages.users.menu', compact('menus', 'categories'));
  }

  public function latestMenus()
  {
    // Ambil 4 produk terbaru dengan stok > 0
    $latestMenus = Menu::with('kategori')
      ->where('jumlah_222297', '>', 0)
      ->orderBy('created_at_222297', 'desc')
      ->take(4)
      ->get();

    return view('pages.users.home', compact('latestMenus'));
  }

  /**
   * Display menu items by category.
   *
   * @param  string  $categoryId
   * @return \Illuminate\Http\Response
   */
  public function category($categoryId)
  {
    $category   = KategoriProduk::findOrFail($categoryId);
    $menus      = Menu::where('kode_kategori_222297', $categoryId)
      ->where('jumlah_222297', '>', 0)
      ->paginate(12);
    $categories = KategoriProduk::all();

    return view('pages.users.menu', compact('menus', 'categories', 'category'));
  }

  /**
   * Display the specified menu details.
   *
   * @param  string  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    $menu = Menu::with('kategori')->findOrFail($id);

    // Get related menu items (same category)
    $relatedMenus = Menu::where('kode_kategori_222297', $menu->kode_kategori_222297)
      ->where('kode_menu_222297', '!=', $menu->kode_menu_222297)
      ->where('jumlah_222297', '>', 0)
      ->limit(4)
      ->get();

    return view('pages.users.detail', compact('menu', 'relatedMenus'));
  }

  /**
   * Search menu items.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function search(Request $request)
  {
    $searchTerm = $request->input('query');

    $menus = Menu::where('nama_222297', 'like', "%{$searchTerm}%")
      ->orWhere('deskripsi_222297', 'like', "%{$searchTerm}%")
      ->where('jumlah_222297', '>', 0)
      ->paginate(12);

    $categories = KategoriProduk::all();

    return view('pages.users.search', compact('menus', 'categories', 'searchTerm'));
  }

  /**
   * Filter menu items by price range.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function filterByPrice(Request $request)
  {
    $minPrice = $request->input('min_price', 0);
    $maxPrice = $request->input('max_price');

    $query = Menu::where('jumlah_222297', '>', 0)
      ->where('harga_222297', '>=', $minPrice);

    if ($maxPrice) {
      $query->where('harga_222297', '<=', $maxPrice);
    }

    $menus      = $query->paginate(12);
    $categories = KategoriProduk::all();

    return view('pages.user.menu.index', compact('menus', 'categories', 'minPrice', 'maxPrice'));
  }

  /**
   * Get menu items for AJAX requests.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function getMenuItems(Request $request)
  {
    // Start with a base query
    $query = Menu::with('kategori')->where('jumlah_222297', '>', 0);

    // Apply category filter if provided
    if ($request->has('category_id') && $request->category_id != 'all') {
      $query->where('kode_kategori_222297', $request->category_id);
    }

    // Apply search if provided
    if ($request->has('search') && !empty($request->search)) {
      $searchTerm = $request->search;
      $query->where(function ($q) use ($searchTerm) {
        $q
          ->where('nama_222297', 'like', "%{$searchTerm}%")
          ->orWhere('deskripsi_222297', 'like', "%{$searchTerm}%");
      });
    }

    // Apply price filter if provided
    if ($request->has('min_price')) {
      $query->where('harga_222297', '>=', $request->min_price);
    }

    if ($request->has('max_price')) {
      $query->where('harga_222297', '<=', $request->max_price);
    }

    // Apply sorting
    $sortField     = $request->sort_by ?? 'nama_222297';
    $sortDirection = $request->sort_direction ?? 'asc';
    $query->orderBy($sortField, $sortDirection);

    // Get results
    $menus = $query->paginate(12);

    if ($request->ajax()) {
      return response()->json([
        'html'       => view('pages.user.menu.partials.menu_items', compact('menus'))->render(),
        'pagination' => view('pages.user.menu.partials.pagination', compact('menus'))->render(),
      ]);
    }

    return view('pages.user.menu.index', compact('menus'));
  }
}
