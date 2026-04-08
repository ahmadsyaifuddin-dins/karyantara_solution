<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevisionTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title',
        'type',
        'status',
        'description',
        'sort_order'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}