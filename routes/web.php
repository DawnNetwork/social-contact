<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware'=>'auth:web'],function(){
	//文章列表
	Route::get('/posts','PostController@index');
	//文章搜索页面
	Route::get('/posts/search', '\App\Http\Controllers\PostController@search');
	//创建文章页面
	Route::get('/posts/create','PostController@create');
	Route::post('/posts','PostController@store');
	//文章详情页
	Route::get('/posts/{post}','PostController@show')->name('show');//路由使用的式绑定模型功能

	//编辑文章页面
	Route::get('/posts/{post}/edit','PostController@edit');
	Route::put('/posts/{post}','PostController@update');
	//删除文章
	Route::get('/posts/{post}/delete','PostController@delete');
	//图片上传
	route::post('/posts/image/upload','PostController@imageUpload');
	//评论提交
	route::post('/posts/{post}/comment','PostController@comment')->name('comment');
	//赞
	Route::get('/posts/{post}/zan', 'PostController@zan')->name('zan');
	//取消赞
	Route::get('/posts/{post}/unzan', 'PostController@unzan')->name('unzan');
	//个人主页
	Route::get('/user/{user}','UserController@show')->name('user.show');
	Route::post('/user/{user}/fan','UserController@fan')->name('fan');
	Route::post('/user/{user}/unfan','UserController@unfan')->name('unfan');
	//专题详情
	Route::get('/topic/{topic}','TopicController@show')->name('topic.show');
	//投稿
	Route::post('/topic/{topic}/submit','TopicController@submit')->name('topic.submit');
    // 通知
    Route::get('/notices', 'NoticeController@index'); 
	//个人设置页面
	Route::get('/user/{user}/setting','UserController@setting');
	//个人设置操作
	Route::post('/user/{user}/setting','UserController@settingStore');	
});

//用户模块
//登陆页面
Route::get('/login','LoginController@index')->name('login');
//登陆行为
Route::post('/login','LoginController@login');
//登出行为
Route::get('/logout','LoginController@logout');
//注册页面
Route::get('/register','RegisterController@index');
//注册行为
Route::post('/register','RegisterController@register');


//管理后台
Route::group(['prefix'=>'admin'],function(){
    Route::get('/login', '\App\Admin\Controllers\LoginController@index');
    Route::post('/login', '\App\Admin\Controllers\LoginController@login');
    Route::get('/logout', '\App\Admin\Controllers\LoginController@logout');
    Route::group(['middleware'=>'auth:admin'],function(){
        Route::get('/home', '\App\Admin\Controllers\HomeController@index');
        // 系统管理
        Route::group(['middleware'=>'can:system'],function(){
	        //管理人员模块
	        Route::get('/users','\App\Admin\Controllers\UserController@index');
	        Route::get('/users/create','\App\Admin\Controllers\UserController@create');
	        Route::post('/users/store','\App\Admin\Controllers\UserController@store');
	        Route::get('/users/{user}/role', '\App\Admin\Controllers\UserController@role');
	        Route::post('/users/{user}/role', '\App\Admin\Controllers\UserController@storeRole');

	        // 角色管理
	        Route::get('/roles', '\App\Admin\Controllers\RoleController@index');
	        Route::get('/roles/create', '\App\Admin\Controllers\RoleController@create');
	        Route::post('/roles/store', '\App\Admin\Controllers\RoleController@store');
	        Route::get('/roles/{role}/permission', '\App\Admin\Controllers\RoleController@permission');
	        Route::post('/roles/{role}/permission', '\App\Admin\Controllers\RoleController@storePermission');

	        // 权限管理
	        Route::get('/permissions', '\App\Admin\Controllers\PermissionController@index');
	        Route::get('/permissions/create', '\App\Admin\Controllers\PermissionController@create');
	        Route::post('/permissions/store', '\App\Admin\Controllers\PermissionController@store');
        });
        // 文章管理
        Route::group(['middleware'=>'can:post'],function(){        
	        //审核模块
	        Route::get('/posts','\App\Admin\Controllers\PostController@index');
	        Route::post('/posts/{post}/status','\App\Admin\Controllers\PostController@status');
        });
        //
        Route::group(['middleware'=>'can:topic'],function(){
            Route::resource('topics','\App\Admin\Controllers\TopicController',['only'=>['index','create','store','destroy']]);
        });
        Route::group(['middleware' => 'can:notice'], function() {
            Route::resource('notices', '\App\Admin\Controllers\NoticeController', ['only' => ['index', 'create', 'store']]);
        });
    });

});



