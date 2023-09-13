<?php

namespace App\Models;

use App\Models\Mosquee;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mosquee_contact extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function mosquee(): BelongsTo{
        return $this->belongsTo(Mosquee::class);
    }
}
