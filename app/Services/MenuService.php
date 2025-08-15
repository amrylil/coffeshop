<?php
namespace App\Services;

use App\Models\Menu;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MenuService
{
    /**
     * Create a new menu item with image handling.
     *
     * @param array $data Validated data from the request.
     * @return Menu
     * @throws Exception
     */
    public function create(array $data): Menu
    {
        try {
            if (isset($data['image'])) {
                $image     = $data['image'];
                $imageName = time() . '_' . Str::slug($data['nama']) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $data['path_img'] = $imageName;
                unset($data['image']); // Unset the file object before creating the model
            }

            return Menu::create($data);
        } catch (Exception $e) {
            Log::error('Failed to create menu: ' . $e->getMessage());
            throw new Exception('Could not create the menu item.');
        }
    }

    /**
     * Update an existing menu item with image handling.
     *
     * @param Menu $menu The menu item to update.
     * @param array $data Validated data from the request.
     * @return Menu
     * @throws Exception
     */
    public function update(Menu $menu, array $data): Menu
    {
        try {
            if (isset($data['image'])) {
                // Delete old image if it exists
                if ($menu->path_img) {
                    $oldImagePath = public_path('images/' . $menu->path_img);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath);
                    }
                }

                $image     = $data['image'];
                $imageName = time() . '_' . Str::slug($data['nama']) . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images'), $imageName);
                $data['path_img'] = $imageName;
                unset($data['image']);
            }

            $menu->update($data);
            return $menu;
        } catch (Exception $e) {
            Log::error("Failed to update menu {$menu->kode_menu}: " . $e->getMessage());
            throw new Exception('Could not update the menu item.');
        }
    }

    /**
     * Delete a menu item and its associated image.
     *
     * @param Menu $menu The menu item to delete.
     * @return void
     * @throws Exception
     */
    public function delete(Menu $menu): void
    {
        try {
            // Delete the image file if it exists
            if ($menu->path_img) {
                $imagePath = public_path('images/' . $menu->path_img);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $menu->delete();
        } catch (QueryException $e) {
            // Check for foreign key constraint violation
            if ($e->getCode() === '23000') {
                throw new Exception('Cannot delete this menu because it is associated with existing transactions.');
            }
            Log::error("Database error deleting menu {$menu->kode_menu}: " . $e->getMessage());
            throw new Exception('A database error occurred while deleting the menu.');
        } catch (Exception $e) {
            Log::error("Failed to delete menu {$menu->kode_menu}: " . $e->getMessage());
            throw new Exception('Could not delete the menu item.');
        }
    }
}