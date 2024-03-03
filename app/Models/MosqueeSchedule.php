<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MosqueeSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'speakers',
        'type',
        'day',
        'start_time',
        'end_time',
        'duration',
    ];

    public function mosquee()
    {
        return $this->hasOne(Mosquee::class, 'id', 'mosquee_id');
    }
}
