<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Page;

class PostController extends Controller
{
    public function save(Request $request)
    {
        if ($request->hasFile('photo')) {
            $validated = $request->validate([
                'photo' => 'mimes:jpeg,png|max:1014',
                'content' => 'string'
            ]);
            $photo_name = $request->photo->getClientOriginalName();
            $extension = $request->photo->extension();
            $request->photo->storeAs('/public/home', $photo_name);

            $url = Storage::url($photo_name);
            $page = Page::where('name', 'home')->first();
            $page->html = $request->content;
            $page->name = 'home';
            $page->image_path = $url;
            $page->image_name = $photo_name;
            $page->save();

            return 'The page was saved';
        }
        return 'please upload an image';
    }

    public function getHomePage()
    {
        return \Inertia\Inertia::render('Home', [
            'home_page_html' => Page::where('name', 'home')->first()->html,
            'image_path' =>  Page::where('name', 'home')->first()->image_path,
        ]);
    }

    public function getContactPage()
    {
        return \Inertia\Inertia::render('Contact/Show', [
            'image_path' => '../img/contact.jpg'
        ]);
    }

    public function edit()
    {
        return \Inertia\Inertia::render('Edit/Show', [
            'page' => Page::where('name', 'home')->first()->html,
        ]);
    }
}
