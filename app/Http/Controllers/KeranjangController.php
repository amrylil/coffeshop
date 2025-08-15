<?php
namespace App\Http\Controllers;

use App\Services\KeranjangService;
use Exception;
use function Termwind\render;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Inertia\Inertia;

class KeranjangController extends Controller
{
    protected $keranjangService;

    public function __construct(KeranjangService $keranjangService)
    {
        $this->keranjangService = $keranjangService;
    }

    /**
     * Display the user's shopping cart page.
     */
    public function index()
    {
        $cartDetails = $this->keranjangService->getCartDetails();
        return Inertia::render('Users/Keranjang', [
            'cartDetails' => $cartDetails,

        ]);
    }

    /**
     * Add an item to the cart via API.
     */
    public function addToCart(Request $request)
    {
        $validatedData = $request->validate([
            'kode_menu' => 'required|exists:menu,kode_menu',
            'quantity'  => 'required|integer|min:1',
        ]);

        try {
            $item = $this->keranjangService->addToCart($validatedData);
            return response()->json([
                'success' => true,
                'message' => 'Item berhasil ditambahkan ke keranjang',
                'data'    => $item,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan item: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Update an item's quantity via API.
     */
    public function updateQuantity(Request $request, $kodeItem)
    {
        $validatedData = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $item = $this->keranjangService->updateItemQuantity($kodeItem, $validatedData['quantity']);
            return redirect()->back();
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    /**
     * Remove an item from the cart via API.
     */
    public function removeItem($kodeItem)
    {
        try {
            $this->keranjangService->removeItem($kodeItem);
            return redirect()->back();

        } catch (Exception $e) {
            return redirect()->back()->withErrors([
                'error' => 'Gagal menghapus item: ' . $e->getMessage(),
            ]);

        }
    }

    /**
     * Clear the entire cart via API.
     */
    public function clearCart()
    {
        try {
            $this->keranjangService->clearCart();
            return redirect()->back();

        } catch (Exception $e) {
            return redirect()->back()->withErrors([
                'error' => 'Gagal mengosongkan keranjang: ' . $e->getMessage(),
            ]);

        }
    }

    /**
     * Get the total item count for the cart via API.
     */
    public function getCartCount()
    {
        $cartDetails = $this->keranjangService->getCartDetails();
        return response()->json([
            'success' => true,
            'count'   => $cartDetails['count'],
        ]);
    }
}
