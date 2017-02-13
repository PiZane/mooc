@extends('common.student')
@section('title')我的私信 | {{ $setting->name }}@endsection
@section('main')
    <div class="container">
        <div class="row">
            <div class="col s12 m10 offset-m1">
                <div class="card col s12 white my-header-banner" style="padding-bottom: 2em">
                    <div class="card-tabs">
                        <ul class="tabs my-menu-tabs tabs-fixed-width">
                            <li class="tab"><a class="active" href="#receivedMessages">已接收</a></li>
                            <li class="tab"><a href="#sentMessages">已发送</a></li>
                            <li class="tab"><a href="#writeMessage">写私信</a></li>
                        </ul>
                    </div>
                    <div class="card-content">
                        <div id="receivedMessages">

                        </div>
                        <div id="sentMessages">

                        </div>
                        <div id="writeMessage">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
