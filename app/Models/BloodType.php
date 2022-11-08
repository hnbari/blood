<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BloodType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'amount',
    ];

    public function users()
    {
        return $this->hasMany(user::class);
    }

    public function donate()
    {
        return $this->hasMany(donate_schedual::class);
    }
}
