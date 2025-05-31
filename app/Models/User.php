<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // test
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable; // test

class User extends Authenticatable
{
    use SoftDeletes;
    use HasFactory;
    use Notifiable; // test

    protected $fillable = [
        'role_id',
        'document_id', // DNI como identificador único
        /* 'email', */
        /* 'email_verified_at', */
        'password'
    ];

    /* protected $casts = [
        'email_verified_at' => 'datetime',
    ]; */

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function doctor()
    {
        return $this->hasOne(Doctor::class);
    }

    public function patient()
    {
        return $this->hasOne(Patient::class);
    }

    public function secretary()
    {
        return $this->hasOne(Secretary::class);
    }
    
    public function uploadedPayments()
    {
        return $this->hasMany(Payment::class, 'uploaded_by');
    }
    
    public function validatedPayments()
    {
        return $this->hasMany(Payment::class, 'validated_by');
    }
    
    public function auditLogs()
    {
        return $this->hasMany(AuditLog::class);
    }
}
