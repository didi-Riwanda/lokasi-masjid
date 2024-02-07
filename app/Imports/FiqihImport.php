<?php

namespace App\Imports;

use App\Models\Fiqih;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FiqihImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $key => $row) {
            if ($key === 0) {
                continue;
            }

            $id = $row[1];
            $link = $row[2];
            $model = Fiqih::where('uuid', $id)->first();
            if (! empty($model)) {
                $model->source = $link;
                $model->save();
            }
        }
    }
}
