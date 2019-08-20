<?php

namespace App\Admin\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //文章列表
    public function index(Post $post)
    {
        $posts = Post::withoutGlobalScope('avaiable')->where('status',0)->orderBy('created_at','desc')->paginate(10);
        return view('admin.post.index',[
            'posts'=>$posts,
        ]);
    }

    //修改状态
    public function status(Post $post)
    {
    	$this->validate(request(),[
    		'status'=>'required|int:-1,1',
    	]);
    	$post->status = request('status');
    	$post->save();
    	return [
    		'error'=>0,
    		'msg'=>''
    	];
    }
}
