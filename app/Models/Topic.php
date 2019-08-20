<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    //protected $guarded;//不可以注入的数据字段
    protected $fillable = ['name','created_at','updated_at'];//可以注入的数据字段
    //获取专题下面的所有文章
    public function posts()
    {
        return $this->belongsToMany(Post::class,'post_topics','topic_id','post_id');
    }
    //专题的文章数，用于withCount
    public function postTopics()
    {
        return $this->hasMany(PostTopic::class,'topic_id');
    }
}
