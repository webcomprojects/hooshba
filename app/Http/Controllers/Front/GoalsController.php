<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GoalsController extends Controller
{
    public function index()
    {
        return view('front.goals.index');
    }
}
