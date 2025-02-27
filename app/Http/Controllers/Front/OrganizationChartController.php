<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\OrganizationChart;
use Illuminate\Http\Request;

class OrganizationChartController extends Controller
{
    public function index()
    {
        $items=OrganizationChart::all();
        return view('front.organization-chart.index',compact('items'));
    }
}
