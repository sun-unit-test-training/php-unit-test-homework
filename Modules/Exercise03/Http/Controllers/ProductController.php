<?php

namespace Modules\Exercise03\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Exercise03\Http\Requests\CheckoutRequest;
use Modules\Exercise03\Services\ProductService;

/**
 * Class ProductController
 * @package Modules\Exercise03\Http\Controllers
 */
class ProductController extends Controller
{
    /**
     * @var ProductService
     */
    protected $productService;

    /**
     * ProductController constructor.
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $products = $this->productService->getAllProducts();

        return view('exercise03::index', compact('products'));
    }

    /**
     * @param CheckoutRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkout(CheckoutRequest $request)
    {
        $discount = $this->productService->calculateDiscount($request->input('total_products'));

        return response()->json(['discount' => $discount]);
    }
}
