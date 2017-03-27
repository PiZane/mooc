<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/css/materialize.min.css">
    <link rel="stylesheet" href="{{ asset("./css/style.css") }}">
    <link href="https://cdn.bootcss.com/material-design-icons/3.0.1/iconfont/material-icons.min.css" rel="stylesheet">
    <title>@yield('title')</title>
</head>
<body>
<main class="valign-wrapper">
    <div class="valign container">
        <div class="row">
            <div class="card col s12 m10 l6 offset-m1 offset-l3">
                @yield('main')
            </div>
        </div>
    </div>
</main>
</body>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.8/js/materialize.min.js"></script>
<script src="{{ asset("./js/main.js") }}"></script>
@if (count($errors) > 0)
    <script>
        @foreach ($errors->all() as $error)
            Materialize.toast('{{ $error }}', 10000, 'red');
        @endforeach
    </script>
@endif
</html>