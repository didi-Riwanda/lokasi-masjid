<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class HadistResource extends ResourceCollection
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
                return [
                    'id' => $row->uuid,
                    'title' => $row->title,
                    'author' => $row->category,
                    'source' => $row->source,
                    'narrators' => $row->narrators,
                    'noted' => $row->noted,
                ];
            }),
        ];
    }
}
