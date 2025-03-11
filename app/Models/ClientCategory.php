<?php

namespace App\Models;

use App\Models\Assistance;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientCategory extends Model
{
    use HasFactory;
    protected $fillable = ['code', 'description'];


}
