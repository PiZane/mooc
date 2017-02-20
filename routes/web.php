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
Route::get('/', "StudentViewController@index");

/*
 * 课程课时
 */
Route::get ('course/{courseId}', "StudentViewController@course");
Route::get ('lesson/{courseId}/{lessonId}', "StudentViewController@lesson");
Route::post('joinCourse/{courseId}', "StudentActionController@joinCourse");

/*
 * 个人主页
 */
Route::get ('profile', "StudentViewController@profile");
Route::post('edit/profile', "StudentActionController@editProfile");
Route::post('edit/avatar', "StudentActionController@editAvatar");
Route::post('edit/password', "StudentActionController@editPassword");

/*
 * 私信
 */
Route::get ('message', "StudentViewController@message");
Route::post('sendMessage', "StudentActionController@sendMessage");

/*
 * 评论
 */
Route::get('getComment/{lessonId}', "StudentViewController@comment");
Route::post('postComment', "StudentActionController@comment");

/*
 * 学生登录注册
 */
Route::post('login', "StudentAuth\\SLoginController@login");
Route::get ('logout', "StudentAuth\\SLoginController@logout");
Route::post('register', "StudentAuth\\SRegisterController@register");

/*
 * 后台路由
 */
Route::group(['prefix' => 'admin'], function () {

    /*
     * 注册登录路由
     */
    Route::get ('login', "TeacherAuth\\TLoginController@showLoginForm");
    Route::post('login', "TeacherAuth\\TLoginController@login");
    Route::get ('logout', "TeacherAuth\\TLoginController@logout");
    Route::get ('register', "TeacherAuth\\TRegisterController@showRegistrationForm");
    Route::post('register', "TeacherAuth\\TRegisterController@register");

    //后台首页
    Route::get ('/', "TeacherViewController@index");

    /*
     * 课程管理
     */
    Route::get ('course', "TeacherViewController@course");
    Route::get ('course/{courseId}', "TeacherViewController@courseInfo");
    Route::post('create/course', "TeacherActionController@createCourse");
    Route::post('edit/course/{courseId}', "TeacherActionController@editCourse");
    Route::post('delete/course/{courseId}', "TeacherActionController@deleteCourse");

    /*
     * 章节管理
     */
    Route::get ('lesson/{courseId}/{lessonId}', "TeacherViewController@lessonInfo");
    Route::get ('create/lesson/{courseId}', "TeacherViewController@createLesson");
    Route::post('create/lesson/{courseId}', "TeacherActionController@createLesson");
    Route::post('edit/lesson/{lessonId}', "TeacherActionController@editLesson");

    /*
     * 私信管理
     */
    Route::get ('message', "TeacherViewController@message");


    /*
     * 站点设置
     */
    Route::get ('setting', "TeacherViewController@setting");
    Route::post('setting', "TeacherActionController@setting");
});
