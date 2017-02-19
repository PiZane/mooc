<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.bootcss.com/material-design-icons/3.0.1/iconfont/material-icons.min.css" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>
<header>
    <div class="container">
        <a href="#" data-activates="nav-mobile" class="button-collapse top-nav waves-effect waves-light circle hide-on-large-only">
            <i class="material-icons">menu</i>
        </a>
    </div>
    <ul id="nav-mobile" class="my-side side-nav fixed" style="transform: translateX(0%);">
        <li class="logo">
            <div class="brand-logo">
                <h3>管理后台</h3>
            </div>
        </li>
        <li class="bold"><a href="{{ action("TeacherViewController@course") }}">课程管理</a></li>
        @if($teacher->admin)
            <li class="bold"><a href="{{ action("TeacherViewController@setting") }}" class="waves-effect waves-teal">站点设置</a></li>
        @endif
        <li class="bold"><a href="#" class="waves-effect waves-teal">私信</a></li>
        <li class="bold"><a href="{{ action("TeacherAuth\\TLoginController@logout") }}" class="waves-effect waves-teal">注销</a></li>
    </ul>
</header>
@yield('main')
</body>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
<script src="{{ asset('js/main.js') }}"></script>
@if (session('status'))
<script>
    Materialize.toast('{{ session('status') }}', 3000);
</script>
@endif
@yield('script')
</html>
