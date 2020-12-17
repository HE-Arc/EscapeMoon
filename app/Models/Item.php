<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    public $timestamps = false;

    public function scenario()
    {
        return $this->belongsTo('App\Models\Scenario');
    }

    public function savedItems()
    {
        return $this->hasMany('App\Models\SavedItem');
    }
}
