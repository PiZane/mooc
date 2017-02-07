@extends('common.student')
@section('title')个人主页 | {{ $setting->name }}@endsection
@section('main')
<div class="container">
    <div class="row">
        <div class="col s12 m10 offset-m1">
            <div class="card col s12 white my-header-banner" style="padding-bottom: 2em">
                <div class="card-tabs">
                    <ul class="tabs my-menu-tabs tabs-fixed-width">
                        <li class="tab"><a class="active" href="#profile">个人信息</a></li>
                        <li class="tab"><a href="#course">我的课程</a></li>
                        <li class="tab"><a href="#security">安全设置</a></li>
                    </ul>
                </div>
                <div class="card-content">
                    <div id="profile">
                        <form action="{{ action("StudentActionController@editProfile") }}" enctype="multipart/form-data" method="post">
                            {{ csrf_field() }}
                            <div class="input-field col s3 m2">
                                <img class="responsive-img" src="{{ $user->image_url?:$setting->avatar }}" alt="avatar">
                            </div>
                            <div class="col s9 m8">
                                <div class="file-field input-field">
                                    <div class="btn">
                                        <span>上传头像</span>
                                        <input type="file" name="avatar" accept="image/jpeg,image/png,image/gif" multiple>
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" value="{{ $user->image_url }}">
                                    </div>
                                </div>
                                <div class="input-field">
                                    <i class="material-icons prefix">email</i>
                                    <label for="email">电子邮件</label>
                                    <input class="validate" id="email" name="email" type="email" value="{{ $user->email }}" required disabled>
                                </div>
                                <div class="input-field">
                                    <i class="material-icons prefix">account_circle</i>
                                    <label for="name">姓名</label>
                                    <input class="validate" id="name" name="name" type="text" value="{{ $user->name }}" required>
                                </div>
                                <div class="input-field">
                                    <i class="material-icons prefix">picture_in_picture</i>
                                    <label for="school_id">学号</label>
                                    <input class="validate" id="school_id" name="school_id" type="text" value="{{ $user->school_id }}" required>
                                </div>
                                <div class="input-field">
                                    <i class="material-icons prefix">recent_actors</i>
                                    <label for="class">班级</label>
                                    <input class="validate" id="class" name="class" type="text" value="{{ $user->class }}" required>
                                </div>
                                <button class="right btn lighten-2 waves-effect waves-light" type="submit" name="action">修改信息</button>
                            </div>
                        </form>
                    </div>
                    <div id="course">TODO</div>
                    <div id="security">TODO</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection