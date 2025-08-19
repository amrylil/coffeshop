<?php
namespace App\Helpers;

use Illuminate\Support\Str;

class IDGeneratorHelper
{
    /**
     * Generate a unique user ID
     * Format: USR-{random_string}-{timestamp}
     *
     * @return string
     */
    public static function generateUserID(): string
    {
        return 'USR-' . Str::random(6);
    }

    /**
     * Generate a unique category ID
     * Format: CAT-{random_string}
     *
     * @return string
     */
    public static function generateKategoriID(): string
    {
        return 'CAT-' . Str::random(8);
    }

    /**
     * Generate a unique menu ID
     * Format: MNU-{random_string}
     *
     * @return string
     */
    public static function generateMenuID(): string
    {
        return 'MNU-' . Str::random(8);
    }

    /**
     * Generate a unique cart ID
     * Format: CRT-{random_string}-{timestamp}
     *
     * @return string
     */
    public static function generateKeranjangID(): string
    {
        return 'CRT-' . Str::random(8) . '-' . time();
    }

    /**
     * Generate a unique cart item ID
     * Format: CRTI-{random_string}-{timestamp}
     *
     * @return string
     */
    public static function generateItemKeranjangID(): string
    {
        return 'CRTI-' . Str::random(8) . '-' . time();
    }

    /**
     * Generate a unique transaction ID
     * Format: TRX-{random_string}-{timestamp}
     *
     * @return string
     */
    public static function generateTransaksiID(): string
    {
        return 'TRX-' . Str::random(8);
    }

    public static function generateItemTransaksiID(): string
    {
        return 'ITRX-' . Str::random(8);
    }

    /**
     * Generate a unique delivery ID
     * Format: DLV-{random_string}-{timestamp}
     *
     * @return string
     */
    public static function generateDeliveryID(): string
    {
        return 'DLV-' . Str::random(6) . '-' . time();
    }

    /**
     * Generate a unique table ID/number
     * Format: TBL-{3_digit_number}
     *
     * @param int $number Optional table number
     * @return string
     */
    public static function generateMejaID(int $number = null): string
    {
        if ($number !== null) {
            return 'TBL-' . str_pad($number, 3, '0', STR_PAD_LEFT);
        }

        return 'TBL-' . str_pad(mt_rand(1, 999), 3, '0', STR_PAD_LEFT);
    }

    /**
     * Generate a unique reservation ID
     * Format: RSV-{random_string}-{timestamp}
     *
     * @return string
     */
    public static function generateReservasiID(): string
    {
        return 'RSV-' . Str::random(8) . '-' . time();
    }
}
