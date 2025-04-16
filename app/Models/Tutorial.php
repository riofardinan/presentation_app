<?php

namespace App\Models;

use App\Models\DetailTutorial;
use Illuminate\Database\Eloquent\Model;

class Tutorial extends Model
{
    protected $fillable = ['judul', 'kode_mata_kuliah', 'presentation', 'finished', 'creator_email'];

    public function details()
    {
        return $this->hasMany(DetailTutorial::class, 'tutorial_id');
    }  
}
