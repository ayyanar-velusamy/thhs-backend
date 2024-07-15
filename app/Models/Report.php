<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChartCategory;

class Report extends Model
{
    use HasFactory;
    public function chart_category(): HasMany {
        return $this->hasMany(ChartCategory::class);
    }
}
