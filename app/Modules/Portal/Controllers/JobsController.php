<?php

namespace App\Modules\Portal\Controllers;

use App\Bll\Lang;
use App\Modules\Portal\Models\Job;

use App\Http\Controllers\Controller;
use App\Modules\Portal\Models\JobAttatchment;
use Illuminate\Http\Request;


class JobsController extends Controller
{

    protected function jobs(){

        $jobs = Job::with('data')->latest()->get();
        //dd($jobs);
        return view('site.jobs.job',compact('jobs'));
    }

    protected function singleJob($id){

        $job = Job::with('data')->findOrFail($id);

        return view('site.jobs.single_job',compact('job'));
    }

    protected function uploadFile(Request $request){
//        $this->validate($request, [
//            'file.*' => [
//                'mimes:doc,docx,pdf',
//                function($attribute, $value, $fail) {
//                    if (count($value) > 2) {
//                        return $fail($attribute . "Sorry! You can't upload more than 2 file at minute.");
//                    }
//                },
//            ]
//        ]);

        $request->validate([
        'file' => 'required|file|mimes:doc,docx,pdf|max:2048',
        ]);

        $name = $request->file('file')->getClientOriginalName();
        $filePath = $request->file('file')->storeAs('uploads/attatchment/' .$request->id  , $name, 'public');


        JobAttatchment::create([
            'job_id' => $request->id,
            'file'   => $filePath
        ]);
        return response()->json(['success' =>'ok']);

    }
}
