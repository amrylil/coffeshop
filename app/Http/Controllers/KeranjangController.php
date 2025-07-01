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
            return $item->quantity * $item->menu->harga;
        });

        return view('pages.users.keranjang', compact('keranjang', 'items', 'total'));
    }

    /**
     * Add item to cart
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'kode_menu' => 'required|exists:menu,kode_menu',
            'quantity'  => 'required|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $menu = Menu::where('kode_menu', $request->kode_menu)->first();
            if (!$menu) {
                return response()->json([
                    'success' => false,
                    'message' => 'Menu tidak ditemukan'
                ], 404);
            }

            $keranjang = $this->getOrCreateKeranjang();

            // Check if item already exists in cart
            $existingItem = ItemKeranjang::where('kode_keranjang', $keranjang->kode_keranjang)
                ->where('kode_menu', $request->kode_menu)
                ->first();

            if ($existingItem) {
                // Update quantity if item exists
                $existingItem->quantity += $request->quantity;
                $existingItem->save();
                $item = $existingItem;
            } else {
                // Create new item
                $item = ItemKeranjang::create([
                    'kode_keranjang' => $keranjang->kode_keranjang,
                    'kode_menu'      => $request->kode_menu,
                    'quantity'       => $request->quantity,
                    'price'          => $menu->harga ?? 0
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
            'quantity' => 'required|integer|min:1'
        ]);

        try {
            $item = ItemKeranjang::where('kode_item', $kodeItem)->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item tidak ditemukan'
                ], 404);
            }

            // Verify item belongs to current user's cart
            if ($item->keranjang->email !== Auth::user()->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak memiliki akses ke item ini'
                ], 403);
            }

            $item->quantity = $request->quantity;
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
            $item = ItemKeranjang::where('kode_item', $kodeItem)->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item tidak ditemukan'
                ], 404);
            }

            // Verify item belongs to current user's cart
            if ($item->keranjang->email !== Auth::user()->email) {
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
            $keranjang = Keranjang::where('email', Auth::user()->email)->first();

            if ($keranjang) {
                ItemKeranjang::where('kode_keranjang', $keranjang->kode_keranjang)->delete();
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
        $keranjang = Keranjang::where('email', Auth::user()->email)->first();

        $count = 0;
        if ($keranjang) {
            $count = ItemKeranjang::where('kode_keranjang', $keranjang->kode_keranjang)
                ->sum('quantity');
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
        $keranjang = Keranjang::where('email', Auth::user()->email)->first();

        $total = 0;
        if ($keranjang) {
            $items = ItemKeranjang::where('kode_keranjang', $keranjang->kode_keranjang)->get();
            $total = $items->sum(function ($item) {
                return $item->quantity * $item->price;
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
        $keranjang = Keranjang::where('email', Auth::user()->email)->first();

        if (!$keranjang) {
            $keranjang = Keranjang::create([
                'email' => Auth::user()->email
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
            $item = ItemKeranjang::where('kode_item', $kodeItem)->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item tidak ditemukan'
                ], 404);
            }

            // Verify item belongs to current user's cart
            if ($item->keranjang->email !== Auth::user()->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak memiliki akses ke item ini'
                ], 403);
            }

            $item->quantity += 1;
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
            $item = ItemKeranjang::where('kode_item', $kodeItem)->first();

            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item tidak ditemukan'
                ], 404);
            }

            // Verify item belongs to current user's cart
            if ($item->keranjang->email !== Auth::user()->email) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak memiliki akses ke item ini'
                ], 403);
            }

            if ($item->quantity <= 1) {
                // If quantity is 1 or less, remove the item
                $item->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Item dihapus karena quantity menjadi 0',
                    'removed' => true
                ]);
            } else {
                $item->quantity -= 1;
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
