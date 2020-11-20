<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scanario extends Model
{
    use HasFactory;

    protected $table = 'scenarios';
    public $timestamps = false;
}
