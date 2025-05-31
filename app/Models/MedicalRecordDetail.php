<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalRecordDetail extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'medical_record_id',
        'appointment_id',
        'diagnosis',
        'treatment',
        'notes'
    ];

    public function medicalRecord()
    {
        return $this->belongsTo(MedicalRecord::class);
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }
}
