<?php

namespace App\Http\Resources;

use App\Support\Str;
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
                } elseif (Str::contains($source, ['https://drive.google.com/file/d/', '/view?usp=sharing'])) {
                    $code = str_replace(['https://drive.google.com/file/d/', '/view?usp=sharing', '/view?usp=drive_link'], '', $source);
                    $source = [
                        'download' => str_replace('${code}', $code, 'https://drive.google.com/uc?export=download&id=${code}'),
                        'preview' => str_replace('${code}', $code, 'https://drive.google.com/file/d/${code}/view?usp=sharing'),
                    ];
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
