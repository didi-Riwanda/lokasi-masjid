<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesystemBuildController extends Controller
{
    public function image($path)
    {
        if (! Storage::exists($path)) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        $file = Storage::get($path);
        $type = Storage::mimeType($path);

        return response($file)->header('Content-type', $type);
    }

    public function audio($path)
    {
        if (! Storage::exists($path)) {
            return response()->json(['message' => 'Audio not found.'], 404);
        }

        $filename = basename($path);
        $file = Storage::get($path);
        $type = Storage::mimeType($path);
        $size = Storage::fileSize($path);

        if ($type === 'application/octet-stream') {
            $type = 'audio/mpeg';
        }

        $response = response($file);
        $response = $response->header('Cache-Control', 'public');
        $response = $response->header('Content-type', $type);
        $response = $response->header('Content-Transfer-Encoding', 'binary');
        $response = $response->header('Content-Disposition', 'inline; filename="'.$filename.'"');
        $response = $response->header('Content-Length', $size);
        return $response;
    }
}
