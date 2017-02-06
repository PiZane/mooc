@extends('common.student')
@section('title'){{ $setting->title }}@endsection
@section('main')
    <div class="section red lighten-5" id="index-banner">
        <div class="row">
            <div class="container">
                <div class="col s12 m9">
                    <h1 class="header center-on-small-only">{{ $setting->name }}</h1>
                    <h4 class="light red-text text-lighten-4 center-on-small-only">学习，为更好的将来</h4>
                </div>
            </div>
            @if($lessons->count())
            <div class="col s12 m3 hide-on-med-and-down">
                <div class="card small">
                    <div class="card-image waves-effect waves-block waves-light">
                        <a href="{{ action("StudentViewController@lesson", [$lessons[0]->course_id, $lessons[0]->id]) }}"><img class="activator" src="{{ $lessons[0]->getImage() }}"></a>
                    </div>
                    <div class="card-content">
                        <p class="card-title">{{ $lessons[0]->title }}</p>
                        <div class="right-align">
                            <a class="btn teal accent-4" href="{{ action("StudentViewController@lesson", [$lessons[0]->course_id, $lessons[0]->id]) }}">
                                <i class="left material-icons">visibility</i>查看课程
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="container">
        <div class="my-header-banner card-panel teal lighten-2">
            <h5 class="white-text">教学课程</h5>
        </div>
        <div class="row">
            @foreach($lessons as $lesson)
            <div class="col s12 m6 l4">
                <div class="card small hoverable">
                    <div class="card-image waves-effect waves-block waves-light">
                        <a href="{{ action("StudentViewController@lesson", [$lesson->course_id, $lesson->id]) }}"><img class="activator" src="{{ $lesson->getImage() }}"></a>
                    </div>
                    <div class="card-content">
                        <p class="card-title activator">{{ $lesson->title }}</p>
                        <div class="right-align">
                            <a class="btn teal accent-4" href="{{ action("StudentViewController@lesson", [$lesson->course_id, $lesson->id]) }}">
                                <i class="left material-icons">visibility</i>查看课程
                            </a>
                        </div>
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
@endsection