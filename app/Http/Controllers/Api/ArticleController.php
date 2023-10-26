<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\ArticleViewer;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        $fields = [
            'id',
            'uuid',
            'title',
            'content',
            'imgsrc',
            'created_at',
        ];
        $model = Article::select($fields);
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
