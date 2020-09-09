<?php

namespace Modules\Exercise10\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

class Exercise10Controller extends Controller
{
    /**
     * Display a listing of the resource
     *
     * @return Renderable
     */
    public function index()
    {
        return view('exercise10::index');
    }
}
