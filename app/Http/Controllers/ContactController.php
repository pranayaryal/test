<?php

namespace App\Http\Controllers;

use App\Mail\ContactSent;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class ContactController extends Controller
{
  public function __construct()
  {
    $this->contactPage = Page::where('name', 'contact')->first();
  }


  public function show()
  {
    if ($this->contactPage != null) {
      return \Inertia\Inertia::render('Contact/Show', [
        'email' =>  $this->contactPage->email,
        'phone' =>  $this->contactPage->phone,
        'image_path' =>  $this->contactPage->image_path,
        'title' =>  $this->contactPage->title,
        'description' =>  $this->contactPage->description,
      ])->withViewData(
        ['meta' => $this->contactPage->description, 
        'title' => $this->contactPage->title,
        'ga' => $this->getAnalytics()['ga'],
        'fbPixelId' => $this->getAnalytics()['fbPixelId']]);
    }

    return \Inertia\Inertia::render('Contact/Show', [
      'email' =>  '',
      'phone' =>  '',
      'image_path' => '',
    ]);
  }

  public function edit()
  {
    if ($this->contactPage != null) {
      return \Inertia\Inertia::render('Contact/Edit', [
        'email' => $this->contactPage->email,
        'pagePhotoPath' => $this->contactPage->image_path,
        'phone' => $this->contactPage->phone,
        'title' => $this->contactPage->title,
        'description' => $this->contactPage->description,
      ])->withViewData(['meta' => $this->contactPage->description, 'title' => $this->contactPage->title ]);
    }
    return \Inertia\Inertia::render('Contact/Edit', [
      'email' => '',
      'pagePhotoPath' => '',
      'phone' => '',
      'title' => '',
      'description' => ''
    ]);
  }

  public function save(Request $request)
  {
    $request->validateWithBag('saveContactDetails', [
      'photo' => [Rule::requiredIf($this->contactPage == null), 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
      'email' => 'required|email:rfc,dns',
      'phone' => 'required|string',
      'title' => 'required|string',
      'description' => 'required|string',

    ]);

    // Validator::make($request->all(), [

    // ])->validateWithBag('saveContactDetails');

    if ($this->contactPage != null) {
      return $this->saveToExisting($request);
    }

    $page = new Page();
    $page->name = 'contact';
    $this->saveDetails($request, $page);
    return Redirect::route('contact');
  }

  public function saveToExisting(Request $request)
  {
    $this->saveDetails($request, $this->contactPage);
    return Redirect::route('contact');
  }

  public function saveDetails(Request $request, Page $page)
  {
    if ($request->has('photo')) {
      $photo_name = $request->photo->getClientOriginalName();
      $path = $request->file('photo')->storeAs('public/contact', $photo_name);
      $page->image_path = substr($path, 7);
      $page->image_name = $photo_name;
    }
    $page->email = $request->email;
    $page->phone = $request->phone;
    $page->title = $request->title;
    $page->description = $request->description;
    $page->save();
  }

  public function deletePhoto()
  {
    $photo_path = $this->contactPage->image_path;
    Storage::delete($photo_path);
    $this->contactPage->image_path = '';
    $this->contactPage->image_name = '';
    $this->contactPage->save();

    return Redirect::route('editContact');
  }

  public function postContact(Request $request)
  {
    $request->validateWithBag('postContact', [
      'email' => 'required|email:rfc,dns',
      'name' => 'required|string',
      'help' => 'required|string'

    ]);

    $emailToSendTo = $this->contactPage->email;

    Mail::to($emailToSendTo)->send(new ContactSent($request));

    return Redirect::route('contact');
  }
}
