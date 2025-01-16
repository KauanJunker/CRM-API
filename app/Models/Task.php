<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'contact_id', // Opcional: Associar a um contato
        'lead_id', // Opcional: Associar a um lead
        'due_at',
        'done'   
    ];

    protected $casts = [
        'due_at' => 'datetime',
    ];  

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function contact() {
        return $this->belongsTo(Contact::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
