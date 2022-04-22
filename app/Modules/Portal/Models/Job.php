<?php

namespace App\Modules\Portal\Models;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
	protected $table   = 'jobs';
	protected $guarded = [];


	public function data()
	{
		return $this->hasOne(JobData::class ,'job_id','id')->where('lang_id',Lang::getSelectedLangId());
	}
    public function data_back()
    {
        return $this->hasMany(JobData::class ,'job_id','id');
    }
    public function attachment()
    {
        return $this->hasMany(JobAttachment::class ,'job_id','id');
    }
}
