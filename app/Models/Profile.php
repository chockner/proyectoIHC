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

    /**
     * Obtiene el género en formato texto
     */
    public function getGenderTextAttribute()
    {
        $mapping = [
            '0' => 'Femenino',
            '1' => 'Masculino',
        ];
        
        return $mapping[$this->gender] ?? 'No especificado';
    }

    /**
     * Obtiene el estado civil en formato texto
     */
    public function getCivilStatusTextAttribute()
    {
        $mapping = [
            '0' => 'Soltero/a',
            '1' => 'Casado/a',
            '2' => 'Viudo/a',
            '3' => 'Divorciado/a',
        ];
        
        return $mapping[$this->civil_status] ?? 'No especificado';
    }
}
