<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Passager extends Model
{ 
     use HasFactory;

    protected $fillable = [
        'user_id', 
        'adresse', 
        'telephone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
