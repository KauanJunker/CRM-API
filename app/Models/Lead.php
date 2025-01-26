<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Lead extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'status',
        'user_id'
    ];

    public function user() 
    {
        return $this->belongsTo(User::class);
    }
    
    public function tasks() 
    {
        return $this->hasMany(Task::class);
    }

    public function interactions() 
    {
        return $this->hasMany(Interaction::class);
    }

    public function appointments()
    {
    return $this->hasMany(Appointment::class);
    }

    public function routeNotificationFor()
    {
        return $this->email;
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = str_starts_with($value, '+55') ? $value : '+55' . ltrim($value, '0');
    }
}
