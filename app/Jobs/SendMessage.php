<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Notice;
use App\Models\User;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $notice;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Notice $notice)
    {
        $this->notice = $notice;//将传进来的$notice挂在job中
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //通知每个用户系统消息
        $users = User::all();
        foreach ($users as $user) {
            $user->addNotice($this->notice);
        }
    }
}
