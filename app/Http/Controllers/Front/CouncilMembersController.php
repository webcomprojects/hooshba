<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;

class CouncilMembersController extends Controller
{
    public function index()
    {
        $CouncilMembers=Member::where('type','council')->orderBy('created_at','desc')->paginate(16);
        return view('front.council-members.index',compact('CouncilMembers'));
    }
}
