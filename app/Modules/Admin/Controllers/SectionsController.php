<?php

namespace App\Modules\Admin\Controllers;

use Exception;

use App\Bll\Lang;
use App\Bll\Site;
use App\Bll\Utility;
use App\Models\Language;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Modules\Admin\Models\Section;
use App\Modules\Admin\Models\SectionData;
use App\Modules\Admin\Models\CategoryMaster;
use App\Modules\Admin\Models\Settings\Banner;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Services\Services;
use App\Modules\Admin\Models\Products\CategoryData;
use App\Modules\Admin\Models\Settings\SuccessPartner;
use App\Modules\Admin\Models\Products\product_details;
use App\Modules\Admin\Models\Products\category_product;
use App\Modules\Admin\Models\SectionProducts;
use Yajra\DataTables\Facades\DataTables;


class SectionsController extends Controller
{
	public function index($section)
	{
		if (request()->ajax()) {

			$query = Section::leftJoin('sections_data', 'sections_data.section_id', 'sections.id')
				->select('sections.*', 'sections_data.title as title', 'sections_data.description', 'sections_data.lang_id')
				->where('sections_data.lang_id',Lang::getSelectedLangId())->get();

			if ($section == 'home_sections') :
				$query = $query->where('sections.page', 'home');
			elseif ($section == 'categories_sections') :
				$query = $query->where('sections.page', 'categories');
			endif;


			return DataTables::of($query)
				->editColumn('published', function ($query) {
					if ($query->published == 0) {
						return '<div class="badge badge-warning">' . _i('Not Publish') . '</div>';
					} else {
						return '<div class="badge badge-info">' . _i('Published') . '</div>';
					}
				})
				->addColumn('master', function ($query) {

					$master =	CategoryMaster::where('section_id', $query->id)->first();
					if ($master != null) {
						$cat =	$master->category->title;
					}
					return $cat ?? '';
				})
				// ->addColumn('created_at', function($query){
				// 	return $query->creared_at;
				// })
				->addColumn('action', function ($query) {
					$master =	CategoryMaster::where('section_id', $query->id)->first();

					$categories = $query->categories->pluck('id')->toJson();
					$banners = $query->banners->pluck('id')->toJson();
					$services = $query->services->pluck('id')->toJson();
					$partners = $query->partners->pluck('id')->toJson();

					if ($master != null) {
						$html = '<a href ="'.route('settings.sections.edit',$query->id).'"
						class="btn waves-effect waves-light btn-primary edit text-center" title="' . _i("Edit") . '"
						data-id="' . $query->id . '" data-title="' . $query->title . '" data-type="' . $query->type . '" . data-master ="' .  $master->category_id  . '".
						data-lang_id="' . $query->lang_id . '" data-total="' . $query->total . '" data-display_order="' . $query->display_order . '" data-published="' . $query->published . '" data-image="' . $query->image . '" data-video="' . $query->video . '" data-categories="' . $categories . '" data-banners="' . $banners . '" data-services="' . $services . '" data-partners="' . $partners . '" data-is_title_displayed="' . $query->is_title_displayed . '" ><i class="ti-pencil-alt"></i></a>  &nbsp;' . '
					<form class=" delete"  action="' . route("section.destroy", $query->id) . '"  method="POST" id="delform"
					style="display: inline-block; right: 50px;" >
					<input name="_method" type="hidden" value="DELETE">
					<input type="hidden" name="_token" value="' . csrf_token() . '">
					<button type="submit" class="btn btn-danger" title=" ' . _i('Delete') . ' "> <span> <i class="ti-trash"></i></span></button>
					 </form>
					</div>';
					} else {
						$html = '<a href ="'.route('settings.sections.edit',$query->id).'"
						class="btn waves-effect waves-light btn-primary edit text-center" title="' . _i("Edit") . '"
						data-id="' . $query->id . '" data-title="' . $query->title . '"  data-type="' . $query->type . '"  .
						data-lang_id="' . $query->lang_id . '" data-total="' . $query->total . '" data-display_order="' . $query->display_order . '" data-published="' . $query->published . '" data-image="' . $query->image . '" data-video="' . $query->video . '" data-categories="' . $categories . '" data-banners="' . $banners . '" data-services="' . $services . '" data-partners="' . $partners . '" data-is_title_displayed="' . $query->is_title_displayed . '"><i class="ti-pencil-alt"></i></a>  &nbsp;' . '
					<form class=" delete"  action="' . route("section.destroy", $query->id) . '"  method="POST" id="delform"
					style="display: inline-block; right: 50px;" >
					<input name="_method" type="hidden" value="DELETE">
					<input type="hidden" name="_token" value="' . csrf_token() . '">
					<button type="submit" class="btn btn-danger" title=" ' . _i('Delete') . ' "> <span> <i class="ti-trash"></i></span></button>
					 </form>
					</div>';
					}

					$langs = Language::get();
					$options = '';
					foreach ($langs as $lang) {
						$options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="' . $query->id . '" data-lang="' . $lang->id . '"
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
                ->editColumn('created_at', function($query) {
                    return  $query->created_at->format('d M Y - H:i');
                })->editColumn('image', function($query) {
                    if($query->image == null){
                        $image = asset('/images/placeholder.png');
                    }else{
                        $image = asset($query->image);
                    }
                    $html = "<img class='img-thumbnail' width=100 height=100 src=".$image.">";
                    return $html;
                })
				->rawColumns([
					'action',
					'published',
					'master',
					 'created_at'
				])
				->make(true);
		}

		$languages = Language::get();
		$page_section = $section == 'home_sections' ? 'home_sections' : 'categories';
		return view('admin.sections.' . $section . '.index', compact('languages','page_section'));
	}

    protected function mobileSection(){

           $section =  Section::with('translation')->where('page' , 'mobile')->get();

            return view('admin.sections.mobile_sections.index' ,  compact('section'));

    }

    public function create(Request $request){
       // dd(1);
        $query = Category::select('categories.*', 'title')
           ->join('categories_data', 'categories.id', 'categories_data.category_id')
           ->where('lang_id', Lang::getSelectedLangId())
           ->orderBy('number', 'asc')
           ->get();

       $categories = [];
       //Utility::getCategories($query, $categories);

       return view('admin.sections.create',compact('categories'));

   }
   public function edit($id){

    $section = Section::with('sectionProducts.detailes')->find($id);
    return view('admin.sections.edit',compact( 'section'));
   }


	public function store(Request $request, $section=null)
	{

		 //dd($request->all());
		if (isset($request->video)) {
			$video = str_replace("watch?v=", "/embed//", $request->video);
		}


			$section = Section::create([

				'is_title_displayed' => $request->is_title_displayed ?? 0,
				'type' => $request->type,
				'total' => $request->total ?? null,
				'display_order' => $request->display_order ?? 0,
				'published' => $request->published ?? 0,
				'page'	=> 'home',
				'video' => $video ?? null,
			]);
			$section_data = SectionData::create([

				'section_id' => $section->id,
				'title' => $request->title,
				'description' => $request->description,
				'lang_id' => Lang::getSelectedLangId()
			]);

        $section->sectionProducts()->attach($request->products);
		if ($request->hasFile('image')) {
			$request->validate([
				'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
			]);

			$image = $request->file('image');
			$filename = time() . '.' . $image->getClientOriginalExtension();
			$request->image->move(public_path('uploads/sections/' . $section->id), $filename);
			$section->image = '/uploads/sections/' . $section->id . '/' . $filename;
			$section->save();
		}


		return response()->json("SUCCESS");
	}

	public function update(Request $request)
	{
		// dd($request->all());
		 if (isset($request->video)) {
			$video = str_replace("watch?v=", "/embed//", $request->video);
		}
		$section = Section::where('id', $request->section_id)->first();
		$section->update([

			'is_title_displayed' => $request->is_title_displayed ?? 0,
			'total' => $request->total,
			'display_order' => $request->display_order,
			'published' => $request->published ?? 0,
			'video' => $video ?? null
		]);
        if($request->products != null){
			SectionProducts::where('section_id',$section->id)->delete();
            $section->sectionProducts()->attach($request->products);
		}

		if ($request->hasFile('image')) {
			$request->validate([
				'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
			]);

			$image = $request->file('image');
			if (File::exists(public_path($section->image))) {
				File::delete(public_path($section->image));
			}
			$filename = time() . '.' . $image->getClientOriginalExtension();
			$request->image->move(public_path('uploads/sections/' . $section->id), $filename);
			$section->image = '/uploads/sections/' . $section->id . '/' . $filename;
			$section->save();
		}
		if ($request->hasFile('video')) {
			$request->validate([
				'video' => 'required|mimes:mp4',
			]);

			$video = $request->file('video');
			if (File::exists(public_path($section->video))) {
				File::delete(public_path($section->video));
			}
			$filename = time() . '.' . $video->getClientOriginalExtension();
			$request->video->move(public_path('uploads/sections/' . $section->id), $filename);
			$section->video = '/uploads/sections/' . $section->id . '/' . $filename;
			$section->save();
		}
		return response()->json("SUCCESS");
	}

	public function getLangValue(Request $request)
	{
		$rowData = SectionData::where('section_id', $request->id)
			->where('lang_id', $request->lang_id)
			->first(['title', 'description']);
		if (!empty($rowData)) {
			return response()->json(['data' => $rowData]);
		} else {
			return response()->json(['data' => false]);
		}
	}
	public function autocomplete(Request $request)
	{
 		$products = [];
		if ($request->has('q')) {

		    $search = $request->q;
 			// $products = product_details::select("product_id","title")
			// ->where('title','LIKE',"%$search%")
			// ->get();

			$products = product_details::select('product_details.product_id', 'product_details.title', "categories_data.title as cat")
			->leftJoin('categories_products', 'categories_products.product_id', 'product_details.product_id')
			->leftJoin('categories_data', 'categories_products.category_id', 'categories_data.category_id')
            ->where('product_details.lang_id', Lang::getSelectedLangId())
			->where('categories_data.lang_id', Lang::getSelectedLangId())
 			->where('product_details.title','LIKE',"%$search%")

			->get();
            $products->groupBy('product_details.product_id');

		}
		if (!empty($products)) {
			return response()->json( $products) ;
		} else {
			return response()->json(['data' => false]) ;
		}
	}

	public function storelangTranslation(Request $request)
	{
		$lang_id = Lang::getSelectedLangId();
		$rowData = SectionData::where('section_id', $request->id)
			->where('lang_id', $request->lang_id_data)
			->first();
		if ($rowData !== null) {
			$rowData->update([
				'title' => $request->title,
				'description' => $request->description1,
			]);
		} else {
			$parentRow = SectionData::where('section_id', $request->id)->where('lang_id', $lang_id)->first();
			SectionData::create([

				'title' => $request->title,
				'description' => $request->description1,
				'lang_id' => $request->lang_id_data,
				'section_id' => $request->id,
			]);
		}
		return response()->json("SUCCESS");
	}

	public function delete($id)
	{
		$section = Section::where('id', $id)->first();
		if (File::exists(public_path($section->image))) {
			File::delete(public_path($section->image));
		}
		$section_data = SectionData::where('section_id', $section->id)->delete();
		$section->categories()->detach();
		CategoryMaster::where('section_id', $id)->delete();
		$section->delete();
		return response(["data" => true]);
	}
}
