@extends('admin_layout')
@section('title','Manage Course Topics ('. $course->title . ')')
@section('content')
    <app-manage-course-topics
        course-id="{{$course->id}}"
        course-title="{{$course->title}}"
        title="@yield('title')">
    </app-manage-course-topics>
@endsection
