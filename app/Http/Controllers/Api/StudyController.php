<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StudyCategoryRequest;
use App\Http\Requests\Api\StudyIndexRequest;
use App\Http\Resources\StudyCategoryResource;
use App\Http\Resources\StudyResource;
use App\Models\Category;
use App\Models\Dzikir;
use App\Models\Study;
use FaithFM\SmartSearch\SmartSearch;
use Illuminate\Http\Request;

class StudyController extends Controller
{
    public function index(StudyIndexRequest $request)
    {
        $fields = [
            'id',
            'uuid',
            'category_id',
            'title',
            'url',
            'created_at',
        ];
        $pattern = '/[a-zA-Z0-9 , .]/m';
        $search = $request->q ?? $request->search;
        $coditional = ! empty($search) && preg_match($pattern, $search);

        $model = Study::select($fields);
        $model = $model->when($coditional, function($model) use ($search) {
            $search = new SmartSearch($search, 'title');
            $model->where($search->getBuilderFilter());
        })->latest();
        return StudyResource::make($model->cursorPaginate(100));
    }

    public function categories(StudyCategoryRequest $request)
    {
        $search = $request->q;
        $model = Category::select([
            'id',
            'uuid',
            'name',
            'created_at',
        ]);
        $model = $model->where('type', 'study');
        $model = $model->when(isset($search) && ! empty($search), function($model) use ($search) {
            $model->where('name', 'like', '%'.$search.'%');
        });
        $model = $model->orderBy('id', 'asc');
        $model = $model->orderBy('created_at', 'asc');
        return StudyCategoryResource::make($model->cursorPaginate(100));
    }

    public function show(Request $request, Study $study)
    {
        return [
            'id' => $study->uuid,
            'title' => $study->title,
            'url' => $study->url,
        ];
    }
}
