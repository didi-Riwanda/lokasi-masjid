<?php

namespace App\Http\Controllers;

use App\Models\Fiqih;
use App\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FiqihController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $model = Fiqih::select([
            'id',
            'uuid',
            'title',
            'source',
            'created_at'
        ]);
        $model = $model->when(! empty($request->search), function ($query) use ($request) {
            $query->where('title', 'like', '%'.$request->search.'%');
        });
        $paginator = $model->cursorPaginate(15);

        return view('fiqih.index', [
            'paginate' => [
                'data' => array_map(function ($row) {
                    $source = $row['source'];
                    $validate = filter_var($source, FILTER_VALIDATE_URL) === false;
                    if ($validate) {
                        $source = route('document.url', ['path' => $source]);
                    }
                    return [
                        'id' => $row['id'],
                        'uuid' => $row['uuid'],
                        'title' => $row['title'],
                        'source' => [
                            'path' => $source,
                            'found' => Storage::exists($row['source']) || ! $validate,
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
        return view('fiqih.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $data = [
                'title' => $request->title,
            ];
            if ($request->source instanceof UploadedFile) {
                $data['source'] = $request->source->store('/fiqihs');
            } else if (is_string($request->source)) {
                $source = $request->source;
                if (Str::contains($source, ['https://drive.google.com/file/d/', '/view?usp=sharing', '/view?usp=drive_link'])) {
                    $source = str_replace(['https://drive.google.com/file/d/', '/view?usp=sharing', '/view?usp=drive_link'], '', $source);
                }

                $data['source'] = str_replace('${code}', $source, 'https://drive.google.com/file/d/${code}/view?usp=sharing');
            }

            Fiqih::create($data);
            return redirect()->route('fiqih.index');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Fiqih $fiqih)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fiqih $fiqih)
    {
        return view('fiqih.edit', [
            'fiqih' => $fiqih,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fiqih $fiqih)
    {
        return DB::transaction(function () use ($fiqih, $request) {
            $fiqih->title = $request->title;
            if ($request->source) {
                if (Storage::exists($fiqih->source)) {
                    Storage::delete($fiqih->source);
                }

                
                $source = $request->file('source');
                if (! empty($source)) {
                    $fiqih->source = $request->source->store('/fiqihs');
                } else if (is_string($request->source)) {
                    $source = $request->source;
                    if (Str::contains($source, ['https://drive.google.com/file/d/', '/view?usp=sharing', '/view?usp=drive_link'])) {
                        $source = str_replace(['https://drive.google.com/file/d/', '/view?usp=sharing', '/view?usp=drive_link'], '', $source);
                    }

                    $fiqih->source = str_replace('${code}', $source, 'https://drive.google.com/file/d/${code}/view?usp=sharing');
                }
            }
            $fiqih->save();
            return redirect()->route('fiqih.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fiqih $fiqih)
    {
        if (Storage::exists($fiqih->source)) {
            Storage::delete($fiqih->source);
        }
        $fiqih->delete();

        return redirect()->route('fiqih.index');
    }
}
