<?php

namespace App\Models;

use App\Models\Assistance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fund extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function categories()
    {
        return $this->belongsTo(Category::class);
    }

    public function assitances()
    {
        return $this->belongsTo(Assistance::class);
    }
}
