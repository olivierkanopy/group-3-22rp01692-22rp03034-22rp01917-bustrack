<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start_point',
        'end_point',
        'description',
        'distance',
        'estimated_time'
    ];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }
}
