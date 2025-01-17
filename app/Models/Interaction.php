<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interaction extends Model
{
    protected $fillable = [
        "lead_id",
        "contact_id",
        "type",
        "details"
    ];

    public function lead() 
    {
        return $this->belongsTo(Lead::class);
    }

    public function contact() 
    {
        return $this->belongsTo(Lead::class);
    }
}
