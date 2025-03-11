<?php

namespace App\Models;

use App\Models\Assistance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Barangay extends Model
{
    use HasFactory;
    protected $fillable = [
        'outlet_name',
        'outlet_address',
        'latitude',
        'longtitude'
    ];
}
