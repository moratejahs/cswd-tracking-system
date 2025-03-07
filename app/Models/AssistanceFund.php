<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssistanceFund extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'code',
        'assistance_name',
        'description',
    ];
}