<?php

namespace App\Models;

use App\Models\Assistance;
use App\Models\ClientCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubFund extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function assistance()
    {
        return $this->belongsTo(Assistance::class);
    }
    public function category()
    {
        return $this->belongsTo(ClientCategory::class);
    }
}
