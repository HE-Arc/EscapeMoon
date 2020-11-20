<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedScanario extends Model
{
    use HasFactory;

    protected $table = 'saved_scenarios';
    public $timestamps = false;
}
