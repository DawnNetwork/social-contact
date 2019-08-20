<?php

namespace App\Admin\Controllers;

use App\Models\AdminUser;
use App\Models\AdminRole;
use Illuminate\Http\Request;
use App\Admin\Controllers\Controller;

class UserController extends Controller
{
    //管理员列表页面
    public function index()
    {
        $users = AdminUser::paginate(10);
        return view('admin.user.index',[
            'users'=>$users,
        ]);
    }
    //管理员创建页面
    public function create()
    {
        return view('admin.user.add');
    }
    //创建逻辑
    public function store()
    {
        //验证
        $this->validate(request(),[
            'name'=>'required|min:3',
            'password'=>'required',
        ]);
        //逻辑
        AdminUser::create([
            'name'=>request('name'),
            'password'=>bcrypt(request('password')),
        ]);
        //渲染
        return redirect('/admin/users');
    }
    //用户角色页面
    public function role(AdminUser $user)
    {
        $roles = AdminRole::all();
        $myRoles = $user->roles;
        return view('admin.user.role',[
            'roles'=>$roles,
            'myRoles'=>$user->roles,
            'user'=>$user
        ]);
    }
    //储存用户角色
    public function storeRole(AdminUser $user)
    {
        $this->validate(request(),[
            'roles'=>'required|array'
        ]);
        $roles = AdminRole::findMany(request('roles'));//将$roles转换为我们要的对象
        $myRoles = $user->roles;
        //要增加的
        $addRoles = $roles->diff($myRoles);//获取两个权限数组的差集
        foreach ($addRoles as $role) {
            $user->assignRole($role);
        }
        //要删除的
        $deleteRoles = $myRoles->diff($roles);//获取两个权限数组的差集
        foreach ($deleteRoles as $role) {
            $user->deleteRole($role);
        }
        return back();
    }   
}
