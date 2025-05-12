<?php

namespace App\Models;

use DateTime;
use App\Models\Barangay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assistance extends Model
{
    use HasFactory;
    protected $guarded = [];
    // protected $fillable = [
    //     'first_name', 'middle_name', 'last_name',
    //     'birth_date', 'age', 'gender', 'address', 'contact_no',
    //     'occupation', 'contact_no',
    // ];

    public function barangays()
    {
        return $this->belongsTo(BarangayAssitant::class, 'barangay_id');
    }
}
