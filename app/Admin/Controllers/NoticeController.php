<?php

namespace App\Admin\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;

class NoticeController extends Controller
{
    //通知列表
    public function index()
    {
        $notices = Notice::all();
        return view('admin.notice.index',[
            'notices'=>$notices,
        ]);
    }
    //创建通知
    public function create()
    {
        return view('admin.notice.create');
    }
    //储存通知
    public function store()
    {
        $this->validate(request(),[
            'title'=>'required|string',
            'content'=>'required|string'
        ]);
        $notice = Notice::create(request(['title', 'content']));
        //创建分发逻辑 分发给队列
        dispatch(new \App\Jobs\SendMessage($notice));
        return redirect('admin/notices');
    }
}
