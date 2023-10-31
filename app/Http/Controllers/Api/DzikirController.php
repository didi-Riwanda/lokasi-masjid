<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DzikirCategoryRequest;
use App\Http\Requests\Api\DzikirIndexRequest;
use App\Http\Resources\DzikirCategoryResource;
use App\Http\Resources\DzikirResource;
use App\Models\Category;
use App\Models\Dzikir;
use FaithFM\SmartSearch\SmartSearch;
use Illuminate\Http\Request;

class DzikirController extends Controller
{
    public function index(DzikirIndexRequest $request)
    {
        $fields = [
            'id',
            'uuid',
            'category_id',
            'title',
            'source',
            'created_at',
        ];
        $pattern = '/[a-zA-Z0-9 , .]/m';
        $search = $request->q ?? $request->search;
        $coditional = ! empty($search) && preg_match($pattern, $search);

        $model = Dzikir::select($fields);
        $model = $model->when($coditional, function($model) use ($search) {
            $search = new SmartSearch($search, 'title|source');
            $model->where($search->getBuilderFilter());
        });
        $model = $model->when(! empty($request->category), function ($model) use ($request) {
            $category = Category::where('uuid', $request->category)->first();
            if (! empty($category)) {
                $model->where('category_id', $category->id);
            }
        });
        $model = $model->latest();
        return DzikirResource::make($model->cursorPaginate(100));
    }

    public function categories(DzikirCategoryRequest $request)
    {
        $search = $request->q;
        $model = Category::select([
            'id',
            'uuid',
            'name',
            'created_at',
        ]);
        $model = $model->where('type', 'dzikir');
        $model = $model->when(isset($search) && ! empty($search), function($model) use ($search) {
            $model->where('name', 'like', '%'.$search.'%');
        });
        $model = $model->orderBy('id', 'asc');
        $model = $model->orderBy('created_at', 'asc');
        return DzikirCategoryResource::make($model->cursorPaginate(100));
    }

    public function show(Request $request, Dzikir $dzikir)
    {
        $category = $dzikir->category;
        return [
            'id' => $dzikir->uuid,
            'title' => $dzikir->title,
            'arabic' => $dzikir->arabic,
            'latin' => $dzikir->latin,
            'translation' => $dzikir->translation,
            'category' => [
                'id' => $category->uuid,
                'name' => $category->name,
            ],
            'notes' => $dzikir->notes,
            'fawaid' => $dzikir->fawaid,
            'source' => $dzikir->source,
        ];
    }
}
