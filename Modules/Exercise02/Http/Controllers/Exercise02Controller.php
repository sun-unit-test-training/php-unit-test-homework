<?php

namespace Modules\Exercise02\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Exercise02\Http\Requests\ATMRequest;
use Modules\Exercise02\Services\ATMService;

class Exercise02Controller extends Controller
{
    protected $atmService;

    public function __construct(ATMService $atmService)
    {
        $this->atmService = $atmService;
    }

    public function index()
    {
        return view('exercise02::index', [
            'normalFee' => ATMService::NORMAL_FEE,
            'noFee' => ATMService::NO_FEE,
            'timePeriod1' => ATMService::TIME_PERIOD_1,
            'timePeriod2' => ATMService::TIME_PERIOD_2,
            'timePeriod3' => ATMService::TIME_PERIOD_3,
        ]);
    }

    /**
     * Display a listing of the resource
     *
     * @return Renderable
     */
    public function takeATMFee(ATMRequest $request)
    {
        $inputs = $request->validated();
        $fee = $this->atmService->calculate($inputs['card_id']);

        return back()->withInput()
            ->with('calculate', [
                'fee' => $fee,
            ]);
    }
}
