<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\MurottalIndexRequest;
use App\Http\Requests\Api\MurottalQariRequest;
use App\Http\Resources\MurottalQariResource;
use App\Http\Resources\MurottalResource;
use App\Models\Murottal;
use FaithFM\SmartSearch\SmartSearch;
use Illuminate\Http\Request;

class MurottalController extends Controller
{
    public function index(MurottalIndexRequest $request)
    {
        $fields = [
            'id',
            'uuid',
            'title',
            'qari',
            'src',
            'duration',
            'created_at',
        ];
        $pattern = '/[a-zA-Z0-9 , .]/m';
        $search = $request->q ?? $request->search;
        $coditional = ! empty($search) && preg_match($pattern, $search);

        $model = Murottal::select($fields);
        $model = $model->when(! empty($request->qari), function ($model) use ($request) {
            $model->where('qari', $request->qari);
        });
        $model = $model->when($coditional, function($model) use ($search) {
            $search = new SmartSearch($search, 'title|qari');
            $model->where($search->getBuilderFilter());
        });
        return MurottalResource::make($model->cursorPaginate(150));
    }

    public function qaris(MurottalQariRequest $request)
    {
        $fields = [
            'id',
            'qari',
            'created_at',
        ];
        $pattern = '/[a-zA-Z0-9 , .]/m';
        $search = $request->q ?? $request->search;
        $coditional = ! empty($search) && preg_match($pattern, $search);
        $model = Murottal::select($fields);
        $model = $model->groupBy('qari');
        $model = $model->when($coditional, function($model) use ($search) {
            $search = new SmartSearch($search, 'qari');
            $model->where($search->getBuilderFilter());
        });
        return MurottalQariResource::make($model->cursorPaginate(100));
    }
}
