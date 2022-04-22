<?php

namespace App\Bll;

use Illuminate\Support\Facades\DB;
use App\Modules\Admin\Models\Section;
use Illuminate\Support\Facades\Request;

class SectionClass
{
    public function section(){

        $sections = Section::query()
        ->join('sections_data', 'sections.id', 'sections_data.section_id')
        ->join('section_products', 'sections.id', 'section_products.section_id')
        ->select('title',"sections.id")
        ->where('sections.page', 'mobile');

        return $sections;



    }

}
