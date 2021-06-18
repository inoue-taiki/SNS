<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    
    //投稿者のみしか編集できないようにする記述
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'delete']);
        $this->middleware('can:update,list')->only(['edit', 'update']);
        $this->middleware('verified')->only('create');
    }
}
