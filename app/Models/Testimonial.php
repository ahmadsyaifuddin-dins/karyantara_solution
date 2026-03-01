<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_name',
        'email',
        'phone_number',
        'client_title',
        'testimonial',
        'rating',
        'profile_image',
        'is_approved',
        'ip_address',
        'user_agent',
    ];
}
