<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Page;

class PostController extends Controller
{
  public function __construct()
  {
    $this->homePage = Page::where('name', 'home')->first();
  }
  public function save(Request $request)
  {
    $request->validateWithBag('savePost', [
      'content' => 'required|string',
      'photo' => [Rule::requiredIf($this->homePage == null), 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
      'title' => 'required|string',
      'description' => 'required|string',
    ]);

    if ($this->homePage != null) {
      return $this->saveToExisting($request);
    }

    $page = new Page();
    $page->name = 'home';
    $this->saveDetails($request, $page);
    return Redirect::route('home');
  }

  public function saveDetails(Request $request, Page $page)
  {
    if ($request->has('photo')) {
      $photo_name = $request->photo->getClientOriginalName();
      $path = $request->file('photo')->storeAs('public/home', $photo_name);
      $page->image_path = substr($path, 7);
      $page->image_name = $photo_name;
    }
    $page->html = $request->content;
    $page->title = $request->title;
    $page->description = $request->description;
    $page->save();
  }

  public function saveToExisting(Request $request)
  {
    $page = $this->homePage;
    $this->saveDetails($request, $page);
    return Redirect::route('home');
  }

  public function show()
  {
    if ($this->homePage != null) {
      return \Inertia\Inertia::render('Home', [
        'home_page_html' => $this->homePage->html,
        'image_path' =>  $this->homePage->image_path,
      ])->withViewData(['meta' => $this->homePage->description, 'title' => $this->homePage->title ]);
    }
    return \Inertia\Inertia::render('Home');
  }

  public function edit()
  {
    if ($this->homePage != null) {
      return \Inertia\Inertia::render('Edit/Show', [
        'pageHtml' => $this->homePage->html,
        'pagePhotoPath' => $this->homePage->image_path,
        'name' => 'home',
        'title' => $this->homePage->title,
        'description' => $this->homePage->description
      ]);
    }
    return \Inertia\Inertia::render('Edit/Show', [
      'page' => '',
      'pagePhotoPath' => '',
      'name' => 'home',
      'title' => '',
      'description' => ''
    ]);
  }

  public function deletePhoto(Request $request)
  {
    $page = $this->homePage;
    $photo_path = $page->image_path;
    Storage::delete($photo_path);
    $page->image_path = '';
    $page->image_name = '';
    $page->save();
    return Redirect::route('editHome');
  }

  public function deletePost(Request $request)
  {
    $page = $this->homePage;
    $page->delete();

    return \Inertia\Inertia::render('Home');
  }
}
