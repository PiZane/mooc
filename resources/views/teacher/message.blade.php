@extends('common.teacher')
@section('title')私信@endsection
@section('main')
    <main>
        <div class="my-main container">
            <div class="row">
                <div class="col s12">
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
                                @if(!empty($receivedMessages))
                                    <ul class="collapsible" style="box-shadow: none" data-collapsible="accordion">
                                        @foreach($receivedMessages as $message)
                                            @if(!empty($message->studentSender))
                                                <li>
                                                    <div class="collapsible-header"><i class="material-icons">perm_identity</i>来自: {{ $message->studentSender->name }} 同学
                                                        <span class="right">{{ $message->created_at->diffForHumans() }}</span></div>
                                                    <div class="collapsible-body" style="padding: 2em;"><span>{{ $message->content }}</span></div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    {{ $receivedMessages->links() }}
                                @endif
                            </div>
                            <div id="sentMessages">
                                @if(!empty($sentMessages))
                                    <ul class="collapsible" style="box-shadow: none" data-collapsible="accordion">
                                        @foreach($sentMessages as $message)
                                            @if(!empty($message->studentReceiver))
                                                <li>
                                                    <div class="collapsible-header"><i class="material-icons">email</i>发送给: {{ $message->studentReceiver->name }} 同学
                                                        <span class="right">{{ $message->created_at->diffForHumans() }}</span></div>
                                                    <div class="collapsible-body" style="padding: 2em;"><span>{{ $message->content }}</span></div>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                    {{ $sentMessages->links() }}
                                @endif
                            </div>
                            <div id="writeMessage">
                                <form action="{{ action("TeacherActionController@sendMessage") }}" method="post">
                                    {{csrf_field()}}
                                    <div class="col s12 m10 offset-m1">
                                        <div class="input-field">
                                            <i class="material-icons prefix">picture_in_picture</i>
                                            <label for="school_id">学号</label>
                                            <input class="validate" id="school_id" name="school_id" type="text" required>
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
    </main>
@endsection