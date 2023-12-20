<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FiqihResource;
use App\Models\Fiqih;
use FaithFM\SmartSearch\SmartSearch;
use Illuminate\Http\Request;

class FiqihController extends Controller
{
    public function index(Request $request)
    {
        $fields = [
            'id',
            'uuid',
            'title',
            'source',
            'created_at',
        ];
        $pattern = '/[a-zA-Z0-9 , .]/m';
        $search = $request->q ?? $request->search;
        $coditional = ! empty($search) && preg_match($pattern, $search);

        $model = Fiqih::select($fields);
        $model = $model->when(! empty($request->qari), function ($model) use ($request) {
            $model->where('qari', $request->qari);
        });
        $model = $model->when($coditional, function($model) use ($search) {
            $search = new SmartSearch($search, 'title');
            $model->where($search->getBuilderFilter());
        });
        return FiqihResource::make($model->cursorPaginate(150));
    }
}
