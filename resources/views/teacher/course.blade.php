@extends('common.teacher')
@section('title')课程管理@endsection
@section('main')
<main>
    <div class="my-main container">
        <div class="row card">
            <div class="col s12">
                <h3 class="blue-text text-lighten-2 center">课程管理</h3>
            </div>
            <div class="col s6 offset-s6">
            <a class="right modal-trigger waves-effect waves-light btn" href="#createCourseModal">创建课程</a>
            </div>
            <table class="highlight">
                <thead>
                <tr>
                    <th>课程名称</th>
                    <th>创建时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                        <tr>
                            <td><span class="flow-text" style="margin-left: 1rem">{{ $course->name }}</span></td>
                            <td><span class="flow-text">{{ $course->created_at->diffForHumans() }}</span></td>
                            <td>
                                <a class="btn blue" href="{{ action("TeacherViewController@courseInfo", ['courseId'=>$course->id]) }}">查看课程</a>
                                <a class="btn" href="{{ action("TeacherViewController@createLesson", ['courseId'=>$course->id]) }}">添加课时</a>
                            </td>
                        </tr>
                    @endforeach
                @if(count($courses) === 0)
                    <tr>
                        <td colspan="3"><p class="center">暂无课程</p></td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="modal modal-fixed-footer" id="createCourseModal">
        <form method="post" enctype="multipart/form-data" action="{{ action("TeacherActionController@createCourse") }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <h3 class="blue-text text-lighten-2 center">创建课程</h3>
                    <div class="file-field input-field">
                        <div class="btn">
                            <span>上传图片</span>
                            <input type="file" name="image" accept="image/jpeg,image/png,image/gif" required>
                        </div>
                        <div class="file-path-wrapper">
                            <label class="hide" for="image_path">图片路径</label>
                            <input class="file-path validate" id="image_path" type="text">
                        </div>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">subtitles</i>
                        <label for="name">课程名称</label>
                        <input class="validate" id="name" name="name" type="text" required>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">description</i>
                        <label for="description">课程简介</label>
                        <textarea class="materialize-textarea" id="description" name="description"></textarea>
                    </div>
                    <div class="input-field">
                        <i class="material-icons prefix">view_agenda</i>
                        <label for="broad">公告</label>
                        <textarea class="materialize-textarea" id="broad" name="broad"></textarea>
                    </div>
            </div>
            <div class="modal-footer">
                <button class="right btn blue lighten-2 waves-effect waves-light" type="submit" name="action">创建课程</button>
            </div>
        </form>
    </div>
</main>
@endsection