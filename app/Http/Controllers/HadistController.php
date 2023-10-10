<?php

namespace App\Http\Controllers;

use App\Models\Hadist;
use Illuminate\Http\Request;

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

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Hadist $hadist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hadist $hadist)
    {
        //
    }
}
