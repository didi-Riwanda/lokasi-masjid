<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class DonationController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->wantsJson()) {
            $params = Arr::query([
                'Page' => $request->query('page'),
                'Limit' => $request->query('limit'),
                'StartRangeAt' => $request->query('start-range-at'),
                'EndRangeAt' => $request->query('end-range-at'),
                'Type' => $request->query('type'),
            ]);

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, 'http://localhost:9000/admin/donation?'.$params);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_VERBOSE, false);
            
            $executed = curl_exec($ch);
            $error = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $info = curl_getinfo($ch);
            curl_close($ch);
 
            dd($executed);
        }
    }
}
