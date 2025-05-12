<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangayAssitant extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'barangay_assitants';
    public function assistances()
    {
        return $this->belongsTo(Assistance::class, 'assistance_id');
    }
}
