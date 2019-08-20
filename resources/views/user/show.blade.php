@extends("layout.main")
@section("content")
    <div class="col-sm-8">
        <blockquote>
            <p><img src="{{$user->avatar}}" alt="" class="img-rounded" style="border-radius:500px; height: 40px"> {{$user->name}}
            </p>
            <footer>关注：{{ $user->stars_count }}｜粉丝：{{ $user->fans_count }}｜文章：{{ $user->posts_count }}</footer>
            @include('user.badges.like',['target_user'=>$user])
        </blockquote>
    </div>
    <div class="col-sm-8 blog-main">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">文章</a></li>
                <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">关注</a></li>
                <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">粉丝</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    @foreach($posts as $post)
                        <div class="blog-post" style="margin-top: 30px">                           
                            <p class=""><a href="{{ route('user.show',['user'=>$post->user->id]) }}">{{ $post->user->name }}</a> {{ $post->created_at->diffForHumans() }}</p>
                            <p class=""><a href="{{ route('show',['post'=>$post->id]) }}" >{{ $post->title }}</a></p>
                            <p>{!! str_limit($post->content, 100, '...') !!}</p>
                        </div>
                    @endforeach
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                        
                    @foreach($susers as $user)    
                        <div class="blog-post" style="margin-top: 30px">
                            <p class="">{{ $user->name }}</p>
                            <p class="">关注：{{ $user->stars_count }} | 粉丝：{{ $user->fans_count }}｜ 文章：{{ $user->posts_count }}</p>                       
                            @include('user.badges.like',['target_user'=>$user])                      
                        </div>
                    @endforeach
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                    @foreach($fusers as $user)    
                        <div class="blog-post" style="margin-top: 30px">
                            <p class="">{{ $user->name }}</p>
                            <p class="">关注：{{ $user->stars_count }} | 粉丝：{{ $user->fans_count }}｜ 文章：{{ $user->posts_count }}</p>                        
                            @include('user.badges.like',['target_user'=>$user])                      
                        </div>
                    @endforeach                    
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
    </div><!-- /.blog-main -->
@endsection
@section('pagejs')
<script type="text/javascript">
$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    }
});
$(".like-button").click(function(event){
    target = $(event.target);
    var current_like = target.attr("like-value");
    var user_id = target.attr("like-user");
    if(current_like == 1){
        //取消关注
        $.ajax({
            url:"/user/" + user_id + "/unfan",
            method:"POST",
            dataType:"json",
            success:function(data){
                if(data.error != 0){
                    alert(data.msg);
                    return;
                }
                target.attr("like-value",0);
                target.text("关注");
            }
        });
    } else {
        //关注
        $.ajax({
            url:"/user/" + user_id + "/fan",
            method:"POST",
            dataType:"json",
            success:function(data){
                if(data.error != 0){
                    alert(data.msg);
                    return;
                }
                target.attr("like-value",1);
                target.text("取消关注");
            }
        });
    }
});    
</script>
@endsection