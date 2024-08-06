<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;
    protected $fillable = ['day', 'trip_id'];

    public function trip()
    {
        return $this->belongsTo(Trip::class);
    }
}
