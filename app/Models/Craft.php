<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Craft extends Model
{
    use HasFactory;

    protected $table = 'crafts';
    public $timestamps = false;

    public function firstItem()
    {
        return $this->belongsTo('App\Models\Item', 'first_item_id');
    }

    public function secondItem()
    {
        return $this->belongsTo('App\Models\Item', 'second_item_id');
    }

    public function resultItem()
    {
        return $this->belongsTo('App\Models\Item', 'result_item_id');
    }
}