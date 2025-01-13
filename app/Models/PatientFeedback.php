<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientFeedback extends Model
{

    protected $fillable = [


        'name','age','mobile','email','patient_id','image','message'

    ];
    protected $table = 'patient_feedbacks';
}
