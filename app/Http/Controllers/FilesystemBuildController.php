<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FilesystemBuildController extends Controller
{
    public function image(Request $request, $path)
    {
        if (! Storage::exists($path)) {
            return response()->json(['message' => 'Image not found.'], 404);
        }

        if ($request->check && Storage::exists($path)) {
            return response()->json(['message' => 'Document found']);
        }

        $file = Storage::get($path);
        $type = Storage::mimeType($path);

        return response($file)->header('Content-type', $type);
    }

    public function audio(Request $request, $path)
    {
        if (! Storage::exists($path)) {
            return response()->json(['message' => 'Audio not found.'], 404);
        }

        if ($request->check && Storage::exists($path)) {
            return response()->json(['message' => 'Document found']);
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

    public function document(Request $request, $path)
    {
        if (! Storage::exists($path)) {
            return response()->json(['message' => 'Document not found.'], 404);
        }

        if ($request->check && Storage::exists($path)) {
            return response()->json(['message' => 'Document found']);
        }

        $file = Storage::get($path);
        $type = Storage::mimeType($path);
        $size = Storage::fileSize($path);

        $response = response($file);
        $response = $response->header('Cache-Control', 'public');
        $response = $response->header('Content-type', $type);
        $response = $response->header('Content-Length', $size);
        return $response;
    }
}
