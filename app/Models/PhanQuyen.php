<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhanQuyen extends Model
{
    use HasFactory;

    public $table = 'quyen';

    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $fillable = [];
}