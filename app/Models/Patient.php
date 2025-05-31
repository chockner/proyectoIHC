<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'blood_type',
        'allergies',
        'vaccines_received',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicalRecords()
    {
        return $this->hasOne(MedicalRecord::class);
        /* return $this->hasMany(MedicalRecord::class); */
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
