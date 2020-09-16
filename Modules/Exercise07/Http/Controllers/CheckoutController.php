<?php

namespace Modules\Exercise07\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Modules\Exercise07\Services\CheckoutService;
use Modules\Exercise07\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{

    /**
     * @var CheckoutService
     */
    private $checkoutService;

    /**
     * CheckoutController constructor.
     * @param CheckoutService $checkoutService
     */
    public function __construct(CheckoutService $checkoutService)
    {
        $this->checkoutService = $checkoutService;
    }

    /**
     * Display a listing of the resource
     *
     * @return Renderable
     */
    public function index()
    {
        return view('exercise07::checkout.index');
    }

    /**
     * @param CheckoutRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CheckoutRequest $request)
    {
        $order = $this->checkoutService->calculateShippingFee($request->all());

        return back()
            ->withInput()
            ->with('order', $order);
    }
}
