<?php

namespace App\Http\Controllers;

use Alaouy\Youtube\Facades\Youtube;
use App\Models\Study;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $kajian = Study::all();
        foreach ($kajian as $row) {
            if (preg_match('/.*\?v=(.+?)($|[\&])/m', $row->url, $matches))  {
                $id = $matches[1];
                $info = Youtube::getVideoInfo($id);

                $row->thumbnails = json_encode($info->snippet->thumbnails);
                $row->save();
            }
        }

        return view('index');
    }
}
