<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory, Notifiable;
    
    protected $fillable = [
        'title', 'name', 'video'
    ];
}
