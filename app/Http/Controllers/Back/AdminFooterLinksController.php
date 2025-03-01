<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\FooterLink;
use Illuminate\Http\Request;

class AdminFooterLinksController extends Controller
{
    public function index()
    {
        $footers1=FooterLink::where('link_group_id',0)->get();
        $footers2=FooterLink::where('link_group_id',1)->get();
        $footers3=FooterLink::where('link_group_id',2)->get();
        return view('back.settings.footerlink.index',compact('footers1','footers2','footers3'));
    }
    public function create()
    {
        return view('back.settings.footerlink.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'link_group_id' => 'required|in:0,1,2',
        ]);

        $item=new FooterLink();
        $item->title=$request->title;
        $item->link=$request->link;
        $item->link_group_id=$request->link_group_id;
        $item->save();

        toastr()->success('با موفقیت ذخیره شد');
        return redirect()->route('back.settings.footerlinks.index');

    }

    public function edit(FooterLink $footerlink)
    {
        return view('back.settings.footerlink.edit',compact('footerlink'));
    }
    public function update(Request $request,FooterLink $footerlink)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'link_group_id' => 'required|in:0,1,2',
        ]);


        $footerlink->title=$request->title;
        $footerlink->link=$request->link;
        $footerlink->link_group_id=$request->link_group_id;
        $footerlink->save();

        toastr()->success('با موفقیت ذخیره شد');
        return redirect()->route('back.settings.footerlinks.index');

    }


    public function footerLinks_groups()
    {
        return view('back.settings.footerlink.groups');
    }
    public function footerLinks_groups_store(Request $request)
    {
        $request->validate([
            'footerlink_groups' => 'nullable|array',
        ]);

        option_update("footerlink_groups", json_encode($request->footerlink_groups));


        toastr()->success('با موفقیت ذخیره شد');
        return redirect()->route('back.settings.footerlinks.groups.index');

    }


    public function destroy(FooterLink $footerlink)
    {
        $this->authorize('members.delete');

        // حذف پست
        $footerlink->delete();
        toastr()->success('  موفقیت حذف شد');

        return redirect()->route('back.settings.footerlinks.index');
    }



}
