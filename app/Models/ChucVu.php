<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChucVu extends Model
{
    use HasFactory;

    public $table = 'chucvu';

    public $timestamps = false;

    protected $primaryKey = 'idCV';

    protected $fillable = [];
}
