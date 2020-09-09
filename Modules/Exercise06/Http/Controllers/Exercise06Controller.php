<?php

namespace Modules\Exercise06\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

class Exercise06Controller extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return Renderable
     */
    public function index()
    {
        return view('exercise06::index');
    }
}
