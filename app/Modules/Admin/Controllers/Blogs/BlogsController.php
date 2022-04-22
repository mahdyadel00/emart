<?php

namespace App\Modules\Admin\Controllers\Blogs;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Models\Blog\Blog;
use App\Models\Blog\BlogCategory;
use App\Models\Blog\BlogCategoryData;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class BlogsController extends Controller
{
    protected function index()
    {
//        blog_categories_attachments
        $blogsCategories = BlogCategory::with(['data_back', 'attachment'])->get();
        if (request()->ajax()) {
            return DataTables::of($blogsCategories)
                ->editColumn('options', function ($query) {
//                    $html = "<a href='#' class='btn waves-effect waves-light btn-primary text-center add-attach mr-1 ml-1' data-id='" . $query->id . "' data-toggle='modal' data-target='#default-Modal-create'>" . _i('Attachments') . "</a>";
                    $html = "<a href='#' class='btn waves-effect waves-light btn-success text-center edit-row mr-1 ml-1' data-toggle='modal' data-target='#default-Modal' data-id='".$query->id."' data-photo='".$query->photo."' data-active='".$query->active."'>"._i('Edit')."</a>";
                    $html .= "<a href id='btn-delete-blog-cat' class='btn btn-danger btn-delete-job datatable-delete mr-1 ml-1' data-id='" . $query->id . "'>"._i('Delete')."</a>";

                    $langs = Language::get();
                    $options = '';
                    foreach ($langs as $lang) {
                        $name = $query->data_back?$query->data_back->where('lang_id', $lang->id)->first()?$query->data_back->where('lang_id', $lang->id)->first()->name: '': 'no data';
                        $description = $query->data_back?$query->data_back->where('lang_id', $lang->id)->first()?$query->data_back->where('lang_id', $lang->id)->first()->description: '': 'no data';
//                        dd($name, $description);
                        $options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-name="' . $name . '" data-desc="' . $description . '" data-id="' . $query->id . '" data-lang="' . $lang->id . '"
						style="display: block; padding: 5px 10px 10px;">' . $lang->title . '</a></li>';
                    }
                    $html = $html . '
					 <div class="btn-group">
					   <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" ' . _i('Translation') . ' ">
						 <span class="ti ti-settings"></span>
					   </button>
					   <ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >
						 ' . $options . '
					   </ul>
					 </div> ';
                    return $html;
                })
                ->addColumn('name', function ($query) {
                    return$query->data_back ? $query->data_back->where('lang_id', Lang::getSelectedLangId())->first()?$query->data_back->where('lang_id', Lang::getSelectedLangId())->first()->name :_i('There is no translation for this category') : '';
                })
//                ->addColumn('description', function ($query) {
//                    return $query->data_back ? $query->data_back->description : '';
//                })
//                ->addColumn('file', function ($query) {
//                    return $query->attachment ? $query->attachment->file : '';
//                })
//                ->addColumn('photo', function ($query) {
//                    return $query->photo;
//                })
                ->editColumn('photo', function($query) {
                    $image = asset($query->photo);
                    $html = '<img class="img-thumbnail" width=100 height=100 src="'.$image.'">';
//
                    return $html;
                })
                ->editColumn('created_at', function($query) {
                    return  Utility::dates($query->created_at);
                })
                ->rawColumns([
                    'name',
                    'photo',
                    'options',
                ])
                ->make(true);
        }
        return view('admin.blog_categories.index');
    }


    protected function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:255',
            'description' => 'required'
        ]);
        $image_in_db = '';
        if( $request->has('photo') )
        {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
            ]);

            $path = public_path().'/uploads/blogs_categories';
            $image = request('photo');
            $image_name = time().request('photo')->getClientOriginalName();
            $image->move($path , $image_name);
            $image_in_db = '/uploads/blogs_categories/'.$image_name;
        }
        $blog_category = BlogCategory::query()->create([
            'active' => $request->active,
            'photo' => $image_in_db,
        ]);
        BlogCategoryData::create([
            'blog_id' => $blog_category->id,
            'lang_id' => Lang::getSelectedLangId(),
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json('success');
    }

    protected function edit($id)
    {
        $blog_category = BlogCategory::find($id);
        if ($blog_category->image) {
            $blog_category->image = asset($blog_category->image);
        }
        return $blog_category;
    }

    protected function update(Request $request)
    {
        if( $request->has('photo') )
        {
            $request->validate([
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
            ]);

            $path = public_path().'/uploads/blogs_categories';
            $image = request('photo');
            $image_name = time().request('photo')->getClientOriginalName();
            $image->move($path , $image_name);
            $image_in_db = '/uploads/blogs_categories/'.$image_name;
        }else
        {
            $image_in_db = BlogCategory::query()->find($request->id)->photo;
        }
        BlogCategory::query()->find($request->id)->update([
            'active' => $request->active == 'on'? 1 : 0,
            'photo' => $image_in_db,
        ]);
        return response()->json('success');
    }

    protected function store_attach(Request $request)
    {
        $file_in_db = '';
        if (request()->has('file'))
        {
            request()->validate([
                'file' => 'required|mimes:jpeg,png,jpg,gif,svg,webp,csv,txt,xlx,xls,pdf,docx|max:4096',
            ]);
            $path = public_path() . '/uploads/blogs_categories/attachments/'.$request->blog_cat_id;
            $file = request('file');
            $file_name = time() . request('file')->getClientOriginalName();
            $file->move($path, $file_name);
            $file_in_db = '/uploads/blogs_categories/attachments/'. $request->blog_cat_id . '/'  . $file_name;
        }
        $blog_category = BlogCategory::query()->find($request->blog_cat_id);
        $blog_category->attachment()->updateOrCreate([
            'blog_id' => $request->blog_cat_id
        ], [
            'file' => $file_in_db,
        ]);
        return response()->json('success');
    }

    protected function delete($id)
    {
        BlogCategoryData::query()->where('blog_id', $id)->delete();
        BlogCategory::query()->find($id)->delete();
    }

    protected function getTranslation(Request $request)
    {
        $rowData = BlogCategoryData::where('blog_id', $request->transRow)
            ->where('lang_id', $request->lang_id)
            ->first(['name', 'description']);
        if (!empty($rowData)) {
            return response()->json(['data' => $rowData]);
        } else {
            return response()->json(['data' => false]);
        }
    }

    protected function storeTranslation(Request $request)
    {
        $rowData = BlogCategoryData::where('blog_id', $request->id)
            ->where('lang_id', $request->lang_id)
            ->first();
        if ($rowData != null) {
            $rowData->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
        } else {
            BlogCategoryData::create([
                'name' => $request->name,
                'description' => $request->description,
                'lang_id' => $request->lang_id,
                'blog_id' => $request->id,
            ]);
        }
        return response()->json("SUCCESS");
    }
}
