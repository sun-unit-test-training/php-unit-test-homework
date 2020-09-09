<?php

namespace Modules\Exercise08\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

class Exercise08Controller extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return Renderable
     */
    public function index()
    {
        return view('exercise08::index');
    }
}
