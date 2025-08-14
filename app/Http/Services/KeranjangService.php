<?php
namespace App\Http\Services;

use App\Models\ItemKeranjang;
use App\Models\Keranjang;
use App\Models\Menu;
use Exception;
use Illuminate\Support\Facades\Auth;

class KeranjangService
{
    /**
     * Get or create a cart for the currently authenticated user.
     *
     * @return Keranjang
     */
    public function getOrCreateKeranjang(): Keranjang
    {
        return Keranjang::firstOrCreate(
            ['user_id' => Auth::id()]
        );
    }

    /**
     * Add an item to the user's cart. If the item already exists, update its quantity.
     *
     * @param array $data Validated data ['kode_menu', 'quantity']
     * @return ItemKeranjang
     * @throws Exception
     */
    public function addToCart(array $data): ItemKeranjang
    {
        $menu      = Menu::where('kode_menu', $data['kode_menu'])->firstOrFail();
        $keranjang = $this->getOrCreateKeranjang();

        $item = ItemKeranjang::where('kode_keranjang', $keranjang->kode_keranjang)
            ->where('kode_menu', $menu->kode_menu)
            ->first();

        $quantityToAdd = isset($data['quantity']) && $data['quantity'] > 0 ? $data['quantity'] : 1;

        if ($item) {
            $item->increment('quantity', $quantityToAdd);
        } else {
            $item = ItemKeranjang::create([
                'kode_keranjang' => $keranjang->kode_keranjang,
                'kode_menu'      => $menu->kode_menu,
                'quantity'       => $quantityToAdd,
                'price'          => $menu->harga,
            ]);
        }

        $item->refresh();

        return $item;
    }

    /**
     * Get the contents, total, and count of the user's cart.
     *
     * @return array
     */
    public function getCartDetails(): array
    {
        $keranjang = $this->getOrCreateKeranjang();
        if (! $keranjang) {
            return ['keranjang' => null, 'items' => [], 'total' => 0, 'count' => 0];
        }

        $items = $keranjang->items()->with('menu')->get();

        $items->each(function ($item) {
            $item->line_total = $item->quantity * $item->price;
        });

        $total = $items->sum('line_total');
        $count = $items->sum('quantity');

        return [
            'keranjang' => $keranjang,
            'items'     => $items,
            'total'     => $total,
            'count'     => $count,
        ];
    }

    /**
     * Update the quantity of a specific item in the cart.
     *
     * @param string $kodeItem
     * @param int $quantity
     * @return ItemKeranjang
     * @throws Exception
     */
    public function updateItemQuantity(string $kodeItem, int $quantity): ItemKeranjang
    {
        $item = $this->findAndVerifyItem($kodeItem);
        $item->update(['quantity' => $quantity]);
        return $item;
    }

    /**
     * Remove a specific item from the cart.
     *
     * @param string $kodeItem
     * @return void
     * @throws Exception
     */
    public function removeItem(string $kodeItem): void
    {
        $item = $this->findAndVerifyItem($kodeItem);
        $item->delete();
    }

    /**
     * Clear all items from the current user's cart.
     *
     * @return void
     */
    public function clearCart(): void
    {
        $keranjang = Keranjang::where('user_id', Auth::user()->id)->first();
        if ($keranjang) {
            $keranjang->items()->delete();
        }
    }

    /**
     * Find an item and verify it belongs to the current user's cart.
     *
     * @param string $kodeItem
     * @return ItemKeranjang
     * @throws Exception
     */
    private function findAndVerifyItem(string $kodeItem): ItemKeranjang
    {
        $item = ItemKeranjang::where('kode_item', $kodeItem)->firstOrFail();

        if ($item->keranjang->user_id !== Auth::user()->id) {
            throw new Exception('User does not have access to this item.', 403);
        }

        return $item;
    }
}