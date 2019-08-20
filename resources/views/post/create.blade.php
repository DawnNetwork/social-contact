@extends("layout.main")

@section('pagecss')
<link rel="stylesheet" type="text/css" href="/css/wangEditor.min.css">
@endsection
@section("content")
    <div class="col-sm-8 blog-main">
        <form action="/posts" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
                <label>标题</label>
                <input name="title" type="text" class="form-control" placeholder="这里是标题">
            </div>
            <div class="form-group">
                <label>内容</label>
                <textarea id="content"  style="height:400px;max-height:500px;" name="content" class="form-control" placeholder="这里是内容"></textarea>
            </div>
            @if(count($errors) > 0)
            <div class="alert alert-danger" role>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </div>
            @endif
            <button type="submit" class="btn btn-default">提交</button>
        </form>
        <br>

    </div><!-- /.blog-main -->
@endsection
@section('pagejs')
<script type="text/javascript" src="/js/wangEditor.min.js"></script>
<script type="text/javascript">
    var editor = new wangEditor('content');

    editor.config.uploadImgUrl = '/posts/image/upload';

    // 设置 headers（举例）
    editor.config.uploadHeaders = {
        'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
    };

    editor.create();    
    </script>
@endsection