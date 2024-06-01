<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Charts;

class Position extends Model
{
    use HasFactory;

    public function charts()
    {
        return $this->belongsToMany(Charts::class);
    }
}
