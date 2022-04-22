<?php

namespace App\Modules\Admin\Controllers\Reviews\Controllers;

use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Portal\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ReviewsController extends Controller
{
    protected function index()
    {
        $comments = Comment::all();
        if (request()->ajax()) {
            return DataTables::of($comments)
                ->addColumn('username', function ($comment) {
                    $user = User::query()->find($comment->user_id);
                    return $user->name . ' ' . $user->lastname;
                })
                ->addColumn('stars', function ($comment) {
                    $html = '';
                    for ($i = 0; $i < $comment->stars; $i++) {
                        $html .= '<i class="fa fa-star" style="color: #daa520" aria-hidden="true"></i>';
                    }
                    return $html;
                })
                ->addColumn('published', function ($comment) {
                    if ($comment->published == 1) {
                        return 'published';
                    } else {
                        return 'not yet';
                    }
                })
                ->addColumn('action', function ($comment) {
                    $html = "<a href='#' class='btn waves-effect waves-light btn-success text-center edit-row mr-1 ml-1' data-stars='".$comment->stars."' data-status='".$comment->published."' data-comment='".$comment->comment."' data-id='".$comment->id."' data-toggle='modal' data-target='#default-Modal'>" . _i('Edit') . "</a>";
                    $html .= "<a href class='btn btn-danger btn-delete-review mr-1 ml-1' data-id='".$comment->id."'>" . _i('Delete') . "</a>";
                    return $html;
                })
                ->editColumn('comment', function ($query) {
                    return strip_tags($query->comment);
                })
                ->editColumn('created_at', function ($query) {
                    return Utility::dates($query->created_at);
                })
                ->editColumn('updated_at', function ($query) {
                    return Utility::dates($query->updated_at);
                })
                ->rawColumns(['updated_at', 'created_at', 'comment', 'username', 'stars', 'published', 'action'])
                ->make(true);
        }
        return view('admin.reviews.index');
    }

    protected function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
            'stars' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json('fail');
        } else {
            $comment = new Comment();
            $comment->comment = $request->comment;
            $comment->published = $request->published? 1:0;
            $comment->stars = $request->stars;
            $comment->user_id = auth()->user()->id;
            $comment->save();
            return response()->json('success');
        }
    }

    protected function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
            'stars' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json('fail validation');
        } else {
            Comment::query()->find($request->id)->update([
                'comment' => $request->comment,
                'published' => $request->published? 1 : 0,
                'stars' => $request->stars,
                'user_id' => auth()->user()->id
            ]);
        }
        return response()->json('success');
    }

    protected function destroy($id)
    {
       Comment::query()->find($id)->delete();
    }
}
