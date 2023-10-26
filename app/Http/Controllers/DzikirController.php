<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dzikir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DzikirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $model = Dzikir::select([
            'id',
            'uuid',
            'category_id',
            'title',
            'source',
            'created_at',
        ]);
        $model = $model->when(! empty($request->search), function ($query) use ($request) {
            $query->where('title', 'like', '%'.$request->search.'%');
        });
        $paginator = $model->cursorPaginate(15);

        return view('dzikir.index', [
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
        return view('dzikir.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $dzikir = Dzikir::create([
                'title' => $request->title,
                'arabic' => $request->arabic,
                'latin' => $request->latin,
                'translation' => $request->translation,
                'notes' => $request->notes,
                'fawaid' => $request->fawaid,
                'source' => $request->source,
            ]);
            $category = Category::where('uuid', $request->category)->first();
            if (! empty($category)) {
                $dzikir->category_id = $category->id;
                $dzikir->save();
            } else {
                $dzikir->delete();
            }
            return redirect()->route('dzikir.index');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Dzikir $dzikir)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dzikir $dzikir)
    {
        $category = Category::where('id', $dzikir->category_id)->first();

        return view('dzikir.edit', [
            'dzikir' => [
                'id' => $dzikir->uuid,
                'title' => $dzikir->title,
                'category' => optional($category)->uuid,
                'arabic' => $dzikir->arabic,
                'latin' => $dzikir->latin,
                'translation' => $dzikir->translation,
                'notes' => $dzikir->notes,
                'fawaid' => $dzikir->fawaid,
                'source' => $dzikir->source,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dzikir $dzikir)
    {
        return DB::transaction(function () use ($request, $dzikir) {
            $dzikir->update([
                'title' => $request->title,
                'arabic' => $request->arabic,
                'latin' => $request->latin,
                'translation' => $request->translation,
                'notes' => $request->notes,
                'fawaid' => $request->fawaid,
                'source' => $request->source,
            ]);

            $category = Category::where('uuid', $request->category)->first();
            if ($dzikir->category_id !== optional($category)->id) {
                $dzikir->category_id = $category->id;
                $dzikir->save();
            }
            return redirect()->route('dzikir.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dzikir $dzikir)
    {
        $dzikir->delete();
        return redirect()->route('dzikir.index');
    }
}
