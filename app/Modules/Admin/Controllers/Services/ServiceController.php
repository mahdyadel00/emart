<?php

namespace App\Modules\Admin\Controllers\Services;

use App\Bll\Lang;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Modules\Admin\Models\Services\ServiceAttachment;
use App\Modules\Admin\Models\Services\ServicesData;
use Illuminate\Http\Request;
use App\Modules\Admin\Models\Services\Services;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ServiceController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $template = Services::join('services_data', 'services.id', 'services_data.service_id')
                ->where('services_data.lang_id' , Lang::getSelectedLangId())
                ->select('services.id', 'services_data.title', 'services.image', 'services.status', 'services.created_at')
                ->get();
            return DataTables::of($template)
                ->editColumn('options', function($query) {
                    $html  = "<a href='#' class='btn waves-effect waves-light btn-primary text-center add-attach mr-1 ml-1' data-id='".$query->id."' data-toggle='modal' data-target='#default-Modal-create'>"._i('Attachments')."</a>";
                    $html .= "<a href='#' class='btn waves-effect waves-light btn-success text-center edit-row mr-1 ml-1' data-toggle='modal' data-target='#default-Modal' data-id='".$query->id."' data-url='".route('service.edit', $query->id)."'>"._i('Edit')."</a>";
                    $html .= "<a href='#' class='btn btn-danger btn-delete datatable-delete mr-1 ml-1' data-id='".$query->id."' data-url='".route('service.delete', $query->id)."'>"._i('Delete')."</a>";

                    $langs = Language::get();
                    $options = '';
                    foreach ($langs as $lang) {
                        $options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="'.$query->id.'" data-lang="'.$lang->id.'"
						style="display: block; padding: 5px 10px 10px;">'.$lang->title.'</a></li>';
                    }
                    $html = $html.'
					 <div class="btn-group">
					   <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" '._i('Translation').' ">
						 <span class="ti ti-settings"></span>
					   </button>
					   <ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >
						 '.$options.'
					   </ul>
					 </div> ';
                    return $html;
                })->editColumn('image', function($query) {
                    $image = asset($query->image);
                    $html = "<img class='img-thumbnail' width=100 height=100 src=".$image.">";
                    return $html;
                })->editColumn('status', function($query) {
                    if ($query->status == 0){
                        return '<div class="badge badge-warning">'. _i('Disabled') .'</div>';
                    }else {
                        return '<div class="badge badge-info">'. _i('Enabled') .'</div>';
                    }
                })->editColumn('created_at', function($query) {
                        return  $query->created_at->format('d M Y - H:i');
                })

                ->rawColumns([
                    'options',
                    'image',
                    'status',
                    'created_at'
                ])
                ->make(true);
        }
        return view('admin.services.index');
    }

    public function edit( $id )
    {
        $service = Services::find($id);
        $service->image = asset($service->image);
        return $service;
    }

    public function store( Request $request )
    {
       // dd($request->all());
        if($request->status) {
            $request->status = 1;
        } else {
            $request->status = 0;
        }

        $image_in_db = NULL;
        if( $request->has('image') )
        {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
            ]);

            $path = public_path().'/uploads/services';
            $image = request('image');
            $image_name = time().request('image')->getClientOriginalName();
            $image->move($path , $image_name);
            $image_in_db = '/uploads/services/'.$image_name;
        }

        $service = Services::create([
            'image' => $image_in_db,
            'status' => $request->status,
        ]);
        ServicesData::create([
            'service_id' => $service->id,
            'lang_id' => Lang::getSelectedLangId(),
            'title' => $request->title,
            'body' => $request->body,
        ]);
        return response()->json('success');
    }

    public function update(Request $request)
    {
        if($request->status) {
            $request->status = 1;
        } else {
            $request->status = 0;
        }
        $site_template = Services::where('id' , $request->id)->first();
        if(! $request->image) {
            $image_in_db = $site_template->image;
        } else {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp',
            ]);

            $image_path = public_path($site_template->image);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $path = public_path().'/uploads/services';
            $image = request('image');
            $image_name = time().request('image')->getClientOriginalName();
            $image->move($path , $image_name);
            $image_in_db = '/uploads/services/'.$image_name;
        }
        Services::where('id' , $request->id)->update([
            'image'	=> $image_in_db,
            'status' => $request->status
        ]);
        return response()->json('success');
    }
    public function store_attach(Request $request){
        $file_in_db = NULL;
        if( $request->has('file') )
        {
//            $request->validate([
//                'file' => 'mimes:jpg,jpeg,png,pdf,docx,webp|max:4096',
//            ]);

            $path = public_path().'/uploads/services/'.$request->service;
            $file = request('file');
            $file_name = time().request('file')->getClientOriginalName();
            $file->move($path , $file_name);
            $file_in_db = '/uploads/services/'.$request->service.'/'.$file_name;
        }

        ServiceAttachment::create([
            'file' => $file_in_db,
            'service_id' => $request->service,
        ]);
        return response()->json('success');
    }
    public function delete($id)
    {
       // dd($id);
        $service = Services::where('id', $id)->first();
        $get_image_name = $service->image;
        $image_path = public_path($get_image_name);
        if(File::exists($image_path)) {
            File::delete($image_path);
        }
        $service->delete();
        ServicesData::where('service_id' , $id)->delete();
        return response()->json('success');

    }

    public function getTranslation(Request $request)
    {
        $rowData = ServicesData::where('service_id', $request->transRow)
            ->where('lang_id', $request->lang_id)
            ->first(['title' , 'body']);
        if (!empty($rowData)){
            return response()->json(['data' => $rowData]);
        }else{
            return response()->json(['data' => false]);
        }
    }

    public function storeTranslation(Request $request)
    {
        $rowData = ServicesData::where('service_id', $request->id)
            ->where('lang_id' , $request->lang_id)
            ->first();
        if ($rowData != null) {
            $rowData->update([
                'title' => $request->title,
                'body' => $request->body,
            ]);
        }else{
            ServicesData::create([
                'title'  => $request->title,
                'body'   => $request->body,
                'lang_id' => $request->lang_id,
                'service_id' => $request->id,
            ]);
        }
        return response()->json("SUCCESS");
    }
}
