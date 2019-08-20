<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //protected $guarded;//不可以注入的数据字段
    protected $fillable = ['post_id','content','user_id','created_at','updated_at'];//可以注入的数据字段
    //关联评论模型
    public function post()
    {
    	return $this->belongsTo(Post::class);
    }
    //评论所属用户
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
