<?php

namespace App\Http\Resources;

use App\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->map(function ($row) {
                $content = $row->content;

                return [
                    'id' => $row->uuid,
                    'title' => $row->title,
                    'subtitle' => $this->getSubtitleFromContent($content),
                    'fileurl' => array_map(function ($row) {
                        return route('image.url', ['path' => $row]);
                    }, explode(',', $row->imgsrc)),
                    'type' => ! empty($content) ? 'article' : 'poster',
                    'created' => $row->created_at->setTimezone('UTC'),
                ];
            }),
        ];
    }

    private function getSubtitleFromContent($content)
    {
        if (isset($content) && ! empty($content)) {
            return Str::closetags(Str::limit($content, 125));
        }
        return null;
    }
}
