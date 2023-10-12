<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    use HasFactory;

    public $table = 'thanhtoan';

    protected $primaryKey = 'idTT';

    public $timestamps = false;

    protected $fillable = [];
}
