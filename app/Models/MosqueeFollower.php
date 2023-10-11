<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MosqueeFollower extends Model
{
    use HasFactory;

    public function mosquee()
    {
        return $this->belongsTo(Mosquee::class, 'mosquee_id');
    }
}
