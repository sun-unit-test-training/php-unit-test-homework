<?php

namespace Modules\Exercise09\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Exercise09\Http\Requests\AttackBossRequest;
use Modules\Exercise09\Services\CombatService;

class Exercise09Controller extends Controller
{
    /** @var CombatService $attackBossService */
    private $attackBossService;

    /**
     * Exercise09Controller constructor.
     * @param CombatService $attackBossService
     */
    public function __construct(CombatService $attackBossService)
    {
        $this->attackBossService = $attackBossService;
    }

    /**
     * Display a listing of the resource
     *
     * @return Renderable
     */
    public function index()
    {
        return view('exercise09::index');
    }

    public function attack(AttackBossRequest $request)
    {
        $data = $request->only([
            'dua_phep',
            'quan_su',
            'chia_khoa',
            'kiem_anh_sang',
        ]);

        $status = $this->attackBossService->calculateAttackResult($data);
        return back()
            ->withInput()
            ->with('status', $status);
    }
}
