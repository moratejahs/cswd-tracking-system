<?php

namespace App\Models;

use DateTime;
use App\Models\Barangay;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assistance extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'birth_date',
        'address',
        'contact_no',
        'status',
        'occupation',
        'assistance',
        'quantity',
        'person_of_responsible',
    ];

}
