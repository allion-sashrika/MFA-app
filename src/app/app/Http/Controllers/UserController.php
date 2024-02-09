<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class UserController extends Controller 
{
    public function index() {
        return view('user.index');
    }

    public function userProfile() {
        return view('user.profile');
    }
}