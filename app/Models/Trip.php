<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Trip extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    public static function generateSlug($name)
    {
        $slug = Str::slug($name, '-');
        $count = 1;
    
        do {
            $newSlug = ($count > 1) ? "{$slug}-{$count}" : $slug;
            $existingSlug = Trip::withTrashed()->where('slug', $newSlug)->exists();
            $count++;
        } while ($existingSlug);
    
        return $newSlug;
    }
}
