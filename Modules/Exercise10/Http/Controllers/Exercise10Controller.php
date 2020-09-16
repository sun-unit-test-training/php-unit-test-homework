<?php

namespace Modules\Exercise10\Http\Controllers;

use Modules\Exercise10\Contracts\Services\PrepaidInterface;
use Modules\Exercise10\Http\Requests\PrepaidRequest;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class Exercise10Controller extends Controller
{
    public function __construct(PrepaidInterface $prepaid)
    {
        $this->service = $prepaid;
    }
    /**
     * Display a listing of the resource
     *
     * @return Renderable
     */
    public function index(Request $request)
    {
        return view('exercise10::index');
    }

    public function prepaid(PrepaidRequest $request)
    {
        $data = $request->only(['type', 'price', 'ballot']);
        $results = $this->service->getAmountBonus($data);

        return view('exercise10::index', [
            'results' => $results,
        ]);
    }
}
