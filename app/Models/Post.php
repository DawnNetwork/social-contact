<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use Searchable;
    //protected $guarded;//不可以注入的数据字段
    protected $fillable = ['title','content','user_id','created_at','updated_at'];//可以注入的数据字段
    /*
     * 搜索的type
     */
    public function searchableAs()
    {
        return 'posts_index';
    }

    public function toSearchableArray()
    {
        return [
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
    //与用户表进行反向关联
    public function user()
    {
    	return $this->belongsTo(User::class,'user_id','id');
    }
    //关联评论模型
    public function comments(){
        return $this->hasMany(Comment::class,'post_id','id')->orderBy('created_at','desc');
    }
    //posts 文章表与 zans 赞表进行关联并查询用户是否有赞。
    public function zan($user_id)
    {
        return $this->hasOne(Zan::class)->where('user_id',$user_id);
    }
    //获取与文章关联的所有赞
    public function zans()
    {
        return $this->hasMany(Zan::class);
    }
    //属于某个作者的文章
    public function scopeAuthorBy($query,$user_id)
    {
        return $query->where('user_id',$user_id);
    }
    public function postTopics()
    {
        return $this->hasMany(PostTopic::class,'post_id','id');
    }
    //不属于某个专题的文章
    public function scopeTopicNotBy($query, $topic_id)
    {
        return $query->doesntHave('postTopics','and',function($q) use ($topic_id){
            $q->where('topic_id',$topic_id);
        });
    }
    // 全局scope的方式  过滤 0 1
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope("avaiable",function($query){
            $query->whereIn('status',[0,1]);
        });
    }        
}
