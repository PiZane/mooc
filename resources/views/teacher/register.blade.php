@extends('common.teacherAuth')
@section('main')
<div class="col s12">
    <h2 class="blue-text text-lighten-2 center">教师注册</h2>
</div>
<form class="my-sign col s10 offset-s1" method="post">
    {{ csrf_field() }}
    <div class="input-field">
        <i class="material-icons prefix">account_circle</i>
        <label for="name">姓名</label>
        <input class="validate" id="name" name="name" type="text" required>
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
    <div class="input-field right">
        <button class="right btn blue lighten-2 waves-effect waves-light" type="submit" name="action">注册</button>
    </div>
</form>
@endsection