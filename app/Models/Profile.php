<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        /* 'document_id', */
        'email',
        'first_name',
        'last_name',
        'phone',
        'birthdate',
        'address',
        'gender',
        'photo',
        'civil_status',
        'region',
        'province',
        'district',
        'country'
    ];

    protected $casts = [
        'birthdate' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
