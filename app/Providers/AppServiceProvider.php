<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //试图合成器，composer组件的意思
        \View::composer('layout.sidebar',function($view){
            $topics = \App\Models\Topic::all();//获取所有专题
            $view->with('topics',$topics); //将$topics往试图中注入变量 topics变量。
        });
        \DB::listen(function($query){
            $sql = $query->sql;
            $bindings = $query->bindings;
            $time = $query->time;
            if($time > 10){}
            \Log::debug(var_export(compact('sql','bindings','time'),true));
        });
    }
}
