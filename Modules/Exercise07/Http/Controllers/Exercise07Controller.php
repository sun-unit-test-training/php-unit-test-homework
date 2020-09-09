<?php

namespace Modules\Exercise07\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

class Exercise07Controller extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return Renderable
     */
    public function index()
    {
        return view('exercise07::index');
    }
}
