<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayAssitance extends Model
{
    use HasFactory;
    protected $fillable = ['assistance_id', 'barangay_id', 'status'];
}