<?php

namespace App\Http\Controllers;

class Exercise03Controller extends Controller
{
    const CRAVAT_TYPE = 1;
    const WHITE_SHIRT_TYPE = 2;
    const DISCOUNT_TYPE_ONE = 12;
    const DISCOUNT_TYPE_TWO = 7;
    const DISCOUNT_TYPE_THREE = 5;
    const NO_DISCOUNT = 0;
    const TOTAL_PRODUCT_TO_DISCOUNT = 7;

    /**
     * Calculate discount by products
     *
     * @param $products
     * @return int
     */
    public function calculateDiscount($products)
    {
        $products = collect($products);
        $totalProduct = $products->count();

        if ($totalProduct) {
            $hasCravat = $products->filter(function ($product) {
                return $product['type'] == self::CRAVAT_TYPE;
            })->isNotEmpty();

            $hasWhiteShirt = $products->filter(function ($product) {
                return $product['type'] === self::WHITE_SHIRT_TYPE;
            })->isNotEmpty();

            if ($totalProduct >= self::TOTAL_PRODUCT_TO_DISCOUNT) {
                if ($hasCravat && $hasWhiteShirt) return self::DISCOUNT_TYPE_ONE;
                if (!$hasCravat || !$hasWhiteShirt) return self::DISCOUNT_TYPE_TWO;
            } else {
                if ($hasCravat && $hasWhiteShirt) return self::DISCOUNT_TYPE_THREE;
                if (!$hasCravat && !$hasWhiteShirt) return self::NO_DISCOUNT;
            }
        }

        return self::NO_DISCOUNT;
    }
}