<?php

namespace App\Modules\Admin\Controllers\Blogs;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Models\Blog\Blog;
use App\Models\Blog\BlogCategoryData;
use App\Models\Blog\BlogData;
use App\Models\Language;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BlogController extends Controller
{
    protected function index()
    {
        $blogs = Blog::with(['data_back', 'attachment'])->get();
        $categories = BlogCategoryData::query()->where('lang_id', Lang::getSelectedLangId())->get();
        if (request()->ajax()) {
            return DataTables::of($blogs)
                ->editColumn('options', function ($query) {
//                    $html = "<a href='#' class='btn waves-effect waves-light btn-primary text-center add-attach mr-1 ml-1' data-id='" . $query->id . "' data-toggle='modal' data-target='#default-Modal-create'>" . _i('Attachments') . "</a>";
                    $html = "<a href='#' class='btn waves-effect waves-light btn-success text-center edit-row mr-1 ml-1' data-toggle='modal' data-target='#default-Modal'"
                        . " data-category='" . $query->blog_category_id . "' data-id='" . $query->id . "' data-image='" . asset($query->image) . "' data-status='" . $query->status . "'>" . _i('Edit') . "</a>";
                    $html .= "<a href id='btn-delete-blog' class='btn btn-danger btn-delete-job datatable-delete mr-1 ml-1' data-id='" . $query->id . "'>" . _i('Delete') . "</a>";

                    $langs = Language::get();
                    $options = '';
                    foreach ($langs as $lang) {
                        $title = $query->data_back?$query->data_back->where('lang_id', $lang->id)->first()?$query->data_back->where('lang_id', $lang->id)->first()->title: '': 'no data';
                        $content = $query->data_back?$query->data_back->where('lang_id', $lang->id)->first()?$query->data_back->where('lang_id', $lang->id)->first()->content: '': 'no data';
                        $options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-title="' . $title . '" data-content="' . $content . '" data-id="' . $query->id . '" data-lang="' . $lang->id . '"
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
                ->addColumn('title', function ($query) {
                    return $query->data_back ? $query->data_back->where('lang_id', Lang::getSelectedLangId())->first() ? $query->data_back->where('lang_id', Lang::getSelectedLangId())->first()->title : _i('There is no translation for this blog') : '';
                })
                ->addColumn('category', function ($query) {
                    $blog_category = BlogCategoryData::query()
                        ->where('blog_id', $query->blog_category_id)->where('lang_id', Lang::getSelectedLangId())->first();
                    return $blog_category ? $blog_category->name : 'not translated yet';
                })
//                ->addColumn('image', function ($query) {
//                    return $query->image;
//                })
                ->editColumn('image', function ($query) {
                    $image = asset($query->image);
                    $html = "<img class='img-thumbnail' width=100 height=100 src=" . $image . ">";
                    return $html;
                })
                ->editColumn('created_at', function ($query) {
                    return Utility::dates($query->created_at);
                })
                ->editColumn('updated_at', function ($query) {
                    return Utility::dates($query->updated_at);
                })
                ->rawColumns([
                    'created_at',
//                    'updated_at',
                    'title',
                    'image',
                    'category',
                    'options',
                ])
                ->make(true);
        }
        return view('admin.blogs.index', compact('categories'));
    }


    protected function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'image'
        ]);
        $image_in_db = '';
        if ($request->has('image')) {
            $request->validate([
//                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',

            ]);

            $path = public_path() . '/uploads/blogs';
            $image = request('image');
            $image_name = time() . request('image')->getClientOriginalName();
            $image->move($path, $image_name);
            $image_in_db = '/uploads/blogs/' . $image_name;
        }
        $blog = Blog::query()->create([
            'status' => $request->status ? 1 : 0,
            'image' => $image_in_db,
            'blog_category_id' => $request->category_id
        ]);
        BlogData::query()->create([
            'blog_id' => $blog->id,
            'lang_id' => Lang::getSelectedLangId(),
            'blog_category_id' => $request->category_id,
            'title' => $request->title,
            'content' => $request->input(['content']),
        ]);
        return response()->json('success');
    }

    protected function edit($id)
    {
        $blog = Blog::find($id);
        if ($blog->image) {
            $blog->image = asset($blog->image);
        }
        return $blog;
    }

    protected function update(Request $request)
    {
        if ($request->has('image')) {
            $request->validate([
                'image' => 'image|mimes:jpeg,png,jpg,gif,svg,webp',
            ]);

            $path = public_path() . '/uploads/blogs';
            $image = request('image');
            $image_name = time() . request('image')->getClientOriginalName();
            $image->move($path, $image_name);
            $image_in_db = '/uploads/blogs/' . $image_name;
        } else {
            $image_in_db = Blog::query()->find($request->id)->image;
        }
        Blog::query()->find($request->id)->update([
            'status' => $request->status ? 1 : 0,
            'image' => $image_in_db,
            'blog_category_id' => $request->category_id
        ]);
        return response()->json('success');
    }

    protected function store_attach(Request $request)
    {
        $file_in_db = '';
        if (request()->has('file')) {
            request()->validate([
                'file' => 'required|mimes:jpeg,png,jpg,gif,svg,webp,csv,txt,xlx,xls,pdf,docx|max:4096',
            ]);
            $path = public_path() . '/uploads/blogs/attachments/' . $request->blog_id;
            $file = request('file');
            $file_name = time() . request('file')->getClientOriginalName();
            $file->move($path, $file_name);
            $file_in_db = '/uploads/blogs/attachments/' . $request->blog_id . '/' . $file_name;
        }
        $blog_category = Blog::query()->find($request->blog_id);
        $blog_category->attachment()->updateOrCreate([
            'blog_id' => $request->blog_id
        ], [
            'file' => $file_in_db,
        ]);
        return response()->json('success');
    }

    protected function delete($id)
    {
        BlogData::query()->where('blog_id', $id)->delete();
        Blog::query()->find($id)->delete();
    }

    protected function getTranslation(Request $request)
    {
        $rowData = BlogData::where('blog_id', $request->transRow)
            ->where('lang_id', $request->lang_id)
            ->first(['title', 'content']);
        if (!empty($rowData)) {
            return response()->json(['data' => $rowData]);
        } else {
            return response()->json(['data' => false]);
        }
    }

    protected function storeTranslation(Request $request)
    {
        $rowData = BlogData::where('blog_id', $request->id)
            ->where('lang_id', $request->lang_id)
            ->first();
        if ($rowData != null) {
            $rowData->update([
                'title' => $request->name,
                'content' => $request->description,
            ]);
        } else {
            BlogData::create([
                'title' => $request->name,
                'content' => $request->description,
                'lang_id' => $request->lang_id,
                'blog_id' => $request->id,
            ]);
        }
        return response()->json("SUCCESS");
    }
}
