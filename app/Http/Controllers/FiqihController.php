<?php

namespace App\Http\Controllers;

use App\Models\Fiqih;
use Illuminate\Http\Request;
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
        return view('fiqih.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            Fiqih::create([
                'title' => $request->title,
                'source' => $request->source->store('/fiqihs'),
            ]);
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
                $fiqih->source = $request->source->store('/fiqihs');
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
