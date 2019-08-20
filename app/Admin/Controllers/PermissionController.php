<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminPermission;

class PermissionController extends Controller
{
    //权限列表页面
    public function index()
    {
        $permissions = AdminPermission::paginate(10);
        return view('admin.permission.index',[
            'permissions'=>$permissions,
        ]);
    }
    //权限创建页面
    public function create()
    {
        return view('admin.permission.add');
    }
    //权限创建逻辑
    public function store()
    {
        $this->validate(request(),[
            'name'=>'required|min:3',
            'description'=>'required',
        ]);
        AdminPermission::create(request(['name','description']));
        return redirect('/admin/permissions');        
    }
}