<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\HadistCategoryRequest;
use App\Http\Requests\Api\HadistChapterRequest;
use App\Http\Resources\HadistCategoryResource;
use App\Http\Resources\HadistChapterResource;
use App\Http\Resources\HadistResource;
use App\Models\Hadist;
use FaithFM\SmartSearch\SmartSearch;
use Illuminate\Http\Request;

class HadistController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('q', $request->search);
        $model = Hadist::select(
            'id',
            'uuid',
            'title',
            'source',
            'category',
            'noted',
            'translation',
            'narrators',
            'created_at'
        );
        $model = $model->when(isset($search) && ! empty($search), function ($model) use ($search) {
            $model->orwhere('title', 'like', '%'.$search.'%');
            $model->orwhere('source', 'like', '%'.$search.'%');
            $model->orwhere('category', 'like', '%'.$search.'%');
            $model->orwhere('noted', 'like', '%'.$search.'%');
            $model->orwhere('translation', 'like', '%'.$search.'%');
            $model->orwhere('narrators', 'like', '%'.$search.'%');
        });
        return HadistResource::make($model->cursorPaginate(100));
    }

    public function categories(HadistCategoryRequest $request)
    {
        $search = $request->q;
        $model = Hadist::select('id', 'source', 'category', 'created_at')->groupBy('source');
        $model = $model->when(isset($search) && ! empty($search), function($model) use ($search) {
            $model->where('source', 'like', '%'.$search.'%');
        });
        $model = $model->orderBy('ordered', 'asc');
        $model = $model->orderBy('id', 'asc');
        $model = $model->orderBy('created_at', 'asc');
        return HadistCategoryResource::make($model->cursorPaginate(100));
    }

    public function chapters(HadistChapterRequest $request)
    {
        $category = $request->category;
        $search = $request->q;
        $model = Hadist::select('id', 'uuid', 'title', 'created_at');
        $model = $model->when(isset($search) && ! empty($search), function($model) use ($search) {
            $model->where('title', 'like', '%'.$search.'%');
        });
        $model = $model->when(isset($category) && ! empty($category), function ($model) use ($category) {
            $model->where('source', 'like', '%'.$category.'%');
        });
        $model = $model->orderBy('id', 'asc');
        $model = $model->orderBy('created_at', 'asc');
        return HadistChapterResource::make($model->cursorPaginate(100));
    }

    public function show(Hadist $hadist)
    {
        return [
            'id' => $hadist->uuid,
            'title' => $hadist->title,
            'source' => $hadist->source,
            'text' => $hadist->text,
            'translation' => $hadist->translation,
            'noted' => $hadist->noted,
        ];
    }
}
