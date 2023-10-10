<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dzikir extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'title',
        'arabic',
        'latin',
        'translation',
        'notes',
        'fawaid',
        'source',
    ];

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
