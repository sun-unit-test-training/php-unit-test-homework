<?php

namespace Modules\Exercise05\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Exercise05\Http\Requests\OrderRequest;
use Modules\Exercise05\Services\OrderService;

class Exercise05Controller extends Controller
{
    /**
     * @var OrderService
     */
    protected $orderService;

    /**
     * Construct Exercise05Controller
     *
     * @param  OrderService $orderService
     * @return void
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    /**
     * Display a listing of the resource
     *
     * @return Renderable
     */
    public function index()
    {
        $optionReceives = config('exercise05.option_receive');
        $optionCoupons = config('exercise05.option_coupon');

        return view('exercise05::index', compact('optionReceives', 'optionCoupons'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  OrderRequest
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function store(OrderRequest $request)
    {
        $detailOrder = $request->only('price', 'option_receive', 'option_coupon');
        $resultOrder = $this->orderService->handleDiscount($detailOrder);

        return view('exercise05::detail', compact('resultOrder', 'detailOrder'));
    }
}
