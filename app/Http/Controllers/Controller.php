<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getAnalytics()
    {

      $analyticsTable = DB::table('analytics')->first();
      if ($analyticsTable != null){
        return [ 
          'ga' => $analyticsTable->ga, 
        'fbPixelId' => $analyticsTable->facebook_pixel_id ];
      }
    }
}
