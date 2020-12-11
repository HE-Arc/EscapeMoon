<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedScene extends Model
{
    use HasFactory;

    protected $table = 'saved_scenes';
    public $timestamps = false;

    protected $fillable = [
        'scene_id',
        'saved_scenario_id',
        'locked',
    ];

    public function savedScenario()
    {
        return $this->belongsTo('App\Models\SavedScenario');
    }
}
