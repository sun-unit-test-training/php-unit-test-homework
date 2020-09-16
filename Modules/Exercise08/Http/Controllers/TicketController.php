<?php

namespace Modules\Exercise08\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Exercise08\Http\Requests\CalculateRequest;
use Modules\Exercise08\Services\TicketService;

class TicketController extends Controller
{
    protected $ticketService;

    /**
     * Construct Exercise05Controller
     *
     * @param  TicketService $ticketService
     * @return void
     */

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    /**
     * Display a listing of the resource
     *
     * @return Renderable
     */
    public function index()
    {
        return view('exercise08::index');
    }

    public function calculatePrice(CalculateRequest $request)
    {
        $data = $request->only(['age', 'booking_date', 'gender', 'name']);

        if ($price = $this->ticketService->calculatePrice($data)) {
            session()->flash('data_success', array_merge(['price' => $price], $data));
        }

        return back()->withInput();
    }
}
