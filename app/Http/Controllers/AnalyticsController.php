<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Analytics;


class AnalyticsController extends Controller
{

  public function save(Request $request)
  {
    $request->validateWithBag('saveAnalytics', [
      'ga' => 'required|string',
      'fbPixelId' => 'required|string',
    ]);

    $page = Analytics::firstOrNew([
      'ga' => $request->ga,
      'facebook_pixel_id' => $request->fbPixelId
    ]);

    $page->save();
  }

  public function edit()
  {
    if ($this->getAnalytics() != null) {
      return \Inertia\Inertia::render('Analytics/Edit', [
        'ga' => $this->getAnalytics()['ga'],
        'fbPixelId' =>  $this->getAnalytics()['fbPixelId'],
      ]);
    }
    return \Inertia\Inertia::render('Analytics/Edit');
  }
}
        