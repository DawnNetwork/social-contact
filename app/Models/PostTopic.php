<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTopic extends Model
{
    //protected $guarded;//不可以注入的数据字段
    protected $fillable = ['post_id','topic_id','created_at','updated_at'];//可以注入的数据字段
}
