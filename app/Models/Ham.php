<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ham extends Model
{
    use HasFactory;

    public $table = 'ham';

    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $guarded = [];
}
