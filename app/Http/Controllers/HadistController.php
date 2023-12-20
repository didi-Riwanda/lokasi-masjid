<?php

namespace App\Http\Controllers;

use App\Models\Hadist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HadistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $model = Hadist::select([
            'id',
            'uuid',
            'title',
            'source',
            'noted',
            'created_at'
        ]);
        $model = $model->when(! empty($request->search), function ($query) use ($request) {
            $query->where('title', 'like', '%'.$request->search.'%');
        });
        $paginator = $model->cursorPaginate(15);

        return view('hadist.index', [
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
        return view('hadist.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            Hadist::create([
                'title' => $request->title,
                'source' => $request->source,
                'text' => $request->text,
                'translation' => $request->translation,
                'category' => $request->category,
                'noted' => $request->noted,
            ]);
            return redirect()->route('hadist.index');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Hadist $hadist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hadist $hadist)
    {
        return view('hadist.edit', [
            'hadist' => $hadist,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hadist $hadist)
    {
        return DB::transaction(function () use ($request, $hadist) {
            $hadist->update([
                'title' => $request->title,
                'source' => $request->source,
                'text' => $request->text,
                'translation' => $request->translation,
                'category' => $request->category,
                'noted' => $request->noted,
            ]);
            return redirect()->route('hadist.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hadist $hadist)
    {
        return DB::transaction(function () use ($hadist) {
            $hadist->delete();

            return redirect()->route('hadist.index');
        });
    }
}
