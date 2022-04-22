<?php

namespace App\Modules\Portal\Controllers;

use App\Bll\Lang;
use App\Models\Blog\Blog;
use App\Models\Blog\BlogCategory;
use App\Http\Controllers\Controller;
use App\Models\Blog\BlogCategoryData;
use App\Modules\Admin\Models\Pages\SubPages;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Portal\Models\SitePage;

class BlogController extends Controller
{


    public function blog($blog_id)
    {
        $blog = Blog::with(['attachment'])->leftJoin('blogs_data','blogs_data.blog_id','blogs.id')
            ->select('blogs_data.*','blogs.id','blogs.image')
            ->where('blogs_data.lang_id', Lang::getSelectedLangId())
            ->where('blogs.status', 1)
            ->where('blogs.id', $blog_id)->first();

        if($blog == null){
            return view('site.not_found');
        }
//        $blog_categories = BlogCategoryData::where('blog_categories_data.lang_id', Lang::getSelectedLangId())->get();
        $blog_categories = BlogCategory::leftJoin('blog_categories_data', 'blog_categories_data.blog_id', 'blog_categories.id')
            ->where('blog_categories_data.lang_id', Lang::getSelectedLangId())->where('blog_categories.active', 1)
            ->select('blog_categories_data.*')->orderBy('blog_categories.order', 'asc')->get();
        $blog_cat = $blog_categories->where('blog_id', $blog->blog_category_id)->first();
        $similar_blogs = Blog::leftJoin('blogs_data','blogs_data.blog_id','blogs.id')
            ->select('blogs_data.*','blogs.id','blogs.image')
            ->where('blogs_data.lang_id', Lang::getSelectedLangId())
            ->where('blogs.status', 1)->where('blogs.id',"!=",$blog->id)
            ->where('blogs.blog_category_id', $blog->blog_category_id)->get();

        return view('site.blogs.single_blog', compact('blog','blog_cat','similar_blogs'
            ,'blog_categories'));
    }


    public function blog_cat($cat_id)
    {
//        $category = BlogCategory::with(['attachment'])->join('blog_categories_data', 'blog_categories_data.blog_id', 'blog_categories.id')
//            ->where('blog_categories_data.lang_id', Lang::getSelectedLangId())
//            ->where('blog_categories.id', $cat_id)->where('active', 1)->first();
        $category = BlogCategory::with(['attachment','data'])->find($cat_id);
       // dd($category->attachment,$category);
        if($category == null){
            return view('site.not_found');
        }
        $blogs = Blog::leftJoin('blogs_data','blogs_data.blog_id','blogs.id')
            ->select('blogs_data.*','blogs.id','blogs.image')
            ->where('blogs_data.lang_id', Lang::getSelectedLangId())->where('blogs.status', 1)
            ->where('blogs.blog_category_id', $cat_id)->get();
        $blog_categories = BlogCategory::leftJoin('blog_categories_data', 'blog_categories_data.blog_id', 'blog_categories.id')
            ->where('blog_categories_data.lang_id', Lang::getSelectedLangId())->where('blog_categories.active', 1)
            ->select('blog_categories_data.*')->orderBy('blog_categories.order', 'asc')->get();

        return  view('site.blogs.single_cat', compact('category','blogs','blog_categories'));
    }

    public function sub_page($page_id)
    {

        $sub_page = SitePage::leftJoin('site_pages_data', 'site_pages_data.page_id', 'site_pages.id')
            ->where('site_pages_data.lang_id', Lang::getSelectedLangId())
            ->where('site_pages.place', "home")
            ->where('site_pages.id', $page_id)->first();
//        $sub_page = SubPages::leftJoin('sub_pages_data', 'sub_pages_data.page_id', 'sub_pages.id')
//            ->where('sub_pages_data.lang_id', Lang::getSelectedLangId())
//            ->where('sub_pages.id', $page_id)->first();
        //dd($sub_page);
        if($sub_page == null){
            return view('site.not_found');
        }

        $sub_pages = SitePage::leftJoin('site_pages_data', 'site_pages_data.page_id', 'site_pages.id')
            ->select('site_pages.image', 'site_pages_data.*')->where('site_pages.id', "!=", $page_id)
            ->where('site_pages_data.lang_id', Lang::getSelectedLangId())
            ->where('site_pages.place', "home")
            ->orderBy('site_pages.id', 'desc')->get();

//        $sub_pages = SubPages::leftJoin('sub_pages_data', 'sub_pages_data.page_id', 'sub_pages.id')
//            ->select('sub_pages.image', 'sub_pages_data.*')->where('sub_pages.id', "!=", $page_id)
//            ->where('sub_pages_data.lang_id', Lang::getSelectedLangId())
//            ->orderBy('sub_pages.order', 'asc')->get();

        return view('site.blogs.sub_page', compact('sub_page', 'sub_pages'));

    }

    protected function categories()
    {

        $cats = BlogCategory::with('data')->where('active',1)->get();
       // dd($cats);
        return  view('site.blogs.blogs', compact('cats'));
    }
}
