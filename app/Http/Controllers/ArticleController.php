<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateArticleRequest;
use App\Http\Requests\EditArticleRequest;
use App\Models\Article;
use App\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $model = Article::select([
            'id',
            'uuid',
            'title',
            'subtitle',
            DB::raw('IF(`content` IS NULL, "poster", "article")'),
            'imgsrc',
            'created_at',
        ]);
        $model = $model->when(! empty($request->search), function ($query) use ($request) {
            $query->where('name', 'like', '%'.$request->search.'%');
        });
        $paginator = $model->cursorPaginate(15);

        return view('article.index', [
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
        return view('article.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateArticleRequest $request)
    {
        @ini_set('upload_max_size', '256M');
        @ini_set('post_max_size', '256M');
        @ini_set('max_execution_time', '300');

        return DB::transaction(function () use ($request) {
            $content = $request->body;
            $subtitle = null;
            if (! empty($content)) {
                $subtitle = Str::closetags(Str::limit($content, 125));
            }

            $imgs = [];
            if (is_array($request->images) && count($request->images) > 0) {
                foreach ($request->images as $image) {
                    $path = $image->store('/articles');
                    ImageOptimizer::optimize(Storage::path($path));
                    $imgs[] = str_replace(',', '', $path);
                }
            }

            Article::create([
                'title' => $request->title,
                'subtitle' => $subtitle,
                'content' => $content,
                'imgsrc' => implode(',', $imgs),
            ]);
            return redirect()->route('article.index');
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        return view('article.edit', [
            'article' => $article,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EditArticleRequest $request, Article $article)
    {
        @ini_set('upload_max_size', '256M');
        @ini_set('post_max_size', '256M');
        @ini_set('max_execution_time', '300');

        return DB::transaction(function () use ($article, $request) {
            $content = $article->content;
            if ($request->body !== $content) {
                $content = $request->body;
            }
            $imgs = [];
            if (! empty($request->images) && count($request->images) > 0) {
                foreach ($request->images as $image) {
                    $imgs[] = str_replace(',', '', $image->store('/articles'));
                }

                $sources = explode(',', $article->imgsrc);
                foreach ($imgs as $key => $img) {
                    if (isset($sources[$key])) {
                        $source = $sources[$key];
                        if (Storage::exists($source)) {
                            Storage::delete($source);
                        }
                        unset($sources[$key]);
                    }
                }

                foreach ($sources as $source) {
                    if (Storage::exists($source)) {
                        Storage::delete($source);
                    }
                }
            }
            $subtitle = null;
            if (! empty($content)) {
                $subtitle = Str::closetags(Str::limit($content, 125));
            }

            $article->update([
                'title' => $request->title,
                'subtitle' => $subtitle,
                'content' => $content,
                'imgsrc' => count($imgs) > 0 ? implode(',', $imgs) : $article->imgsrc,
            ]);
            return redirect()->route('article.index');
        });
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        return DB::transaction(function () use ($article) {
            $sources = explode(',', $article->imgsrc);
            foreach ($sources as $source) {
                if (Storage::exists($source)) {
                    Storage::delete($source);
                }
            }
            $article->delete();
            return redirect()->route('article.index')->with([
                'notification' => 'berhasil menghapus data',
            ]);
        });
    }
}
