<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VatTu extends Model
{
    use HasFactory;

    public $table = 'vattu';

    public $timestamps = false;

    protected $primaryKey = 'idVattu';

    protected $fillable = [];
}
