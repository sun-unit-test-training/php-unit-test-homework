<?php
namespace Modules\Exercise07\Services;

use Modules\Exercise07\Constants\Checkout;

class CheckoutService
{
    /**
     * Calculate shipping fee for order
     *
     * @param $order
     * @return mixed
     */
    public function calculateShippingFee($order)
    {
        $shippingFee = Checkout::SHIPPING_FEE;
        $shippingExpressFee = Checkout::SHIPPING_EXPRESS_FEE;

        if ($order['amount'] >= Checkout::FREE_SHIPPING_AMOUNT || !empty($order['premium_member'])) {
            $shippingFee = 0;
        }

        if (empty($order['shipping_express'])) {
            $shippingExpressFee = 0;
        }

        $order['shipping_fee'] = $shippingFee + $shippingExpressFee;

        return $order;
    }
}
