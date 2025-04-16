<?php

namespace App\Models;

use App\Models\Tutorial;
use Illuminate\Database\Eloquent\Model;

class DetailTutorial extends Model
{
    protected $fillable = [
        'tutorial_id', 'content', 'order', 'status'
    ];

    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class, 'tutorial_id');
    }
}
