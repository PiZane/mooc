@extends('common.student')
@section('title'){{ $lesson->title }}@endsection
@section('main')
    <div class="container">
        <div class="row">
            <div class="col s12">
                <nav class="my-header-banner" style="margin-bottom: 2em">
                    <div class="nav-wrapper teal lighten-2">
                        <div class="col s12">
                            <a href="{{ url('/') }}" class="breadcrumb">首页</a>
                            <a href="{{ action("StudentViewController@course", $course->id) }}" class="breadcrumb">{{ $course->name }}</a>
                            <a href="{{ action("StudentViewController@lesson", [$course->id, $lesson->id]) }}" class="breadcrumb">{{ $lesson->title }}</a>
                        </div>
                    </div>
                </nav>
            </div>
            @if($lesson->type)
                <div class="col s12">
                    <div class="card my-lesson">
                        <div style="margin: 2em;font-size: 20px;">
                            <h2 class="center-align">{{ $lesson->title }}</h2>
                            <div class="center-align">
                                <div class="chip">发布教师: {{ $course->teacher()->first()->name }}</div>
                                <div class="chip">创建时间: {{ $course->created_at->diffForHumans() }}</div>
                            </div>
                            {!! $lesson->text_content !!}
                        </div>
                    </div>
                </div>
            @else
                <div class="col s12">
                    @if($lesson->video_url)
                        <video class="responsive-video" width="100%" controls>
                            <source src="{{ $lesson->video_url }}" type="video/mp4">
                        </video>
                    @else
                        <div class="video-container">
                            {!! $lesson->video_content !!}
                        </div>
                    @endif
                </div>
            @endif
        </div>
        @if(!empty($lesson->board))
            <div class="col s12">
                <div class="card-panel">
                    <h4 class="teal-text">本课时公告</h4>
                    <p>{{ $lesson->board }}</p>
                </div>
            </div>
        @endif
        <div class="row" id="lessonMenu">
            <div class="col s12">
                <ul class="tabs my-menu-tabs tabs-transparent teal lighten-2 white-text">
                    <li class="tab col s3"><a href="#courseList">课程列表</a></li>
                    <li class="tab col s3"><a href="#topCommentsTab">置顶回复</a></li>
                    <li class="tab col s3"><a href="#commentsTab">评论列表</a></li>
                </ul>
            </div>
            <div class="col s12" id="courseList">
                <div class="collection">
                    @foreach($lessons as $item)
                        <a href="{{ action("StudentViewController@lesson", [$item->course_id, $item->id]) }}" class="collection-item">
                            {{ $item->title }}
                            <span class="right">{{ $item->created_at->diffForHumans() }}</span>
                        </a>
                    @endforeach
                    {{ $lessons->links() }}
                </div>
            </div>
            <div class="col s12" id="topCommentsTab">
                <div id="topComments">

                </div>
            </div>
            <div class="col s12" id="commentsTab">
                <div id="comments">

                </div>
                <div id="postComment">
                    <div class="col s12 m10 l8">
                        <h4 class="blue-text center-align">发表评论</h4>
                        <form id="commentForm" action="{{ action("StudentActionController@comment") }}" method="post">
                            {{ csrf_field() }}
                            <input type="hidden" id="lessonId" name="lessonId" value="{{ $lesson->id }}">
                            <input type="hidden" id="replyId" name="replyId" value="">
                            <div>
                                <div class="input-field col s12" onclick="clearReply('{{ $lesson->title }}')">
                                    <i class="material-icons prefix">view_headline</i>
                                    <label for="reply">回复</label>
                                    <input class="validate" id="reply" name="reply" type="text" value="{{ $lesson->title }}" required disabled>
                                </div>
                            </div>
                            <div>
                                <div class="input-field col s12">
                                    <i class="material-icons prefix">description</i>
                                    <label for="commentContent">评论内容</label>
                                    <textarea class="materialize-textarea" id="commentContent" name="commentContent"></textarea>
                                    <a class="right btn blue lighten-2 waves-effect waves-light" onclick="submitComment()">发表评论</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var url    = '{{ action("StudentViewController@comment", $lesson->id) }}';
        var avatar = '{{ $setting->avatar }}';
        var str    = '{!! $topComments !!}';
    </script>
    <script src="{{ asset('js/comment.js') }}"></script>
@endsection