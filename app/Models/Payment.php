<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'appointment_id',
        'uploaded_by',
        'validated_by',
        'image_path',
        'payment_method',
        'amount',
        'status',
        'uploaded_at',
        'validated_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'uploaded_at' => 'datetime',
        'validated_at' => 'datetime',
    ];

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
    
    public function validator()
    {
        return $this->belongsTo(User::class, 'validated_by');
    }
}
