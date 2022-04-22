<?php

namespace App\Modules\Admin\Controllers\Product;

use App\Bll\DataTable;
use App\Bll\Lang;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Modules\Admin\Models\Products\Label;
use App\Modules\Admin\Models\Products\LabelData;
use App\Modules\Admin\Models\Products\ProductLabel;
use App\Modules\Admin\Models\Products\ProductLabelData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function request;
use function response;
use function view;


class LabelsController extends Controller
{
	public function save_detail(Request $request)
	{
		$lang_id = Language::where('id', '!=', Lang::getSelectedLangId())->first();

		// dd($request->all());
		$titles = $request->title;
		$details = $request->detail;
		$filters = $request->filter;
		$hide_filters = $request->hide_filter;

		foreach ($titles as $key => $value) {
			$label = ProductLabel::where('id', $key)->first();
			if ($label != null) {
				$label->update([
					'active' => $filters[$key][0] ?? 0,
				]);
				ProductLabelData::where('item_id', $key)
					->where('lang_id', Lang::getSelectedLangId())
					->update([
						'value' => $details[$key][0],
					]);
			}
		}
		if (isset($titles['new'])) {
			foreach ($titles['new'] as $key => $value) {
				// dd($value);
				$label = ProductLabel::query()->where('lable_id', $value)
					->where('product_id', $request->row_product_id)
					->first();
				// dd($label);
				if ($label == null) {
					$item = ProductLabel::query()->create([
						'product_id' => $request->row_product_id,
						'lable_id' => $value,
						'active' => $filters['new'][$key] ?? 0,
					]);
					ProductLabelData::query()->create([
						'item_id' => $item->id,
						'value' => $details['new'][$key],
						'lang_id' => Lang::getSelectedLangId(),
					]);
				}
			}
		}

		return json_encode('success');
	}

	public function store(Request $request)
	{
		// dd($request->all());
		if ($request->label != '') {
			$label = Label::create();
			$data = LabelData::create([
				'lable_id' => $label->id,
				'title' => $request->label,
				'lang_id' => Lang::getSelectedLangId(),
			]);
			// dd($data);
			$value = '';
		} else if ($request->value != '') {
			$value = $request->value;
			$data = '';
		} else {
			return response(null, 401);
		}

		return response()->json(['success' => 'label added successfully', 'label' => $data, 'value' => $value]);
	}

	// function fetch(Request $request)
	// {
	//     if ($request->get('term')) {
	//         $query = $request->get('term');

	//         $data = LabelData::where('title', 'LIKE', "{$query}%")->get();

	//         return  $data;
	//     }
	// }
	// function fetchDetail(Request $request)
	// {
	//     if ($request->get('term')) {
	//         $query = $request->get('term');

	//         $data = ProductLabelData::where('value', 'LIKE', "{$query}%")->get();
	//         return  $data;
	//     }
	// }

	public function get_detail(Request $request, $id)
	{
        $lang_id = Language::where('id', '!=', Lang::getSelectedLangId())->first();

        $rowsData = ProductLabel::with([
            'Data',
        ])
            ->where('product_id', $id)
            ->get();

        $labels = Label::with('data')->get();

        $labelsData = ProductLabel::with('Data')->get();

        $html = view('admin.products.products.includes.labels.ajax', compact('rowsData', 'lang_id', 'labels', 'labelsData'))->render();
        return json_encode($html);
	}


	public function delete_detail(Request $request)
	{

		$rowsData = ProductLabel::where('product_id', $request->product_id)->where('id', $request->id)->first();
		if ($rowsData) {
			$data = ProductLabelData::where('item_id', $rowsData->id)->delete();
			$rowsData->delete();
		}

		return json_encode('success');
	}

	public function getTranslateDetail(Request $request)
	{
		/*

select t.* ,t2.value as trans_val ,t2.title as trans_title from (SELECT pld.value ,pld.lang_id,pld.item_id, lables_data.title from product_lables_data pld JOIN product_lables on product_lables.id= pld.item_id join lables_data on lables_data.lable_id =product_lables.lable_id and lables_data.lang_id=2 and lables_data.lang_id=pld.lang_id) as t left join (SELECT product_lables_data.value , lables_data.title , product_lables_data.item_id from product_lables_data JOIN product_lables on product_lables.id= product_lables_data.item_id join lables_data on lables_data.lable_id =product_lables.lable_id and lables_data.lang_id=1 and lables_data.lang_id=product_lables_data.lang_id) as t2 on t.item_id=t2.item_id;
*/


		$join = "leftJoinSub";

		$target_lang = Lang::getSelectedLangId(); //1;
		if ($target_lang == 2) {
			$src_lang = 1;
			$join = "leftJoinSub";
		} else {
			$src_lang = 2;
		//	$join = "rightJoinSub";
		}

		/*
		select DISTINCT t.* ,t2.value as trans_val ,t2.title as trans_title from (SELECT pld.value, product_lables.lable_id,pld.lang_id,pld.item_id, lables_data.title from product_lables_data pld JOIN product_lables on product_lables.id= pld.item_id join lables_data on lables_data.lable_id =product_lables.lable_id and lables_data.lang_id=2 and lables_data.lang_id=pld.lang_id) as t left join (SELECT product_lables_data.value,product_lables.lable_id , lables_data.title , product_lables_data.item_id from product_lables_data JOIN product_lables on product_lables.id= product_lables_data.item_id join lables_data on lables_data.lable_id =product_lables.lable_id and lables_data.lang_id=1 and lables_data.lang_id=product_lables_data.lang_id) as t2 on t.lable_id=t2.lable_id;
*/


		// select distinct `t`.*, `t2`.`value` as `trans_val`, `t2`.`title` as `trans_title` from (select `pld`.`value`, `pld`.`lang_id`, `pld`.`item_id`, `lables_data`.`title`, `product_lables`.`lable_id` from `product_lables_data` as `pld` inner join `product_lables` on `product_lables`.`id` = `pld`.`item_id` inner join `lables_data` on `lables_data`.`lable_id` = `product_lables`.`lable_id` and `lables_data`.`lang_id` = 1 and `lables_data`.`lang_id` = `pld`.`lang_id`) as `t` right join (select `product_lables_data`.`value`, `lables_data`.`title`, `product_lables_data`.`item_id`, `product_lables`.`lable_id` from `product_lables_data` inner join `product_lables` on `product_lables`.`id` = `product_lables_data`.`item_id` inner join `lables_data` on `lables_data`.`lable_id` = `product_lables`.`lable_id` and `lables_data`.`lang_id` = 2 and `lables_data`.`lang_id` = `product_lables_data`.`lang_id`) as `t2` on `t`.`lable_id` = `t2`.`lable_id`

		$subT = DB::table('product_lables_data as pld')
			->join('product_lables', "product_lables.id", "=", "pld.item_id")
			->join("lables_data", function ($join) use ($target_lang) {
				$join->on("lables_data.lable_id", "=", "product_lables.lable_id");
				$join->on("lables_data.lang_id", "=", DB::raw($target_lang));
				$join->on("lables_data.lang_id", "=", "pld.lang_id");
			})->select("pld.value", "pld.lang_id", "pld.item_id", "lables_data.title", "product_lables.lable_id","product_id");

		$subT2 = DB::table('product_lables_data')
			->join("product_lables", "product_lables.id", "=", "product_lables_data.item_id")
			->join("lables_data", function ($j) use ($src_lang) {
				$j->on("lables_data.lable_id", "=", "product_lables.lable_id")
					->on("lables_data.lang_id", "=", DB::raw($src_lang))
					->on("lables_data.lang_id", "=", "product_lables_data.lang_id");
			})->select("product_lables_data.value", "lables_data.title", "product_lables_data.item_id", "product_lables.lable_id");



		$res = DB::query()->fromSub($subT, 't')->$join($subT2, "t2", "t.item_id", "=", "t2.item_id")
			->select("t.*", "t2.value as trans_val", "t2.title as trans_title");

		$obj = clone $res;
		//	dd($res->get());
		$labels = $obj->whereNotNull("t2.title")->pluck("trans_title", "lable_id");
		//	dd($res->get(), $res->toSql(),$target_lang);

		//$labels = [];
		// dd($res);

		if (request()->ajax()) {
			$id = $request['id'];
			if ($id != null) {
				$res->where("product_id", $id);
			}
			$columns = ['t.item_id', 't.title', 't2.title', 't.value', 't2.value'];

			$dt = new DataTable($res);
			$dt->columns($columns);

			return $dt->response();
		}
		return view('admin.products.products.includes.translateDetail', compact("labels"));
	}

	public function storeTranslate(Request $request)
	{
		// dd($request->all());
		$lang_id = Language::where('id', '!=', Lang::getSelectedLangId())->first();

		$first = [];
		foreach ($request->value as $key => $value) {
			$rows = ProductLabel::where('id', $key)->first();
			if (!in_array($rows->lable_id, $first)) {
				LabelData::updateOrCreate([
					"lable_id" => $rows->lable_id,
					'lang_id' => $lang_id->id,
				], [
					'title' => $request->word[$key][0] ?? '',
				]);
				$first[] = $rows->lable_id;
			}

			ProductLabelData::updateOrCreate([
				"item_id" => $rows->id,
				'lang_id' => $lang_id->id,
			], [
				'value' => $value[0],
			]);
		}
		// }else{
		// foreach ($request->word as $key => $value){
		//     $rows = ProductLabel::where('lable_id',$key)->first();
		//     $LabelData = LabelData::where('lable_id',$key)->where('lang_id','!=', Lang::getSelectedLangId())->first();
		//     if($value[0] != null  ){
		//     if (isset($LabelData)){
		//         $LabelData->update([
		//             'title' => $value[0],
		//         ]);
		//     }else{
		//         LabelData::create([
		//             "lable_id" => $key,
		//             'title' => $value[0],
		//             'lang_id' => $lang_id->id,
		//         ]);
		//     }

		//     $ProductLabelData = ProductLabelData::where('item_id',$rows->id)->where('lang_id','!=', Lang::getSelectedLangId())->first();
		//     if (isset($ProductLabelData)) {

		//         $ProductLabelData->update([
		//             'value' => $value[1] ?? '',
		//         ]);
		//     }else{
		//         ProductLabelData::create([
		//             "item_id" => $rows->id,
		//             'value' => $value[1] ?? '',
		//             'lang_id' => $lang_id->id,
		//         ]);

		//     }
		// }

		// }
		// }

		return response()->json(['success']);
	}

	protected function syncTranslation(Request $request)
	{
		$other_lang = Language::where('id', '!=', Lang::getSelectedLangId())->first()->id;
		$originals = ProductLabelData::where('value', $request->original)->where('lang_id', Lang::getSelectedLangId())->get();
		$ids = $originals->pluck('item_id')->toArray();
		foreach ($ids as $item) {
			ProductLabelData::updateOrCreate([
				'item_id' => $item,
				'lang_id' => $other_lang
			], [
				'value' => $request->value
			]);
		}
		return response()->json(['success']);
	}
}
