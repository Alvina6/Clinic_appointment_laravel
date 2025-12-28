<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'specialization',
        'available_from',
        'available_to',
        'available_days',
        'description',
    ];

    protected $hidden = [
        'password',
    ];

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function getTimingAttribute()
    {
        return $this->available_from . ' - ' . $this->available_to;
    }

    public function getAvailableDaysArrayAttribute()
    {
        return json_decode($this->available_days, true) ?? [];
    }
}