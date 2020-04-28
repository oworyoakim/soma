<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index() {
        return view('layout');
    }

    public function takeExam($slug) {
        return view('exam',compact('slug'));
    }
}
