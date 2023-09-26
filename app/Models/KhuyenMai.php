<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhuyenMai extends Model
{
    use HasFactory;

    public $table = 'KhuyenMai';

    public $timestamps = false;

    protected $fillable = [];
}
