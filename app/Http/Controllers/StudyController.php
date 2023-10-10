<?php

namespace App\Http\Controllers;

use Alaouy\Youtube\Facades\Youtube;
use App\Http\Requests\CreateStudyRequest;
use App\Http\Requests\EditStudyRequest;
use App\Models\Category;
use App\Models\Study;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $model = Study::select([
            'id',
            'category_id',
            'title',
            'url',
            'created_at',
        ]);
        $model = $model->when(! empty($request->search), function ($query) use ($request) {
            $query->where('title', 'like', '%'.$request->search.'%');
        });
        $paginator = Study::cursorPaginate(15);

        return view('study.index', [
            'paginate' => [
                'data' => $paginator->items(),
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
        $key = 'PLy17e3WoyoZY1rh9PX1pVlTlKFvqXa80-';
        return view('study.create', [
            'media' => [
                'playlist' => [
                    'items' => Youtube::getPlaylistItemsByPlaylistId($key)['results'],
                ],
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateStudyRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $study = Study::create([
                'title' => $request->title,
                'url' => $request->media,
            ]);
            $category = Category::where('uuid', $request->category)->first();
            if (! empty($category)) {
                $study->category_id = $category->id;
                $study->save();
            } else {
                $study->delete();
            }
            return redirect()->route('study.index');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Study $study)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Study $study)
    {
        $category = Category::where('id', $study->category_id)->first();

        return view('study.edit', [
            'study' => [
                'id' => $study->uuid,
                'title' => $study->title,
                'category' => optional($category)->uuid,
                'url' => $study->url,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditStudyRequest $request, Study $study)
    {
        return DB::transaction(function () use ($request, $study) {
            $study->update([
                'title' => $request->title,
                'url' => $request->media,
            ]);

            $category = Category::where('uuid', $request->category)->first();
            if ($study->category_id !== optional($category)->id) {
                $study->category_id = $category->id;
                $study->save();
            }
            return redirect()->route('study.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Study $study)
    {
        $study->delete();
        return redirect()->route('study.index');
    }
}
