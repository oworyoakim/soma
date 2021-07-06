@extends('admin_layout')
@section('title','Manage Course Modules ('. $course->title . ')')
@section('content')
    <app-manage-course-modules
        course-id="{{$course->id}}"
        course-title="{{$course->title}}"
        title="@yield('title')">
    </app-manage-course-modules>
@endsection
