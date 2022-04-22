<?php

namespace App\Modules\Admin\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Modules\Admin\Controllers\Admin\Product\Comment;
use App\Modules\Admin\Controllers\Admin\Product\commentsDataTable;
use App\Modules\Admin\Controllers\Admin\Product\Request;
use function auth;
use function response;


class CommentsController extends Controller
{
    public function index(commentsDataTable $comments)
    {
        return $comments->render('admin.settings.comments.index');
    }

    public function update( Request $request, Comment $comment )
    {

		$comment->comment = $request->comment;
        $comment->update();

        return response()->json('SUCCESS');
    }

    public function approve($id)
    {


		/*$userRating = userRating::findOrFail($id);
		if ($userRating->approve == 0){
			$userRating->update(['approve'=>1]);
			$userscount = userRating::where('id',$id)->where('approve',1)->count();
			$RatingUsers = userRating::where('id',$id)->where('approve',1)->sum('rating') * 20;
			if ($userscount > 0){
				$userRating->rate->update(['rating'=> ($RatingUsers / $userscount)]);
			}
		}elseif($userRating->approve == 1){
			$userRating->update(['approve'=>0]);
			$userscount = userRating::where('id',$id)->where('approve',1)->count();
			$RatingUsers = userRating::where('id',$id)->where('approve',1)->sum('rating') * 20;
			if ($userscount > 0){
				$userRating->rate->update(['rating'=> ($RatingUsers / $userscount)]);
			}else{
				$userRating->rate->update(['rating'=> $RatingUsers]);
			}
		}*/

        $comment = Comment::where('id' , $id)->first();
        $comment->published = $comment->published == 1 ? 0 : 1;
        $comment->update();

        return response()->json(['data' => true]);
    }

    public function delete($id)
    {

        Comment::whereId($id)->delete();
        return response()->json(['data' => true]);
    }

    public function reply(Request $request, $id)
    {

		$comment = Comment::where('id',$id)->first();

        Comment::create([

			'user_id' => auth()->user()->id,
			'product_id' => $comment->product_id,
			'comment_id' => $id,
			'published' => 1,
			'comment' => $request->comment

		]);

        return response()->json('SUCCESS');
        if($comment->reply == null)
        {
            $request->merge(['user_id' => auth()->user()->id, 'product_id' => $comment->product_id, 'comment_id' => $id, 'published' => 1]);
            Comment::create($request->all());
        }
        else
        {
            Comment::whereCommentId($id)->update(['comment' => $request->comment]);
        }

        return response()->json('SUCCESS');
    }
}
