<?php

namespace App\Models;

use App\Models\Mosquee_image;
use App\Models\Mosquee_contact;
use App\Models\Mosquee_follower;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mosquee extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public $incrementing = false;
    protected $keyType = 'string';

    public function mosquee_image(): HasOne{
        return $this->hasOne(Mosquee_image::class);
    }

    public function mosquee_contact(): HasOne{
        return $this->hasOne(Mosquee_contact::class);
    }

    public function mosquee_follower(): HasMany{
        return $this->hasMany(Mosquee_follower::class, 'mosquee_id');
    }
}
