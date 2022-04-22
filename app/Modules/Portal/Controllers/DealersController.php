<?php

namespace App\Modules\Portal\Controllers;

use App\Bll\Lang;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Settings\City;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DealersController extends Controller
{

    public function index(Request $request)
    {

        $locations = City::leftJoin('city_data', 'city_data.city_id', 'cities.id')
            ->where('city_data.lang_id', Lang::getSelectedLangId())->where('active', 1)
            ->select('cities.id', 'city_data.name as city', 'cities.lat', 'cities.lng')
            ->get();

        if(request()->ajax()) {
            $selectedCity = $locations->where('id',$request->cityid)->first();
            $selectedLat = $selectedCity->lat;
            $selectedlang = $selectedCity->lng;
            return response()->json(['data' => $selectedCity]);
        }

        if($request->city_id != null){
            $selectedCity = $locations->where('id',$request->city_id)->first();
            $selectedLat = $selectedCity->lat;
            $selectedlang = $selectedCity->lng;
        }else{
            $selectedLat = 24.65;
            $selectedlang = 46.71;
        }
        return view('site.dealers.index', compact('locations', 'selectedLat', 'selectedlang'));
    }




    public function singleFlier(Request $request){


        $now = Carbon::now()->format('Y-m-d\TH:i:sO');


        $flier = StoreFlier::join('store_fliers_data','store_fliers_data.flier_id','store_fliers.id')
            ->select('store_fliers.*','store_fliers_data.name')
            // ->where('store_fliers.start_date','<=',Carbon::now())
            // ->where('store_fliers.end_date','>=',Carbon::now())
            //->where('store_fliers.end_date','>=',Carbon::now())

            ->where(DB::raw(date("Y-m-d\TH:i:sO", strtotime('store_fliers.start_date'))), '<=' ,$now)
            //->where(date("Y-m-d\TH:i:sO",strtotime('store_fliers.start_date')),'<=', $now)
            //->where('store_fliers_data.lang_id',request()->header('lang'))
            ->where('store_fliers.id',$request->id)
            ->first();

        if($flier != null){
            $startDate = date("Y-m-d\TH:i:sO", strtotime($flier->start_date));
            $endDate = date("Y-m-d\TH:i:sO", strtotime($flier->end_date));

            $flier = $flier->where($startDate , '<=' ,$now)->where($endDate,'>=',$now);
        }else{
            return response()->json(['status'=>'success','data'=>[]]);
        }


        if(!$flier &&  request()->header('lang') != 1){

            $flier = StoreFlier::join('store_fliers_data','store_fliers_data.flier_id','store_fliers.id')
                ->select('store_fliers.*','store_fliers_data.name')
                ->where('store_fliers.start_date','<=',Carbon::now())
                ->where('store_fliers.end_date','>=',Carbon::now())
                ->where('store_fliers_data.lang_id',1)
                ->where('store_fliers.id',$request->id)
                ->first();

        }elseif (!$flier &&  request()->header('lang') != 2){


            $flier = StoreFlier::join('store_fliers_data','store_fliers_data.flier_id','store_fliers.id')
                ->select('store_fliers.*','store_fliers_data.name')
                ->where('store_fliers.start_date','<=',Carbon::now())
                ->where('store_fliers.end_date','>=',Carbon::now())
                ->where('store_fliers_data.lang_id',2)
                ->where('store_fliers.id',$request->id)
                ->first();

        }



        if($flier){
            if (Auth()->guard('api')->check()) {

                $favourite = AllFavourite::where('user_id',Auth()->guard('api')->user()->id)->where('flier_id',$flier->id)->first();


                if(isset($favourite)){
                    $flier->is_favourite = 1;
                }else{
                    $flier->is_favourite = 0;
                }
            }



            $images = StoreFlierImage::where('flier_id',$flier->id)->get('image');
            foreach ($images as $image){
                $image->img = url($image->image);
            }

            $flier->images = $images;

            $flier->flier_image = url($flier->image);

            $flier->increment('view_count',1);


            return response()->json(['status'=>'success','data'=>$flier]);
        }else{
            return response()->json(['status'=>'success','data'=>[]]);
        }


    }

}
