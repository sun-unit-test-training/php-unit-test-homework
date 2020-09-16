<?php

namespace Modules\Exercise01\Services\DTO;

class Price
{
    protected $total;

    protected $voucherDiscount;

    protected $specialTimeDiscount;

    public function __construct($total, $voucherDiscount, $specialTimeDiscount)
    {
        $this->total = $total;
        $this->voucherDiscount = $voucherDiscount;
        $this->specialTimeDiscount = $specialTimeDiscount;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getVoucherDiscount()
    {
        return $this->voucherDiscount;
    }

    public function getSpecialTimeDiscount()
    {
        return $this->specialTimeDiscount;
    }
}
