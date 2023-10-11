<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $types = ['hadist', 'study', 'article', 'murottal', 'dzikir'];
        $model = Category::select([
            'id',
            'uuid',
            'name',
            'type',
            'created_at',
        ]);
        $model = $model->when(! empty($request->search), function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->search.'%');
        });
        $model = $model->when(! empty($request->target) && in_array($request->target, $types), function ($query) use ($request) {
            $query->where('type', $request->target);
        });
        $paginator = $model->cursorPaginate(15);

        if ($request->wantsJson()) {
            return [
                'data' => array_map(function ($row) {
                    return [
                        'id' => $row['uuid'],
                        'name' => $row['name'],
                        'type' => $row['type'],
                    ];
                }, $paginator->items()),
                'next' => optional($paginator->nextCursor())->encode(),
            ];
        }

        return view('category.index', [
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
        return view('category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $category = Category::create([
                'name' => $request->title,
                'type' => $request->target,
            ]);
            if ($request->wantsJson()) {
                return [
                    'id' => $category->uuid,
                    'name' => $category->name,
                    'type' => $category->type,
                ];
            }
            return redirect()->route('category.index');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('category.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        return DB::transaction(function () use ($request, $category) {
            $category->update([
                'name' => $request->title,
                'type' => $request->target,
            ]);
            return redirect()->route('category.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('category.index');
    }
}
