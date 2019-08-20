<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fan extends Model
{
    //protected $guarded;//不可以注入的数据字段
    protected $fillable = ['fan_id','star_id','created_at','updated_at'];//可以注入的数据字段
    //粉丝用户
    public function fuser()
    {
        return $this->hasOne(User::class,'id','fan_id');
    }
    //被关注用户
    public function suser()
    {
        return $this->hasOne(User::class,'id','star_id');
    }
}
