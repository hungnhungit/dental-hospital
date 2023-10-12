<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoaiVatTu extends Model
{
    use HasFactory;

    public $table = 'loaivattu';

    public $timestamps = false;

    protected $primaryKey = 'idLoaiVT';

    protected $fillable = [];
}
