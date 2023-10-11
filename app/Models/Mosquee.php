<?php

namespace App\Models;

use App\Models\Traits\HasUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mosquee extends Model
{
    use HasFactory, HasUuid;

    protected $fillable = [
        'name',
        'address',
        'street',
        'district',
        'city',
        'province',
        'latitude',
        'longitude',
    ];

    protected $guarded = [
        'id',
    ];

    public function image()
    {
        return $this->hasOne(MosqueeImage::class);
    }

    public function images()
    {
        return $this->hasMany(MosqueeImage::class);
    }

    public function contacts()
    {
        return $this->hasMany(MosqueeContact::class);
    }

    public function schedules()
    {
        return $this->hasMany(MosqueeSchedule::class);
    }
}
