<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Analytics;


class AnalyticsController extends Controller
{

  public function __construct()
  {
    $this->analyticsValues = Analytics::firstOrFail()
  }

  public function save(Request $request)
  {
    $request->validateWithBag('saveAnalytics', [
      'ga' => 'required|string',
      'facebookPixelId' => 'required|string',
    ]);

    $page = Analytics::firstOrNew([
      'ga' => $request->ga,
      'facebook_pixel_id' => $request->facebookPixelId
    ]);

    $page->save();
  }

  public function edit()
  {

    if ($this->homePage != null) {
      return \Inertia\Inertia::render('Home', [
        'home_page_html' => $this->homePage->html,
        'image_path' =>  $this->homePage->image_path,
      ])->withViewData(['meta' => $this->homePage->description, 'title' => $this->homePage->title]);
    }
    return \Inertia\Inertia::render('Home');
  }
}
