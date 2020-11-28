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
  public function show()
  {
    if (Page::where('name', 'contact')->first() != null) {
      return \Inertia\Inertia::render('Contact/Show', [
        'email' =>  Page::where('name', 'contact')->first()->email,
        'phone' =>  Page::where('name', 'contact')->first()->phone,
        'image_path' =>  Page::where('name', 'contact')->first()->image_path,
      ]);
    }

    return \Inertia\Inertia::render('Contact/Show', [
      'email' =>  '',
      'phone' =>  '',
      'image_path' => '',
    ]);
  }

  public function edit()
  {
    if (Page::where('name', 'contact')->first() != null) {
      return \Inertia\Inertia::render('Contact/Edit', [
        'email' => Page::where('name', 'contact')->first()->email,
        'pagePhotoPath' => Page::where('name', 'contact')->first()->image_path,
        'phone' => Page::where('name', 'contact')->first()->phone
      ]);
    }
    return \Inertia\Inertia::render('Contact/Edit', [
      'email' => 'john@email.com',
      'pagePhotoPath' => '',
      'phone' => '2879283792387'
    ]);
  }

  public function save(Request $request)
  {
    $request->validateWithBag('saveContactDetails', [
      // 'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'photo' => Rule::requiredIf(Page::where('name', 'contact')->first()->image_path != null),
      'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
      'email' => 'required|email:rfc,dns',
      'phone' => 'required|string',

    ]);

    // Validator::make($request->all(), [
    //   'photo' => Rule::requiredIf(Page::where('name', 'contact')->first()->image_path != null)
    // ]);

    if (Page::where('name', 'contact')->first() != null) {
      return $this->saveToExisting($request);
    }

    $page = new Page();
    $page->name = 'contact';
    $this->saveDetails($request, $page);
    return Redirect::route('home');
  }

  public function saveToExisting(Request $request)
  {
    $page = Page::where('name', 'contact')->first();
    $this->saveDetails($request, $page);
    return Redirect::route('home');
  }

  public function saveDetails(Request $request, Page $page)
  {
    $photo_name = $request->photo->getClientOriginalName();
    $path = $request->file('photo')->storeAs('public/contact', $photo_name);
    $page->image_path = substr($path, 7);
    $page->image_name = $photo_name;
    $page->email = $request->email;
    $page->phone = $request->phone;
    $page->save();
  }

  public function deletePhoto()
  {

    $page = Page::where('name', 'contact')->first();
    $photo_path = $page->image_path;
    Storage::delete($photo_path);
    $page->image_path = '';
    $page->image_name = '';
    $page->save();

    return Redirect::route('editContact');

  }

  public function postContact(Request $request)
  {
    $request->validateWithBag('postContact', [
      'email' => 'required|email:rfc,dns',
      'name' => 'required|string',
      'help' => 'required|string'

    ]);

    $emailToSendTo = Page::where('name', 'contact')->first()->email;

    Mail::to($emailToSendTo)->send(new ContactSent($request));

    return Redirect::route('contact');

  }
}
