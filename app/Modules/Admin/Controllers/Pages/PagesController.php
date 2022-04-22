<?php

namespace App\Modules\Admin\Controllers\Pages;

use App\DataTables\PagesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Modules\Admin\Models\SitePages\Page;
use App\Modules\Admin\Models\SitePages\PageData;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PagesController extends Controller
{
    protected function index(PagesDataTable $pages) {
        return $pages->render('admin.pages.index');
    }

    protected function create()
    {
        $places = ['footer', 'header', 'about_us', 'home' , 'privacy'];
        $langs = Language::get();
        return view('admin.pages.create', compact('langs', 'places'));
    }

    protected function store(Request $request)
    {

        $request['published'] = $request['published'] ?? 0;
        $request['lang_id'] = $request['lang_id'] ?? Language::first()->id;
        $image_db = '';
        if ($request->has('image')) {
            $request->validate([
//                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                'image' => 'image',
            ]);
            $path = public_path() . '/uploads/blogs';
            $image = request('image');
            $image_name = time() . request('image')->getClientOriginalName();
            $image->move($path, $image_name);
            $image_db = '/uploads/blogs/' . $image_name;
        }
        if($request->place == "about_us"){
            $found = Page::where('place' ,"about_us")->first();
            if($found != null){
                $data = PageData::where('page_id', $found->id)->delete();
                $found->delete();
            }
        }
        $page = Page::create([
            'published' => $request['published'],
            'place' => $request->place,
            'image' => $image_db,
            'page_order' => $request->page_order,
        ]);
        PageData::create([
            'page_id' => $page->id,
            'lang_id' => $request['lang_id'],
            'source_id' => null,
            'title' => $request['title'],
            'content' => $request['content'],
        ]);
        $page->save();
        session()->flash('success', _i('Saved Successfully !'));
        return redirect()->route('pages.index');

    }

    protected function edit($id)
    {
        $places = ['footer', 'header', 'about_us', 'home' , 'privacy'];
        $langs = Language::get();
        $page = Page::where('id',$id)->first();
        $page_data = PageData::where('page_id', $page->id)->where('source_id', null)->first();
        return view('admin.pages.edit', compact('places', 'langs', 'page', 'page_data'));
    }

    protected function update(Request $request, $id)
    {
        $request['published'] = $request['published'] ?? 0;
        $page = Page::where('id' , $id)->first();
        $data = PageData::query()->where('page_id', $page->id)->first();
        if ($request->has('image')) {
            $request->validate([
                'image' => 'image',
            ]);

            $path = public_path() . '/uploads/pages';
            $image = request('image');
            $image_name = time() . request('image')->getClientOriginalName();
            $image->move($path, $image_name);
            $image_in_db = '/uploads/pages/' . $image_name;
        } else {
            $image_in_db = Page::query()->find($request->id)->image;
        }

        if ($request->ajax()){
            $page->update([
                'published' => $request['published'],
                'image' => $image_in_db
            ]);
            return response()->json('SUCCESS');
        }else{

            $page->update([
                'published' => $request['published'],
                'place' => $request->place,
                'image' => $image_in_db
            ]);
            $data->update([
                'content' => $request->input('content'),
                'title' => $request->title,
                'lang_id' => $request->lang_id
            ]);

            session()->flash('success', _i('Page Edited Successfully !'));
            return redirect()->route('pages.index');
        }
    }

    protected function pagergetLangvalue(Request $request)
    {
        $rowData = PageData::where('page_id', $request->transRow)
            ->where('lang_id', $request->lang)
            ->first(['title', 'content']);
        if (!empty($rowData)) {
            return \response()->json(['data' => $rowData]);
        } else {
            return \response()->json(['data' => false]);
        }
    }

    protected function pagestorelangTranslation(Request $request)
    {
        $rowData = PageData::where('page_id', $request->id)
            ->where('lang_id', $request->lang_id_data)
            ->first();
        if ($rowData != null) {
            $rowData->update([
                'title' => $request->title,
                'content' => $request->input('content'),
            ]);
        } else {
            $parentRow = PageData::where('page_id', $request->id)->where('source_id', null)->first();
            PageData::create([

                'title' => $request->title,
                'content' => $request->input('content'),
                'lang_id' => $request->lang_id_data,
                'page_id' => $request->id,
                'source_id' => $parentRow->id,
            ]);
        }
        return \response()->json("SUCCESS");
    }

    protected function delete($id)
    {
        $page = Page::where('id' , $id)->first();
        if ($page == null) {
            return redirect()->back()->with('error_message', _i('Not founds'));
        }
        PageData::where('page_id',$id)->delete();
        $page->delete();
        return redirect()->back()->with('success', _i('Deleted Successfully !'));
    }
}
