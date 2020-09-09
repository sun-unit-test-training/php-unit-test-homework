<?php

namespace Modules\Exercise01\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

class Exercise01Controller extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return Renderable
     */
    public function index()
    {
        return view('exercise01::index');
    }
}
