<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class StudyResource extends ResourceCollection
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
                dd(json_decode($row->thumbnails));
                return [
                    'id' => $row->uuid,
                    'title' => $row->title,
                    'category' => [
                        'id' => optional($row->category)->uuid,
                        'name' => optional($row->category)->name,
                    ],
                    'url' => $row->url,
                    'thumbnails' => json_decode($row->thumbnails),
                ];
            }),
        ];
    }
}
