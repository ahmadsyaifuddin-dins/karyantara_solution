<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_name',
        'ip_address',
        'browser',
        'os',
        'device_type',
        'location',
        'isp',
        'visitor_type',  
        'visitor_name',  
        'raw_user_agent',
    ];
}