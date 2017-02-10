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
                        <li class="tab"><a href="#courses">我的课程</a></li>
                        <li class="tab"><a href="#security">安全设置</a></li>
                    </ul>
                </div>
                <div class="card-content">
                    <div id="profile">
                        <form action="{{ action("StudentActionController@editProfile") }}" method="post">
                            {{ csrf_field() }}
                            <div class="input-field col s3 m2 no-padding">
                                <a class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="点击上传新头像" href="#avatarModal">
                                    <img class="responsive-img" src="{{ $user->image_url?:$setting->avatar }}" alt="avatar" onclick="$('#avatarFile').click()">
                                </a>
                            </div>
                            <div class="col s9 m8">
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
                    <div id="courses">
                        <div class="col m10 offset-m1 s12">
                            <div class="collection with-header">
                                <div class="collection-header"><h4 class="blue-text">已选课程</h4></div>
                            @foreach($studentCourses as $course)
                                <a href="{{ action("StudentViewController@course", $course->id) }}" class="collection-item">{{ $course->name }}<i class="right material-icons">send</i></a>
                            @endforeach
                            </div>
                        </div>
                    </div>
                    <div id="security">
                        <div class="col s12 m10 l8 offset-m1 offset-l2">
                            <form action="{{ action("StudentActionController@changePassword") }}" method="post">
                                {{ csrf_field() }}
                                <div class="input-field">
                                    <i class="material-icons prefix">vpn_key</i>
                                    <label for="oldPassword">原密码</label>
                                    <input class="validate" id="oldPassword" name="oldPassword" type="password" required>
                                </div>
                                <div class="input-field">
                                    <i class="material-icons prefix">vpn_key</i>
                                    <label for="newPassword">新密码</label>
                                    <input class="validate" id="newPassword" name="newPassword" type="password" required>
                                </div>
                                <div class="input-field">
                                    <i class="material-icons prefix">vpn_key</i>
                                    <label for="newPassword_confirmation">重复密码</label>
                                    <input class="validate" id="newPassword_confirmation" name="newPassword_confirmation" type="password" required>
                                </div>
                                <button class="right btn lighten-2 waves-effect waves-light" type="submit" name="action">修改密码</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="avatarModal" style="max-width: 500px;">
        <div class="modal-content">
            <div class="col s12">
                <div class="cropper-container">
                    <img id="avatar" src="{{ $user->image_url?:$setting->avatar }}" alt="avatar">
                </div>
            </div>
            <div class="file-field input-field col s12">
                <div class="btn blue lighten-2 waves-effect waves-light">
                    <span>选择头像</span>
                    <input id="avatarFile" type="file" accept="image/jpeg,image/png,image/gif">
                </div>
                <div class="file-path-wrapper">
                    <label class="hide" for="image_path">图片路径</label>
                    <input class="file-path validate" id="image_path" type="text">
                </div>
            </div>
        </div>
        <div class="modal-footer col s12">
            <button class="right btn blue lighten-2 waves-effect waves-light" onclick="uploadAvatar('{{ action("StudentActionController@editAvatar") }}', '{{ csrf_token() }}')">提交</button>
        </div>
</div>
@endsection
@section('script')
    <script src="{{ asset('js/cropper.min.js') }}"></script>
    <script src="{{ asset('js/avatar.js') }}"></script>
@endsection