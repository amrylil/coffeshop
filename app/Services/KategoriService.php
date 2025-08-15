<?php
namespace App\Services;

use App\Models\KategoriProduk;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class KategoriService
{
    /**
     * Create a new category with image handling.
     *
     * @param array $data Validated data from the request.
     * @return KategoriProduk
     * @throws Exception
     */
    public function create(array $data): KategoriProduk
    {
        try {
            if (isset($data['path_img'])) {
                $file = $data['path_img'];
                // The store method returns the path, which is what we want to save.
                $data['path_img'] = $file->store('kategori', 'public');
            }

            return KategoriProduk::create($data);
        } catch (Exception $e) {
            Log::error('Failed to create category: ' . $e->getMessage());
            throw new Exception('Could not create the category.');
        }
    }

    /**
     * Update an existing category with image handling.
     *
     * @param KategoriProduk $category The category to update.
     * @param array $data Validated data from the request.
     * @return KategoriProduk
     * @throws Exception
     */
    public function update(KategoriProduk $category, array $data): KategoriProduk
    {
        try {
            if (isset($data['path_img'])) {
                // Delete the old image if it exists
                if ($category->path_img) {
                    Storage::disk('public')->delete($category->path_img);
                }

                $file             = $data['path_img'];
                $data['path_img'] = $file->store('kategori', 'public');
            }

            $category->update($data);
            return $category;
        } catch (Exception $e) {
            Log::error("Failed to update category {$category->kode_kategori}: " . $e->getMessage());
            throw new Exception('Could not update the category.');
        }
    }

    /**
     * Delete a category after checking for dependencies and removing its image.
     *
     * @param KategoriProduk $category The category to delete.
     * @return void
     * @throws Exception
     */
    public function delete(KategoriProduk $category): void
    {
        // Check if the category has any associated menu items
        if ($category->menu()->count() > 0) {
            throw new Exception('Cannot delete category that has menu items. Please reassign or remove them first.');
        }

        try {
            // Delete the image file if it exists
            if ($category->path_img) {
                Storage::disk('public')->delete($category->path_img);
            }

            $category->delete();
        } catch (Exception $e) {
            Log::error("Failed to delete category {$category->kode_kategori}: " . $e->getMessage());
            throw new Exception('Could not delete the category.');
        }
    }
}