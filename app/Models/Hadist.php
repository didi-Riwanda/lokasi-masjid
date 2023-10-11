<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hadist extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'title',
        'source',
        'text',
        'translation',
        'category',
        'noted',
    ];
}
