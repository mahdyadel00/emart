<?php

namespace App\Modules\Admin\Controllers\Jobs;

use App\Bll\Lang;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Modules\Portal\Models\Job;
use App\Modules\Portal\Models\JobAttachment;
use App\Modules\Portal\Models\JobData;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\DataTables;

class JobsController extends Controller
{
    protected function index()
    {
        $jobs = Job::with(['data_back', 'attachment'])->get();
//        dd($jobs->first());
        if (request()->ajax()) {

            return DataTables::of($jobs)
                ->addColumn('options', function ($query) {
                    $html = "<a href='" . route('jobs.show', $query->id) . "' class='btn waves-effect waves-light btn-primary text-center mr-1 ml-1'>" . _i('Details') . "</a>";
//                    $html .= "<a href='#' class='btn waves-effect waves-light btn-success text-center edit-row mr-1 ml-1' data-toggle='modal' data-target='#default-Modal' data-id='" . $query->id . "' data-title='" . $query->data_back->title . "' data-description='" . $query->data_back->description . "'>" . _i('Edit') . "</a>";
                    $html .= "<a href id='btn-delete-job' class='btn btn-danger btn-delete-job datatable-delete mr-1 ml-1' data-id='" . $query->id . "'>" . _i('Delete') . "</a>";


                    $langs = Language::get();
                    $options = '';
                    foreach ($langs as $lang) {
//                        dd($query->data_back?$query->data_back->where('lang_id', 1)->first()?$query->data_back->where('lang_id', 1)->first()->title: '': 'no data');
                        $title = $query->data_back?$query->data_back->where('lang_id', $lang->id)->first()?$query->data_back->where('lang_id', $lang->id)->first()->title: '': 'no data';
                        $description = $query->data_back?$query->data_back->where('lang_id', $lang->id)->first()?$query->data_back->where('lang_id', $lang->id)->first()->description: '': 'no data';
//                        dd($title, $description);
                        $options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-title="'.$title.'" data-description="'.$description.'" data-id="' . $query->id . '" data-lang="' . $lang->id . '"
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
                    return $query->data_back ? $query->data_back->where('lang_id', Lang::getSelectedLangId())->first()?$query->data_back->where('lang_id', Lang::getSelectedLangId())->first()->title :_i('There is no translation for this job') : '';
                })
//                ->addColumn('description', function ($query) {
//                    return $query->data_back ? $query->data_back->description : '';
//                })
                ->rawColumns([
                    'title',
//                    'description',
                    'options',
                ])
                ->make(true);
        }
        return view('admin.jobs.index');
    }

    protected function edit($id)
    {
        $job = Job::find($id);
        if ($job->image) {
            $job->image = asset($job->image);
        }
        return $job;
    }

    protected function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required'
        ]);
        $job = Job::query()->create([
            'date' => Carbon::today()
        ]);
        JobData::create([
            'job_id' => $job->id,
            'lang_id' => Lang::getSelectedLangId(),
            'title' => $request->title,
            'description' => $request->description,
        ]);
        return response()->json('success');
    }

    protected function update(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:255',
            'description' => 'required'
        ]);
        $job = Job::query()->find($request->id);
        JobData::query()->where('job_id', $job->id)->update([
            'title' => $request->title,
            'description' => $request->description
        ]);
        return response()->json('success');
    }

    protected function store_attach(Request $request)
    {
        $file_in_db = '';
        if (request()->has('file')) {
            request()->validate([
                'file' => 'required|mimes:png,jpg,jpeg,csv,txt,xlx,xls,pdf,docx|max:4096',
            ]);
            $path = public_path() . '/uploads/jobs/' . $request->job_id;
            $file = request('file');
            $file_name = time() . request('file')->getClientOriginalName();
            $file->move($path, $file_name);
            $file_in_db = '/uploads/jobs/' . $request->job_id . '/' . $file_name;
        }
        $job = Job::query()->find($request->job_id);
        $job->attachment()->updateOrCreate([
            'job_id' => $request->job_id
        ], [
            'file' => $file_in_db,
        ]);
        return response()->json('success');
    }

    protected function delete($id)
    {
        JobData::query()->where('job_id', $id)->delete();
        Job::query()->find($id)->delete();
    }

    protected function getTranslation(Request $request)
    {
        $rowData = JobData::where('job_id', $request->transRow)
            ->where('lang_id', $request->lang_id)
            ->first(['title', 'description']);
        if (!empty($rowData)) {
            return response()->json(['data' => $rowData]);
        } else {
            return response()->json(['data' => false]);
        }
    }

    protected function storeTranslation(Request $request)
    {
        $rowData = JobData::where('job_id', $request->id)
            ->where('lang_id', $request->lang_id)
            ->first();
        if ($rowData != null) {
            $rowData->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        } else {
            JobData::create([
                'title' => $request->title,
                'description' => $request->description,
                'lang_id' => $request->lang_id,
                'job_id' => $request->id,
            ]);
        }
        return response()->json("SUCCESS");
    }

    protected function show($id)
    {
        $key = 1;
        $job = Job::with(['data', 'attachment'])->find($id);
        if ($job)
            return view('admin.jobs.details', compact('key', 'job'));
        else
            return view('admin.jobs.index');
    }
}
