<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
    <link href="https://cdn.bootcss.com/material-design-icons/3.0.1/iconfont/material-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title>@yield('title')</title>
</head>
<body class="grey lighten-3">
<header>
    <nav class="nav-extended">
        <div class="nav-wrapper blue lighten-2">
            <a href="{{ url('/') }}" class="brand-logo">{{ $setting->name }}</a>
            <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
            <ul class="right hide-on-med-and-down" id="nav-mobile">
                @if(empty($user))
                    <li><a class="btn teal accent-4 wavess-effect waves-light" href="#studentLogin">登录</a></li>
                    <li><a class="btn teal accent-4 waves-effect waves-light" href="#studentRegister">注册</a></li>
                @else
                    <li>欢迎回来, {{ $user->name }} {{ $user->type?'教师':'同学' }}</li>
                    <li><a class="btn teal accent-4 waves-effect waves-light" href="{{ action("StudentViewController@profile") }}">个人主页</a></li>
                    <li><a class="btn teal accent-4 waves-effect waves-light" href="{{ action("StudentAuth\\SLoginController@logout") }}">注销</a></li>
                @endif
            </ul>
            <ul class="side-nav" id="mobile-demo">
                @if(empty($user))
                    <li><a href="#studentLogin"><i class="left material-icons">perm_identity</i>登录</a></li>
                    <li><a href="#studentRegister"><i class="left material-icons">email</i>注册</a></li>
                @else
                    <li><h4 class="blue-text">{{ $user->name }}</h4></li>
                    <li><a href="{{ action("StudentViewController@profile") }}"><i class="left material-icons">perm_identity</i>个人主页</a></li>
                    <li><a href="{{ action("StudentAuth\\SLoginController@logout") }}"><i class="left material-icons">input</i>注销</a></li>
                @endif
            </ul>
            <ul class="my-menu-tabs row tabs tabs-transparent">
                <li class="tab col l1"><a onclick="clickTab('{{ url('/') }}')">首页</a></li>
                @foreach($courses as $course)
                    <li class="tab col l1">
                        @if(!empty($courseId) && $course->id == $courseId)
                            <a class="active" onclick="clickTab('{{ action("StudentViewController@course", $course->id) }}')">{{ $course->name }}</a>
                        @else
                            <a onclick="clickTab('{{ action("StudentViewController@course", $course->id) }}')">{{ $course->name }}</a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>
</header>
<main>
    @yield('main')
</main>
<div class="row">
    <div class="modal" id="studentLogin" style="max-width: 500px">
        <form method="post" action="{{ action("StudentAuth\\SLoginController@login") }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <h3 class="blue-text text-lighten-2 center">学生登录</h3>
                <div class="col m6 offset-m3 s12">
                    <div class="input-field">
                        <i class="material-icons prefix">email</i>
                        <label for="email">电子邮件</label>
                        <input class="validate" id="email" name="email" type="email" required>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <label for="password">密码</label>
                        <input class="validate" id="password" name="password" type="password" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer col s12">
                <button class="right btn blue lighten-2 waves-effect waves-light" type="submit" name="action">登录</button>
            </div>
        </form>
    </div>
    <div class="modal modal-fixed-footer" id="studentRegister">
        <form method="post" action="{{ action("StudentAuth\\SRegisterController@register") }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <h3 class="blue-text text-lighten-2 center">学生注册</h3>
                <div class="col m6 offset-m3 s12">
                    <div class="input-field">
                        <i class="material-icons prefix">account_circle</i>
                        <label for="name">姓名</label>
                        <input class="validate" id="name" name="name" type="text" required>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">picture_in_picture</i>
                        <label for="school_id">学号</label>
                        <input class="validate" id="school_id" name="school_id" type="text" required>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">recent_actors</i>
                        <label for="class">班级</label>
                        <input class="validate" id="class" name="class" type="text" required>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">email</i>
                        <label for="email">电子邮件</label>
                        <input class="validate" id="email" name="email" type="email" required>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <label for="password">密码</label>
                        <input class="validate" id="password" name="password" type="password" required>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">vpn_key</i>
                        <label for="password_confirmation">重复密码</label>
                        <input class="validate" id="password_confirmation" name="password_confirmation" type="password" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="right btn blue lighten-2 waves-effect waves-light" type="submit" name="action">注册</button>
            </div>
        </form>
    </div>
</div>
<footer class="page-footer blue lighten-2">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">{{ $setting->footer }}</h5>
                <p class="grey-text text-lighten-4">{{ $setting->description }}</p>
            </div>
            <div class="col l4 offset-l2 s12">
                <h5 class="white-text">友情链接</h5>
                <ul>
                    @foreach($setting->links as $title => $url)
                    <li><a class="grey-text text-lighten-3" href="{{ $url }}" target="_blank">{{ $title }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2017 Copyright LinkWorld
            <a class="grey-text text-lighten-4 right" href="#">备案号 ICP</a>
        </div>
    </div>
</footer>
</body>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
@if (session('status'))
    <script>
        Materialize.toast('{{ session('status') }}',3000);
    </script>
@endif
@if (count($errors) > 0)
    <script>
        @foreach ($errors->all() as $error)
            Materialize.toast('{{ $error }}',3000);
        @endforeach
    </script>
@endif
@yield('script')
</html>