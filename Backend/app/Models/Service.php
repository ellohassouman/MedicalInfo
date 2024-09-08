<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'quantity',
        'service_price',
        'service_date',
        'control_date',
        'patient_sub_folder_id',
        'doctor_id',
        'health_institution_id',
        'tariff_id'
    ];
}
