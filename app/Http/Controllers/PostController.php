<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Zan;
class PostController extends Controller
{
    //列表页
    public function index()
    {
        $posts = Post::query()->orderBy('id','desc')->withCount(['comments','zans'])->with('user')->paginate(10);
        return view('post.index',['posts'=>$posts]);
    }
    //详情页
    public function show(Post $post)
    {
        $post->load('comments');
        return view('post.show',[
            'post'=>$post,
        ]);
    }
    //提交评论
    public function comment(Post $post)
    {
        //验证
        $this->validate(request(),[
            'content'=>'required|string|min:3',
        ]);

        //逻辑
        $comment = new Comment();
        $comment->user_id=\Auth::id();
        $comment->content=request('content');
        $post->comments()->save($comment);
        //渲染
        return back();
    }
    //创建页面
    public function create()
    {
        return view('post.create');
    }
    //创建逻辑
    public function store()
    {
        //验证
        $this->validate(request(),[
            'title'=>'required|string|max:100|min:5',
            'content'=>'required|string|min:10',
        ]);
        //逻辑
        $user_id = \Auth::id();
        $params = array_merge(request(['title','content']),compact('user_id'));
        
        $post = Post::create($params);
        //渲染
        return redirect("/posts");
    }
    //编辑页面
    public function edit(Post $post)
    {
        return view('post.edit',['post'=>$post]);
    }
    //编辑逻辑
    public function update(Post $post)
    {
        //验证
        $this->validate(request(),[
            'title'=>'required|string|max:100|min:5',
            'content'=>'required|string|min:10',
        ]);
        //逻辑
        $this->authorize('update',$post);
        $post->title = request('title');
        $post->content = request('content');
        $post->save();
        //渲染
        return redirect("posts/{$post->id}");
    }
    //删除逻辑
    public function delete(Post $post)
    {
        $this->authorize('delete',$post);
        $post->delete();
        return redirect('/posts');
    }
    //图片上传
    public function imageUpload(Request $request)
    {
        $path = $request->file('wangEditorH5File')->storePublicly(md5(time()));
        return asset('storage/'.$path);
    }
    public function zan(Post $post)
    {
        $param = [
            'user_id'=> \Auth::id(),
            'post_id'=> $post->id,
        ];
        Zan::firstOrCreate($param);
        //firstOrCreate() 在数据库中查找是否有这条数据，如果有这个条数据就查找出来，没有就创建一条。
        return back();
    }
    public function unzan(Post $post)
    {
        $post->zan(\Auth::id())->delete();
        return back();
    }
    /*
     * 搜索页面
     */
    public function search()
    {
        //校验
        $this->validate(request(),[
            'query' => 'required'
        ]);
        //逻辑
        $query = request('query');
        $posts = Post::search(request('query'))->paginate(10);
        //渲染
        return view('post/search', compact('posts', 'query'));
    }
}
