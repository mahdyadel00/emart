<?php

namespace App\Modules\Portal\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class JobData extends Model
{
	protected $table = 'job_data';
	protected $guarded = [];
	
	public function job()
	{
		return $this->belongsTo(Job::class);
	}
 
}
