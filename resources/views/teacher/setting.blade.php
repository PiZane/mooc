@extends('common.teacher')
@section('title')站点设置@endsection
@section('main')
    <main class="valign-wrapper">
        <div class="my-main valign container">
            <div class="row">
                <div class="card col s12 m10 l8 offset-m1 offset-l2">
                    <div class="col s12">
                        <h2 class="blue-text text-lighten-2 center">站点信息配置</h2>
                    </div>
                    <form id="setting" class="my-sign col s10 offset-s1">
                        <div class="input-field">
                            <i class="material-icons prefix">view_headline</i>
                            <label for="name">站点名称</label>
                            <input class="validate" id="name" name="name" type="text" value="{{ $setting->name }}" required>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">subtitles</i>
                            <label for="title">首页标题</label>
                            <input class="validate" id="title" name="title" type="text" value="{{ $setting->title }}" required>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">vpn_key</i>
                            <label for="keywords">站点关键字</label>
                            <input class="validate" id="keywords" name="keywords" type="text" value="{{ $setting->keywords }}">
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">description</i>
                            <label for="description">站点描述</label>
                            <textarea class="materialize-textarea" id="description" name="description">{{ $setting->description }}</textarea>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">view_agenda</i>
                            <label for="footer">底部信息</label>
                            <textarea class="materialize-textarea" id="footer" name="footer">{{ $setting->footer }}</textarea>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">perm_identity</i>
                            <label for="avatar">默认头像链接</label>
                            <input class="validate" id="avatar" name="avatar" type="text" value="{{ $setting->avatar }}">
                        </div>
                        <div id="links" class="input-field col s12">
                            <h6>友情链接</h6>
                            @foreach($setting->links as $name => $link)
                                <input class="name col s3" type="text" value="{{ $name }}" placeholder="链接名称">
                                <input class="link col s8 offset-s1" type="text" value="{{ $link }}" placeholder="链接地址">
                            @endforeach
                        </div>
                        <div class="right-align">
                            <a class="btn-floating btn-large waves-effect waves-light" onclick="addLink()"><i class="material-icons">add</i></a>
                        </div>
                        <div class="input-field right">
                            <a class="right btn blue lighten-2 waves-effect waves-light" onclick="changeSetting('{{ action("TeacherActionController@setting") }}', '{{ csrf_token() }}')">修改配置</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection