<?php

namespace App\Modules\Portal\Models;

use App\Models\User;
use App\Modules\Admin\Models\Products\Product;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $table = 'comments';
	protected $guarded = [];
	//protected $with = ['reply'];
    protected $hidden = ['id' , 'comment' , 'published' , 'type' , 'user_id' , 'item_id' 
                        , 'comment_id','created_at' , 'updated_at' , 'product_id'];


	public function user()
	{
		return $this->belongsTo(User::class);
	}

    public function product()
    {
        return $this->belongsTo(Product::class,'id','product_id');
    }






}
