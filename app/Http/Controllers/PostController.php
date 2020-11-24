<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;

class PostController extends Controller
{
    public function save(Request $request)
    {
        dd($request->content);
        $page = Page::where('name', 'home')->first();
        $page->html = $request->content;
        $page->name = 'home';
        $page->image_path = 'testing/path';
        $page->image_name = 'home.jpg';
        $page->save();
        return 'The page was saved';
    }
}
