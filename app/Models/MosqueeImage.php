<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MosqueeImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'type',
    ];

    public function mosquee()
    {
        return $this->belongsTo(Mosquee::class);
    }
}
