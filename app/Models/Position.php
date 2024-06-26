<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chart;

class Position extends Model
{
    use HasFactory;

    public function charts()
    {
        return $this->belongsToMany(Chart::class);
    }
}
