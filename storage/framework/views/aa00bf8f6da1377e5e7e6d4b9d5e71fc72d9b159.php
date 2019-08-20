
<?php $__env->startSection("content"); ?>
    <div class="col-sm-8">
        <blockquote>
            <p><img src="<?php echo e($user->avatar); ?>" alt="" class="img-rounded" style="border-radius:500px; height: 40px"> <?php echo e($user->name); ?>

            </p>
            <footer>关注：<?php echo e($user->stars_count); ?>｜粉丝：<?php echo e($user->fans_count); ?>｜文章：<?php echo e($user->posts_count); ?></footer>
            <?php echo $__env->make('user.badges.like',['target_user'=>$user], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="blog-post" style="margin-top: 30px">                           
                            <p class=""><a href="<?php echo e(route('user.show',['user'=>$post->user->id])); ?>"><?php echo e($post->user->name); ?></a> <?php echo e($post->created_at->diffForHumans()); ?></p>
                            <p class=""><a href="<?php echo e(route('show',['post'=>$post->id])); ?>" ><?php echo e($post->title); ?></a></p>
                            <p><?php echo str_limit($post->content, 100, '...'); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2">
                        
                    <?php $__currentLoopData = $susers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
                        <div class="blog-post" style="margin-top: 30px">
                            <p class=""><?php echo e($user->name); ?></p>
                            <p class="">关注：<?php echo e($user->stars_count); ?> | 粉丝：<?php echo e($user->fans_count); ?>｜ 文章：<?php echo e($user->posts_count); ?></p>                       
                            <?php echo $__env->make('user.badges.like',['target_user'=>$user], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>                      
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                    <?php $__currentLoopData = $fusers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>    
                        <div class="blog-post" style="margin-top: 30px">
                            <p class=""><?php echo e($user->name); ?></p>
                            <p class="">关注：<?php echo e($user->stars_count); ?> | 粉丝：<?php echo e($user->fans_count); ?>｜ 文章：<?php echo e($user->posts_count); ?></p>                        
                            <?php echo $__env->make('user.badges.like',['target_user'=>$user], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>                      
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                    
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
    </div><!-- /.blog-main -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('pagejs'); ?>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make("layout.main", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vagrant/Code/social-contact/resources/views/user/show.blade.php ENDPATH**/ ?>