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
                            <div id="receivedMessagesDiv"></div>
                        </div>
                        <div id="sentMessages">
                            <div id="sentMessagesDiv"></div>
                        </div>
                        <div id="writeMessage">
                            <form action="{{ action("StudentActionController@sendMessage") }}" method="post">
                                {{csrf_field()}}
                                <div class="col s12 m10 offset-m1">
                                    <div class="input-field">
                                        <i class="material-icons prefix">view_headline</i>
                                        <label class="hide" for="teacherId">选择发送教师</label>
                                        <select class="icons" id="teacherId" name="teacherId">
                                            <option disabled selected>选择教师</option>
                                            @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}" data-icon="{{ $teacher->image_url?:$setting->avatar }}" class="left circle">{{ $teacher->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="input-field">
                                        <i class="material-icons prefix">description</i>
                                        <label for="messageContent">内容</label>
                                        <textarea class="materialize-textarea" id="messageContent" name="messageContent"></textarea>
                                    </div>
                                    <button class="right btn lighten-2 waves-effect waves-light" type="submit">发送私信</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{ asset('js/message.js') }}"></script>
    <script>getMessages('{{ action("StudentViewController@getReceivedMessages") }}')</script>
    <script>getMessages('{{ action("StudentViewController@getSentMessages") }}')</script>
@endsection
