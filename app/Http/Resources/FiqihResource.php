<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class FiqihResource extends ResourceCollection
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
                $source = $row->source;
                if (filter_var($source, FILTER_VALIDATE_URL) === false) {
                    $source = route('document.url', ['path' => $row->source]);
                }
                return [
                    'id' => $row->uuid,
                    'title' => $row->title,
                    'source' => $source,
                ];
            }),
        ];
    }
}
