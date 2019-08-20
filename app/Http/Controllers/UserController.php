<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //个人中心页面
    public function show(User $user)
    {
        //这个人信息，包含关注/粉丝/文章数
        $user = User::withCount(['stars','fans','posts'])->find($user->id);
        //这个人的文章列表 取创建时间最新的前10条
        $posts = $user->posts()->orderBy('created_at','desc')->take(10)->get();
        //这个人关注的用户，包含关注用户的 关注/粉丝/文章数
        $stars = $user->stars;//这个人的粉丝用户
        $susers = User::whereIn('id',$stars->pluck('star_id'))->withCount(['stars','fans','posts'])->get();//$stars->pluck('star_id')获取fan模型中某一个字段
        //这个人的粉丝用户，包含粉丝用户的 关注/粉丝/文章数
        $fans = $user->fans;//这个人的粉丝用户
        $fusers = User::whereIn('id',$fans->pluck('fan_id'))->withCount(['stars','fans','posts'])->get();//$fans->pluck('fan_id')获取fan模型中某一个字段
        return view('user/show',[
            'user'=>$user,
            'posts'=>$posts,
            'susers'=>$susers,
            'fusers'=>$fusers,
        ]);
    }
    //关注用户
    public function fan(User $user)
    {
        $me = \Auth::user();
        $me->doFan($user->id);
        return [
            'error'=>0,
            'msg'=>''
        ];
    }
    //取消关注
    public function unfan()
    {
        $me = \Auth::user();
        $me->doUnFan($user->id);
        return [
            'error'=>0,
            'msg'=>''
        ];
    }
    //个人设置页面
    public function setting()
    {
        $me = \Auth::user();
        return view('user.setting',compact('me')); 
    }
    public function settingStore(Request $request,User $user)
    {
        //验证
        $this->validate(Request(),[
            'name'=>'min:3',
        ]);
        //逻辑
        $name = request('name');
        if($name != $user->name)
        {
            if(User::where('name',$name)->count() > 0){
                return back()->withErrors(array('message'=>'用户名已经被注册'));
            }
            $user->name = request('name');
        }
        if($request->file('avatar')){
            $path = $request->file('avatar')->storePublicly(md5(\Auth::id().time()));
            $user->avatar="/storage/".$path;
        }
        $user->save();
        //渲染
        return back();
    }
}
