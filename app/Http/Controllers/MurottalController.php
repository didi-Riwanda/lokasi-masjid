<?php

namespace App\Http\Controllers;

use App\Models\Murottal;
use App\Support\Str;
use FFMpeg\FFProbe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MurottalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $model = Murottal::select([
            'id',
            'uuid',
            'title',
            'qari',
            'src',
            'created_at',
        ]);
        $model = $model->when(! empty($request->search), function ($query) use ($request) {
            $query->where('title', 'like', '%'.$request->search.'%');
            $query->orWhere('qari', 'like', '%'.$request->search.'%');
        });
        $paginator = $model->cursorPaginate(15);

        return view('murottal.index', [
            'paginate' => [
                'data' => array_map(function ($row) {
                    $media = false;
                    if (! empty($row['src']) && Storage::fileExists($row['src'])) {
                        $media = true;
                    }
                    return [
                        'id' => $row['id'],
                        'uuid' => $row['uuid'],
                        'title' => $row['title'],
                        'qari' => $row['qari'],
                        'src' => $row['src'],
                        'status' => [
                            'media' => $media,
                        ],
                    ];
                }, $paginator->items()),
                'meta' => [
                    'count' => $paginator->count(),
                    'next' => optional($paginator->nextCursor())->encode(),
                    'previous' => optional($paginator->previousCursor())->encode(),
                ],
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('murottal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        @ini_set('upload_max_size', '256M');
        @ini_set('post_max_size', '256M');
        @ini_set('max_execution_time', '300');

        return DB::transaction(function () use ($request) {
            $path = optional($request->media)->store('murottals/'.Str::slug($request->qari));
            $ffprobe = FFProbe::create();
            Murottal::create([
                'title' => $request->title,
                'qari' => $request->qari,
                'src' => $path,
                'duration' => +$ffprobe->format(Storage::path($path))->get('duration'),
            ]);
            return redirect()->route('murottal.index');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Murottal $murottal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Murottal $murottal)
    {
        return view('murottal.edit', [
            'murottal' => $murottal,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Murottal $murottal)
    {
        @ini_set('upload_max_size', '256M');
        @ini_set('post_max_size', '256M');
        @ini_set('max_execution_time', '300');

        return DB::transaction(function () use ($request, $murottal) {
            $duration = $murottal->duration;
            $path = $murottal->src;
            if (! empty($request->media)) {
                if (Storage::exists($path)) {
                    Storage::delete($path);
                }
                $path = optional($request->media)->store('murottals/'.Str::slug($request->qari));
                $ffprobe = FFProbe::create();
                $duration = +$ffprobe->format(Storage::path($path))->get('duration');
            }
            $murottal->update([
                'title' => $request->title,
                'qari' => $request->qari,
                'src' => $path,
                'duration' => $duration,
            ]);
            return redirect()->route('murottal.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Murottal $murottal)
    {
        if (Storage::exists($murottal->src)) {
            Storage::delete($murottal->src);
        }
        $murottal->delete();
        return redirect()->route('murottal.index');
    }
}
