<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Page;

class PostController extends Controller
{
  public function save(Request $request)
  {
    $request->validateWithBag('savePost', [
      'content' => 'required|string',
      'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
    ]);

    if (Page::where('name', 'home')->first() != null) {
      return $this->saveToExisting($request);
    }

    $page = new Page();
    $page->name = 'home';
    $this->saveDetails($request, $page);
    return Redirect::route('home');
  }

  public function saveDetails(Request $request, Page $page)
  {
    $photo_name = $request->photo->getClientOriginalName();
    $path = $request->file('photo')->storeAs('public/home', $photo_name);
    $page->image_path = substr($path, 7);
    $page->image_name = $photo_name;
    $page->html = $request->content;
    $page->save();
  }

  public function saveToExisting(Request $request)
  {
    $page = Page::where('name', 'home')->first();
    $this->saveDetails($request, $page);
    return Redirect::route('home');
  }

  public function getHomePage()
  {
    if (Page::where('name', 'home')->first() != null) {
      return \Inertia\Inertia::render('Home', [
        'home_page_html' => Page::where('name', 'home')->first()->html,
        'image_path' =>  Page::where('name', 'home')->first()->image_path,
      ])->withViewData(['testingGA' => 'UA-testingGA']);
    }
    return \Inertia\Inertia::render('Home');
  }

  public function edit()
  {
    if (Page::where('name', 'home')->first() != null) {
      return \Inertia\Inertia::render('Edit/Show', [
        'pageHtml' => Page::where('name', 'home')->first()->html,
        'pagePhotoPath' => Page::where('name', 'home')->first()->image_path,
        'name' => 'home'
      ]);
    }
    return \Inertia\Inertia::render('Edit/Show', [
      'page' => '',
      'pagePhotoPath' => '',
      'name' => 'home'
    ]);
  }

  public function deletePhoto(Request $request)
  {
    $page = Page::where('name', 'home')->first();
    $photo_path = $page->image_path;
    Storage::delete($photo_path);
    $page->image_path = '';
    $page->image_name = '';
    $page->save();
    return Redirect::route('editHome');
  }

  public function deletePost(Request $request)
  {
    $page = Page::where('name', 'home')->first();
    $page->delete();

    return \Inertia\Inertia::render('Home');
  }
}
