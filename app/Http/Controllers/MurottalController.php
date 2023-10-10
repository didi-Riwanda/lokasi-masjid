<?php

namespace App\Http\Controllers;

use App\Models\Murottal;
use App\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MurottalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $model = Murottal::select([
            'id',
            'title',
            'qari',
            'created_at',
        ]);
        $model = $model->when(! empty($request->search), function ($query) use ($request) {
            $query->where('title', 'like', '%'.$request->search.'%');
        });
        $paginator = Murottal::cursorPaginate(15);

        return view('murottal.index', [
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
        return view('murottal.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $path = optional($request->media)->store('murottals/'.Str::slug($request->qari));
            Murottal::create([
                'title' => $request->title,
                'qari' => $request->qari,
                'src' => $path,
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
        return DB::transaction(function () use ($request, $murottal) {
            $path = $murottal->src;
            if (! empty($request->media)) {
                $path = optional($request->media)->store('murottals/'.Str::slug($request->qari));
            }
            return redirect()->route('murottal.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Murottal $murottal)
    {
        $murottal->delete();
        return redirect()->route('murottal.index');
    }
}