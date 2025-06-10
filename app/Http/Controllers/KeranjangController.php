<?php

namespace App\Http\Controllers;

use App\Models\ItemKeranjang;
use App\Models\Keranjang;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    /**
     * Display keranjang for current user
     */
    public function index()
    {
        $keranjang = $this->getOrCreateKeranjang();
        $items     = $keranjang->items()->with('menu')->get();

        $total = $items->sum(function ($item) {
            return $item->quantity_222297 * $item->menu->harga_222297;
        });

        return view('pages.users.keranjang', compact('keranjang', 'items', 'total'));
    }

    /**
     * Add item to cart
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'kode_menu_222297' => 'required|exists:menu_222297,kode_menu_222297',
            'quantity_222297'  => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $menu = Menu::where('kode_menu_222297', $request->kode_menu_222297)->first();
            if (!$menu) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu tidak ditemukan'
                ], 404);
            }

            $keranjang = $this->getOrCreateKeranjang();

            // Check if item already exists in cart
            $existingItem = ItemKeranjang::where('kode_keranjang_222297', $keranjang->kode_keranjang_222297)
                ->where('kode_menu_222297', $request->kode_menu_222297)
                ->first();

            if ($existingItem) {
                // Update quantity if item exists
                $existingItem->quantity_222297 += $request->quantity_222297;
                $existingItem->save();
                $item = $existingItem;
            } else {
                // Create new item
                $item = ItemKeranjang::create([
                    'kode_keranjang_222297' => $keranjang->kode_keranjang_222297,
                    'kode_menu_222297'      => $request->kode_menu_222297,
                    'quantity_222297'       => $request->quantity_222297,
                    'price_222297'          => $menu->harga_222297 ?? 0
                ]);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil ditambahkan ke keranjang',
                'data'    => $item
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan item ke keranjang: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update item quantity in cart
     */
    public function updateQuantity(Request $request, $kodeItem)
    {
        $request->validate([
            'quantity_222297' => 'required|integer|min:1'
        ]);

        try {
            $item = ItemKeranjang::where('kode_item_222297', $kodeItem)->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item tidak ditemukan'
                ], 404);
            }

            // Verify item belongs to current user's cart
            if ($item->keranjang->email_222297 !== Auth::user()->email_222297) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak memiliki akses ke item ini'
                ], 403);
            }

            $item->quantity_222297 = $request->quantity_222297;
            $item->save();

            return response()->json([
                'success' => true,
                'message' => 'Quantity berhasil diupdate',
                'data'    => $item
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate quantity: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from cart
     */
    public function removeItem($kodeItem)
    {
        try {
            $item = ItemKeranjang::where('kode_item_222297', $kodeItem)->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item tidak ditemukan'
                ], 404);
            }

            // Verify item belongs to current user's cart
            if ($item->keranjang->email_222297 !== Auth::user()->email_222297) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak memiliki akses ke item ini'
                ], 403);
            }

            $item->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item berhasil dihapus dari keranjang'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus item: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear all items from cart
     */
    public function clearCart()
    {
        try {
            $keranjang = Keranjang::where('email_222297', Auth::user()->email_222297)->first();

            if ($keranjang) {
                ItemKeranjang::where('kode_keranjang_222297', $keranjang->kode_keranjang_222297)->delete();
            }

            return response()->json([
                'success' => true,
                'message' => 'Keranjang berhasil dikosongkan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengosongkan keranjang: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cart item count for current user
     */
    public function getCartCount()
    {
        $keranjang = Keranjang::where('email_222297', Auth::user()->email_222297)->first();

        $count = 0;
        if ($keranjang) {
            $count = ItemKeranjang::where('kode_keranjang_222297', $keranjang->kode_keranjang_222297)
                ->sum('quantity_222297');
        }

        return response()->json([
            'success' => true,
            'count'   => $count
        ]);
    }

    /**
     * Get cart total for current user
     */
    public function getCartTotal()
    {
        $keranjang = Keranjang::where('email_222297', Auth::user()->email_222297)->first();

        $total = 0;
        if ($keranjang) {
            $items = ItemKeranjang::where('kode_keranjang_222297', $keranjang->kode_keranjang_222297)->get();
            $total = $items->sum(function ($item) {
                return $item->quantity_222297 * $item->price_222297;
            });
        }

        return response()->json([
            'success' => true,
            'total'   => $total
        ]);
    }

    /**
     * Get or create keranjang for current user
     */
    private function getOrCreateKeranjang()
    {
        $keranjang = Keranjang::where('email_222297', Auth::user()->email_222297)->first();

        if (!$keranjang) {
            $keranjang = Keranjang::create([
                'email_222297' => Auth::user()->email_222297
            ]);
        }

        return $keranjang;
    }

    /**
     * Increment item quantity
     */
    public function incrementQuantity($kodeItem)
    {
        try {
            $item = ItemKeranjang::where('kode_item_222297', $kodeItem)->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item tidak ditemukan'
                ], 404);
            }

            // Verify item belongs to current user's cart
            if ($item->keranjang->email_222297 !== Auth::user()->email_222297) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak memiliki akses ke item ini'
                ], 403);
            }

            $item->quantity_222297 += 1;
            $item->save();

            return response()->json([
                'success' => true,
                'message' => 'Quantity berhasil ditambah',
                'data'    => $item
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambah quantity: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Decrement item quantity
     */
    public function decrementQuantity($kodeItem)
    {
        try {
            $item = ItemKeranjang::where('kode_item_222297', $kodeItem)->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item tidak ditemukan'
                ], 404);
            }

            // Verify item belongs to current user's cart
            if ($item->keranjang->email_222297 !== Auth::user()->email_222297) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak memiliki akses ke item ini'
                ], 403);
            }

            if ($item->quantity_222297 <= 1) {
                // If quantity is 1 or less, remove the item
                $item->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Item dihapus karena quantity menjadi 0',
                    'removed' => true
                ]);
            } else {
                $item->quantity_222297 -= 1;
                $item->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Quantity berhasil dikurangi',
                    'data'    => $item
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengurangi quantity: ' . $e->getMessage()
            ], 500);
        }
    }
}
