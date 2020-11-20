<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedItem extends Model
{
    use HasFactory;

    protected $table = 'saved_items';
    public $timestamps = false;
}
