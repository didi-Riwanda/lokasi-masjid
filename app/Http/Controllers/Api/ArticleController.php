<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\ArticleViewer;
use FaithFM\SmartSearch\SmartSearch;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $fields = [
            'id',
            'uuid',
            'title',
            'content',
            'imgsrc',
            'created_at',
        ];
        $pattern = '/[a-zA-Z0-9 , .]/m';
        $search = $request->q ?? $request->search;
        $coditional = ! empty($search) && preg_match($pattern, $search);

        $model = Article::select($fields);
        $model = $model->when($coditional, function($model) use ($search) {
            $search = new SmartSearch($search, 'title|content');
            $model->where($search->getBuilderFilter());
        });
        $model = $model->when(! empty($request->category), function ($model) use ($request) {
            $model->where('category_id', $request->category);
        });
        $model = $model->latest();

        sleep(8);

        return ArticleResource::make($model->cursorPaginate(20));
    }

    public function show(Request $request, Article $article)
    {

        ArticleViewer::updateOrCreate([
            'post_id' => $article->id,
            'ip_address' => $request->ip(),
        ]);

        $article->views = ArticleViewer::count();
        $article->save();

        return [
            'id' => $article->uuid,
            'title' => $article->title,
            'subtitle' => $article->subtitle,
            'content' => $article->content,
            'fileurl' => array_map(function ($row) {
                return route('image.url', ['path' => $row]);
            }, explode(',', $article->imgsrc)),
            'type' => ! empty($article->content) ? 'article' : 'poster',
            'views' => $article->views,
            'created' => $article->created_at,
        ];
    }
}
