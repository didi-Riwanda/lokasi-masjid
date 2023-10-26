<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fiqih extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'title',
        'source',
    ];
}
