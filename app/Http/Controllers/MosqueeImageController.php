<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMosqueeGalleryRequest;
use App\Models\Mosquee;
use App\Models\MosqueeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MosqueeImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Mosquee $mosquee)
    {
        $model = MosqueeImage::select([
            'id',
            'source',
            'type',
            'created_at',
        ]);
        $model = $model->where('mosquee_id', $mosquee->id);
        $paginator = $model->cursorPaginate(15);

        return view('mosquee.gallery.index', [
            'mosquee' => $mosquee,
            'paginate' => [
                'data' => array_map(function ($row) use ($mosquee) {
                    return [
                        'id' => $row['id'],
                        'mosquee' => $mosquee->uuid,
                        'source' => $row['source'],
                        'type' => $row['type'],
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
    public function create(Mosquee $mosquee)
    {
        return view('mosquee.gallery.create', [
            'mosquee' => Mosquee::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateMosqueeGalleryRequest $request, Mosquee $mosquee)
    {
        return DB::transaction(function () use ($mosquee, $request) {
            if (is_array($request->file('images'))) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('mosquees/'.$mosquee->uuid.'/galleries');
                    $extension = $image->extension();
                    $mosquee->images()->create([
                        'source' => $path,
                        'type' => $extension,
                    ]);
                }
            }
    
            return redirect()->route('mosquee.gallery.index', ['mosquee' => $mosquee->uuid])->with('success', 'Successfully');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(MosqueeImage $mosquee_image)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mosquee $mosquee, MosqueeImage $gallery)
    {
        return view('mosquee.gallery.edit', [
            'gallery' => $gallery,
            'mosquee' => $mosquee,
            'all_mosquee' => Mosquee::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mosquee $mosquee, MosqueeImage $gallery)
    {
        // $validate = $request->validate([
        //     'mosquee_id' => 'required',
        //     'source' => 'image|file|max:1024',
        //     'type' => 'required'
        // ]);

        // if($request->file('source')){
        //     if($request->oldImage){
        //         Storage::delete($request->oldImage);
        //     }
        //     $validate['source'] = $request->file('source')->store('mosquee.gallery');
        // }

        // $mosquee_image->update($validate);

        // return redirect()->route('mosquee.gallery.index')->with('success', 'Successfully');

        return DB::transaction(function () use ($mosquee, $gallery, $request) {
            $file = $request->file('image');
            if (! empty($file)) {
                $gallery->source = $file->store('mosquees/'.$mosquee->uuid.'/galleries');
                $gallery->save();
            }
            return redirect()->route('mosquee.gallery.index', ['mosquee' => $mosquee->uuid])->with('success', 'Successfully');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mosquee $mosquee, MosqueeImage $gallery)
    {
        if($gallery->source){
            Storage::delete($gallery->source);

            $gallery->delete();

            return redirect()->route('mosquee.gallery.index', ['mosquee' => $mosquee->uuid])->with('success', 'Successfully');
        }
    }
}
