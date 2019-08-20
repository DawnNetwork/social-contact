<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use App\Models\Post;
use App\Models\PostTopic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function show(Topic $topic)
    {
        //带文章数的专题
        $topic = Topic::withCount('postTopics')->find($topic->id);
        //专题的文章列表、按照创建时间倒序排列，前10个
        $posts = $topic->posts()->orderBy('created_at','desc')->take(10)->get();
        //属于我的文章但是未投稿
        $myposts = Post::authorBy(\Auth::id())->topicNotBy($topic->id)->get();
        return view('topic/show',[
           'topic'=>$topic,
            'posts'=>$posts,
            'myposts'=>$myposts,
        ]);
    }
    public function submit(Topic $topic)
    {
        $this->validate(request(),[
            'post_ids'=>'required|array'
        ]);
        $post_ids = request('post_ids');      
        foreach ($post_ids as $post_id){
            $param = [
                'post_id'=> $post_id,
                'topic_id'=> $topic->id,
            ];
            
        }
        PostTopic::firstOrCreate($param);
        return back();
    }
}
