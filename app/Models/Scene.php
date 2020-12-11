<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scene extends Model
{
    use HasFactory;

    protected $table = 'scenes';
    public $timestamps = false;

    public function scenario()
    {
        return $this->belongsTo('App\Models\Scenario');
    }

    public function savedScenes()
    {
        return $this->hasMany('App\Models\SavedScene');
    }
}
