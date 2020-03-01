<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    //

    public function __construct()
    {
        parent::__construct();
    }
    public function chat()
    {
        return view('admin.chat.chat');
    }
}
