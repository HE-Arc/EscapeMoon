<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scenario extends Model
{
    use HasFactory;

    protected $table = 'scenarios';
    public $timestamps = false;

    public function firstScene()
    {
        return $this->belongsTo('App\Models\Scene', 'first_scene_id');
    }

    public function savedScenarios()
    {
        return $this->hasMany('App\Models\SavedScenario');
    }

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function scenes()
    {
        return $this->hasMany('App\Models\Scene');
    }
}
