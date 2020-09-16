<?php

namespace Modules\Exercise05\Services;


class OrderService
{   
    /**
     * Handle discount with option receive and price
     *
     * @param  array $detailOrder
     * @return array
     */
    public function handleDiscount(array $detailOrder)
    {
        $infoBill = [
            'price' => $detailOrder['price'],
            'discount_pizza' => null,
            'discount_potato' => null,
        ];

        if ($detailOrder['price'] > config('exercise05.price_has_discount_potato')) {
            $infoBill['discount_potato'] = config('exercise05.free_potato');
        }

        if ($detailOrder['option_receive'] == config('exercise05.receive_at_home')) {

            if ($detailOrder['option_coupon'] == config('exercise05.has_coupon')) {
                $infoBill['price'] = round(($detailOrder['price'] * 80) / 100, 2);
            }

            return $infoBill;
        }

        $infoBill['discount_pizza'] = config('exercise05.discount_pizza');

        return $infoBill;
    }
}
