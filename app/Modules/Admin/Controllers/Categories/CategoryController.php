<?php

namespace App\Modules\Admin\Controllers\Categories;

use App\Bll\Lang;
use App\Bll\Translate;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\CategoryData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use League\Flysystem\Exception;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    protected function index()
    {
        $category_tree = Category::select('categories.*')
            ->whereNull("parent_id")
            ->orderBy('number', 'asc')
            ->get();
        $languages = Language::all();
        //dd($categories);
        $cats = [];

        \App\Bll\Utility::getCategories($category_tree, $cats);
        $categories = Category::all();


        $items = Category::get()->toArray();
        $data = CategoryData::get()->toArray();
        $trans = new Translate($items, $data, Lang::getSelectedLangId());
        $categories = $trans->getData("category_id", ["lang_id"]);

        //	dd($categories);
        //	dd($category_tree,$cats);
        //dd($categories);

        return view('admin.categories.index', compact("categories", "cats", 'languages'));
    }


    protected function getCategories()
    {
        $categories = Category::select('categories.*', 'categories_data.title')
            ->join('categories_data', 'categories.id', 'categories_data.category_id')
            ->whereNull('parent_id')
            ->where('lang_id', Lang::getSelectedLangId())->get();
        return $categories;
    }


    //     modified to delete nested category
    protected function deleteCategory(Request $request, $id)
    {

        $category = Category::where('id', $id)->first();
        try {
            $category->delete();
            return \response()
                ->json(['msg' => _i("Deleted Successfully"), "status" => "ok"]);
        } catch (Exception $ex) {
            //dd(0);
            return \response()
                ->json(['msg' => $ex->getMessage(), "status" => "failed"]);
        }

        // if ($category) {
        // 	$data =  $category->flatten($category->grandchildren->toArray());
        // 	$cat_ids = [];
        // 	foreach ($data as $datum) {
        // 		$cat_ids[] = $datum['id'];
        // 	}
        // 	Category::whereIn('id', $cat_ids)->delete();
        // 	CategoryData::where('category_id', $id)->delete();
        // 	CategoryData::whereIn('category_id', $cat_ids)->delete();
        // 	$category->delete();
        // 	return \response()
        // 		->json(['flash_message' => _i("Deleted Successfully"), 'cat_ids' => $cat_ids]);
        // } else {
        // 	return redirect()->back()->with('flash_message', _i('Not Found !'));
        // }
    }

    protected function getTranslation(Request $request)
    {
        $rowData = CategoryData::where('category_id', $request->transRow)
            ->where('lang_id', $request->lang_id)
            ->first(['title', 'description', 'quality']);
        if (!empty($rowData)) {
            return Response::json(['data' => $rowData]);
        } else {
            return Response::json(['data' => false]);
        }
    }

    protected function storeTranslation(Request $request)
    {
        $rowData = CategoryData::where('category_id', $request->id)
            ->where('lang_id', $request->lang_id)
            ->first();
        if ($rowData != null) {
            $rowData->update([
                'title' => $request->title,
                'description' => $request->input('description'),
                'quality' => $request->input('quality'),
            ]);
        } else {
            $source = CategoryData::where('category_id', $request->id)
                ->where('lang_id', "!=", $request->lang_id)
                ->first();
            $attr = [
                'title' => $request->title,
                'description' => $request->input('description'),
                'quality' => $request->input('quality'),
                'lang_id' => $request->lang_id,
                'category_id' => $request->id
            ];
            if ($source != null) {
                $attr["source_id"] = $source->id;
            }
            CategoryData::create($attr);
        }
        return Response::json("SUCCESS");
    }

    protected function uploadImage(Request $request)
    {
        $id = $request->id;
        $category = Category::where('id', $id)->first();
        if ($request->hasFile("image")) {
            $request->validate([
                'image' => 'required|image',
            ]);

            $image = $request->file("image");
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/categories/' . $id), $filename);
            $category->image = '/uploads/categories/' . $id . '/' . $filename;
            $category->save();
            return response()->json('success');
        }
    }


    protected function createSingleV2(Request $request)
    {

        //	dd($request->all());
        //return $request->all() ;
        $this->validate($request, [
            'name' => 'required',
            'parent_id' => 'required',
            'number' => 'required',
            //			'file' => 'nullable|image'
        ]);
        //  parent_id , image , number
        $parent_id = $request->parent_id == 0 ? null : $request->parent_id;
        if ($request->type == 'new') {

            //        	return $parent_id ;
            $category = Category::create([

                'number' => $request->number,
                'parent_id' => $parent_id
            ]);
            // category data
            $category_data = CategoryData::create([

                'title' => $request->name,
                'category_id' => $category->id,
                'lang_id' => Lang::getSelectedLangId()
            ]);
            if ($request->hasFile('file')) {
                $image = $request->file('file');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $request->file->move(public_path('uploads/categories/' . $category->id), $filename);
                $category->image = '/uploads/categories/' . $category->id . '/' . $filename;
                $category->save();
            }

            return response()->json(['status' => 'success', 'message' => 'added successfuly', 'category' => $category]);
        } else {
            $category = Category::find($request->type);
            $category->number = $request->number;
            $category->parent_id = $parent_id;
            $category->save();
            $category_data = CategoryData::updateOrCreate([

                'category_id' => $category->id,
                'lang_id' => Lang::getSelectedLangId()
            ], [
                'title' => $request->name
            ]);

            if ($request->hasFile('file')) {
                $category->image ? is_file($category->image) ? unlink($category->image) : '' : '';
                $image = $request->file('file');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $request->file->move(public_path('uploads/categories/' . $category->id), $filename);
                $category->image = '/uploads/categories/' . $category->id . '/' . $filename;
                $category->save();
            }
            return response()->json(['status' => 'success', 'message' => 'saved successfuly', 'category' => $category]);
        }
    }

    protected function updateOrder(Request $request)
    {

        // dd($request->data);
        $categories = [];
        foreach ($request->data as $datum) {
            $category = Category::find($datum[1]);
            $category ? $category->update(['number' => $datum[0]]) : '';
            $categories[] = Category::find($datum[1]);
        }
        return $categories;
    }

    protected function features($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.features', compact('category'));
    }

    protected function featuresPost(Request $request)
    {
        $file_in_db = NULL;
        if ($request->has('file')) {
            $request->validate([
                'file' => 'required|max:4096',
            ]);
            $path = public_path() . '/uploads/categories/'.$request->category_id;
            $file = request('file');
            $file_name = time() . request('file')->getClientOriginalName();
            $file->move($path, $file_name);
            $file_in_db = '/uploads/categories/'. $request->category_id . '/'  . $file_name;
        }
        $category = Category::find($request->category_id);
        $category->feature()->updateOrCreate([
            'category_id' => $request->category_id
        ], [
            'file' => $file_in_db,
        ]);
        session()->flash('success', 'uploaded Successfully');
        return redirect()->route('category.features', $category->id);
    }
}
