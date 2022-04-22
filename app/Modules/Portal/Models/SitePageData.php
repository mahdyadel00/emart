<?php

namespace App\Modules\Portal\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SitePageData extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'site_pages_data';
}
