@extends('common.teacher')
@section('title')查看课程@endsection
@section('main')
    <main>
        <div class="my-main container">
            <div class="row">
                <div class="col s12">
                    <div class="card medium horizontal">
                        <div class="card-image hide-on-small-only">
                            <img class="responsive-img" src="{{ $course->image_url }}">
                        </div>
                        <div class="card-stacked">
                            <div class="card-content">
                                <h3 class="header">{{ $course->name }}</h3>
                                <div class="chip">创建用户: {{ $course->teacher()->first()->name }}</div>
                                <div class="chip">创建时间: {{ $course->created_at }}</div>
                                <p><br/>{{ $course->description }}</p>
                            </div>
                            <div class="card-action" style="position: relative;">
                                <a class="modal-trigger waves-effect waves-light btn" href="#editCourseModal">修改课程</a>
                                <a class="modal-trigger waves-effect waves-light btn" href="{{ action("TeacherViewController@createLesson", $course->id) }}">添加章节</a>
                                <a class="modal-trigger waves-effect waves-light btn red" onclick="deleteAlert('{{ action("TeacherActionController@deleteCourse", $course->id) }}', '{{ csrf_token() }}')">删除课程</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div class="collection with-header">
                        <div class="teal lighten-2 collection-header"><h4 class="white-text">章节管理</h4></div>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach($lessons as $lesson)
                    <div class="col s12 m4">
                        <div class="card small">
                            <div class="card-image">
                                <img src="{{ $lesson->getImage() }}">
                            </div>
                            <div class="card-content">
                                <span class="card-title">{{ $lesson->title }}</span>
                            </div>
                            <div class="card-action">
                                <a href="{{ action("TeacherViewController@lessonInfo", [$course->id, $lesson->id]) }}">查看章节</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col s12">
                    {{ $lessons->links() }}
                </div>
            </div>
        </div>
        <div class="modal modal-fixed-footer" id="editCourseModal">
            <form method="post" enctype="multipart/form-data" action="{{ action("TeacherActionController@editCourse", ['courseId'=>$course->id]) }}">
                {{ csrf_field() }}
                <div class="modal-content">
                    <h3 class="blue-text text-lighten-2 center">修改课程</h3>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>上传图片</span>
                            <input type="file" name="image" accept="image/jpeg,image/png,image/gif">
                        </div>
                        <div class="file-path-wrapper">
                            <label class="hide" for="image_path">图片路径</label>
                            <input class="file-path validate" id="image_path" type="text" value="{{ $course->image_url }}">
                        </div>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">subtitles</i>
                        <label for="name">课程名称</label>
                        <input class="validate" id="name" name="name" type="text" value="{{ $course->name }}" required>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">description</i>
                        <label for="description">课程简介</label>
                        <textarea class="materialize-textarea" id="description" name="description">{{ $course->description }}</textarea>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">view_agenda</i>
                        <label for="broad">公告</label>
                        <textarea class="materialize-textarea" id="broad" name="broad">{{ $course->broad }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="right btn blue lighten-2 waves-effect waves-light" type="submit" name="action">修改课程</button>
                </div>
            </form>
        </div>
    </main>
@endsection