@extends('common.teacher')
@section('title'){{ $lesson->title }}@endsection
@section('main')
    <main>
        <div class="my-main">
            <div class="row">
                <div class="col s12">
                    <h3 class="blue-text text-lighten-2 center">
                        <a href="{{ action("TeacherViewController@courseInfo", $course->id) }}">{{ $course->name }}</a>
                        <span> - </span>
                        <a href="{{ action("TeacherViewController@lessonInfo", [$course->id, $lesson->id]) }}">{{ $lesson->title }}</a>
                    </h3>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <ul class="tabs my-menu-tabs">
                        <li class="tab col s4"><a class="{{ $lesson->type?'active':null }}" href="#doc">图文类型</a></li>
                        <li class="tab col s4"><a class="{{ $lesson->type?null:'active' }}" href="#video">视频类型</a></li>
                    </ul>
                </div>
                <div id="doc" class="col s12">
                    <form class="my-sign col s10 offset-s1" method="post" enctype="multipart/form-data" action="{{ action("TeacherActionController@editLesson", $lesson->id) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="type" value="1">
                        <div class="input-field">
                            <i class="material-icons prefix">subtitles</i>
                            <label for="text-title">课时标题</label>
                            <input class="validate" id="text-title" name="title" type="text" value="{{ $lesson->title }}" required>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">picture_in_picture</i>
                            <label for="text-image_url">封面图片链接</label>
                            <input class="validate" id="text-image_url" name="image_url" type="text" value="{{ $lesson->image_url }}" placeholder="可空, 封面图片超链接, 默认为课程封面图片">
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">description</i>
                            <label for="text-board">课时公告</label>
                            <textarea class="materialize-textarea" id="text-board" name="board" placeholder="可空, 本课时公告, 默认为空">{{ $lesson->board }}</textarea>
                        </div>
                        <div class="input-field">
                            <h5>课时内容</h5>
                            <script id="editor" name="text_content" type="text/plain">{!! $lesson->text_content !!}</script>
                        </div>
                        <div class="input-field right">
                            <button class="right btn blue lighten-2 waves-effect waves-light" type="submit" name="action">修改课时</button>
                        </div>
                    </form>
                </div>
                <div id="video" class="col s12">
                    <form class="my-sign col s10 offset-s1" method="post" enctype="multipart/form-data" action="{{ action("TeacherActionController@editLesson", $lesson->id) }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="type" value="0">
                        <div class="input-field">
                            <i class="material-icons prefix">subtitles</i>
                            <label for="video-title">课时标题</label>
                            <input class="validate" id="video-title" name="title" type="text" value="{{ $lesson->title }}" required>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">picture_in_picture</i>
                            <label for="video-image_url">封面图片链接</label>
                            <input class="validate" id="video-image_url" name="image_url" type="text" value="{{ $lesson->image_url }}" placeholder="可空, 封面图片超链接, 默认为课程封面图片">
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">description</i>
                            <label for="video-board">课时公告</label>
                            <textarea class="materialize-textarea" id="video-board" name="board" placeholder="可空, 本课时公告, 默认为空">{{ $lesson->board }}</textarea>
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">videocam</i>
                            <label for="video-video_url">视频链接</label>
                            <input class="validate" id="video-video_url" name="video-video_url" type="text" value="{{ $lesson->video_url }}" placeholder="可空,视频链接和HTML视频代码至少填写一项,默认视频链接优先">
                        </div>
                        <div class="input-field">
                            <i class="material-icons prefix">video_library</i>
                            <label for="video-video_content">html视频代码</label>
                            <textarea class="materialize-textarea" id="video-video_content" name="video_content" type="text" placeholder="可空,视频链接和HTML视频代码至少填写一项,默认视频链接优先">{{ $lesson->video_content }}</textarea>
                        </div>
                        <div class="input-field right">
                            <button class="right btn blue lighten-2 waves-effect waves-light" type="submit" name="action">修改课时</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    @include('UEditor::head')
    <!-- 实例化编辑器 -->
    <script type="text/javascript">
        var ue = UE.getEditor('editor',{
                serverUrl:'{{ url('laravel-u-editor-server/server') }}',
                autoHeightEnabled: true,
                autoFloatEnabled: true,
                scaleEnabled: true,
                initialFrameWidth: '100%',
                initialFrameHeight: 540
            }
        );
        ue.ready(function() {
            ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');
        });
    </script>
@endsection