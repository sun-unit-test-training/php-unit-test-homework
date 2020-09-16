<?php

namespace Modules\Exercise01\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Exercise01\Http\Requests\OrderRequest;
use Modules\Exercise01\Services\PriceService;

class OrderController extends Controller
{
    protected $priceService;

    public function __construct(PriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    public function showForm()
    {
        return view('exercise01::order', [
            'unitPrice' => $this->priceService::UNIT_PRICE,
            'voucherUnitPrice' => $this->priceService::VOUCHER_UNIT_PRICE,
            'specialTimeUnitPrice' => $this->priceService::SPECIAL_TIME_UNIT_PRICE,
            'specialTimePeriod' => $this->priceService::SPECIAL_TIME_PERIOD,
        ]);
    }

    public function create(OrderRequest $request)
    {
        $inputs = $request->validated();
        $quantity = $inputs['quantity'];

        $price = $this->priceService->calculate($quantity, isset($inputs['voucher']));

        return back()
            ->withInput()
            ->with('order', [
                'quantity' => $quantity,
                'price' => $price,
            ]);
    }
}
