<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function display($path)
    {
        if (! Storage::exists($path)) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        $file = Storage::get($path);
        $type = Storage::mimeType($path);

        return response($file)->header('Content-type', $type);

    }
}
