@extends('admin_layout')
@section('title', 'Manage Course ('. $course->title . ')')
@section('content')
    <app-manage-course
        course-id="{{$course->id}}"
        course-title="{{$course->title}}"
        title="@yield('title')">
    </app-manage-course>
@endsection
