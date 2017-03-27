@extends('common.student')
@section('title'){{ $course->name }} - {{ $setting->name }}@endsection
@section('main')
    <div class="container">
        <div class="row my-header-banner">
            <div class="col s12 m5 offset-m1">
                <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                        <img class="activator responsive-img" src="{{ $course->image_url }}">
                    </div>
                    <div class="card-content">
                        <span class="card-title activator grey-text text-darken-4">{{ $course->name }}<i class="material-icons right">more_vert</i></span>
                    </div>
                    <div class="card-action right-align">
                        <span class="left chip">{{ $teacher->name }}</span>
                        @if($joinStatus)
                            <button class="btn disabled">已加入</button>
                        @else
                            <button class="btn" onclick="joinCourse('{{ action("StudentActionController@joinCourse", $course->id) }}', '{{ csrf_token() }}')">加入课程</button>
                        @endif
                    </div>
                    <div class="card-reveal">
                        <span class="card-title grey-text text-darken-4">{{ $course->name }}<i class="material-icons right">close</i></span>
                        <p>{{ $course->description }}</p>
                    </div>
                </div>
            </div>
            <div class="col s12 m5">
                <div class="card-panel">
                    <h4>课程公告</h4>
                    @if(empty($course->board))
                        <p class="flow-text center-align">暂无公告</p>
                    @else
                        <p>{{ $course->board }}</p>
                    @endif
                </div>
            </div>
        </div>
        <div class="row">
            @if(!empty($teacher->description))
                <div class="col s12 m10 offset-m1">
                    <div class="card-panel">
                        <h4 class="teal-text lighten-2">教师简介</h4>
                        <p>{{ $teacher->description }}</p>
                    </div>
                </div>
            @endif
            <div class="col s12 m10 offset-m1">
                <div class="collection with-header">
                    <div class="teal lighten-2 collection-header"><h4 class="white-text">课程列表</h4></div>
                    @foreach($lessons as $lesson)
                        <a href="{{ action("StudentViewController@lesson", [$lesson->course_id, $lesson->id]) }}" class="collection-item">
                            {{ $lesson->title }}
                            <span class="right">{{ $lesson->created_at->diffForHumans() }}</span>
                        </a>
                    @endforeach
                    {{ $lessons->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection