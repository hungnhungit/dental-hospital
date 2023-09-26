<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BenhNhan extends Model
{
    use HasFactory;

    public $table = 'BenhNhan';

    public $timestamps = false;

    protected $fillable = [];
}
