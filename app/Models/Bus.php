<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_number',
        'plate_number',
        'model',
        'capacity',
        'status'
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
