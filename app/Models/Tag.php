<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name', 'slug', 'bg_color', 'text_color'];

    public function revisionTickets()
    {
        return $this->belongsToMany(RevisionTicket::class);
    }
}