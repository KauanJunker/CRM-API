<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'user_id',
        'lead_id',
        'appointment_date',
        'notes'
    ];

    protected $casts = [
        'appointment_date' => 'datetime',
    ];

    public function user()
    {
    return $this->belongsTo(User::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
