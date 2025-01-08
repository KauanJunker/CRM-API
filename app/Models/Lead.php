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
    ];

    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function routeNotificationFor()
    {
        return $this->email;
    }
}
