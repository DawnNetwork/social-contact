<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPermission extends Model
{
    protected $fillable = ['name','description','created_at','updated_at'];
    //权限属于那个角色
    public function roles()
    {
        return $this->belongsToMany(AdminRole::class,'admin_permission_roles','permission_id','role_id')->withPivot(['permission_id','role_id']);
    }
}
