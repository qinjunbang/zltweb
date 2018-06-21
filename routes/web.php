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
//首页

Route::get('/', function () {
    return view('welcome');
});

//lyj测试专用
Route::get('/lyj1', function () {
    return view('test');
});
Route::get('/lyj2', 'Api\v1\TestController@getProvince');
Route::get('/lyj3','TestController@index');

//web端口登录
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
//微信授权登录
Route::get('/auth/oauth', 'Auth\AuthController@oauth');
//微信接口回调
Route::get('/auth/callback', 'Auth\AuthController@callback');
//QQ授权登录
Route::get('/qqlogin','Auth\AuthController@qqlogin');
Route::get('/qq','Auth\AuthController@qq');
//token登录
Route::get('/redirect', function (){
    $query = http_build_query([
        'client_id' => '3',
        'redirect_uri' => 'http://localhost/auth/callback',
        'response_type' => 'code',
        'scope' => '',
    ]);
    return redirect('http://localhost/oauth/authorize?' . $query);
});
Route::get('/auth/callback', function (\Illuminate\Http\Request $request){
    if ($request->get('code')) {
        return 'Login Success';
    } else {
        return 'Access Denied';
    }
});

//web端专用
Route::group(['prefix' => 'web'],function () {

    $this->get('index', 'Web\PersonController@index');

});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
