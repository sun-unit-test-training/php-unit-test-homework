<?php

namespace Modules\Exercise06\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Exercise06\Http\Requests\Exercise06Request;
use Modules\Exercise06\Services\CaculateService;

class Exercise06Controller extends Controller
{
    protected $service;

    public function __construct(CaculateService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('exercise06::index', [
            'case1' => $this->service::CASE_1,
            'case2' => $this->service::CASE_2,
            'freeTimeForMovie' => $this->service::FREE_TIME_FOR_MOVIE,
        ]);
    }

    public function caculate(Exercise06Request $request)
    {
        $inputs = $request->validated();
        $time = $this->service->calculate($inputs['bill'], isset($inputs['has_watch']));

        return back()
            ->withInput()
            ->with('caculate', [
                'time' => $time,
            ]);
    }
}
