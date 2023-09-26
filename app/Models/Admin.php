<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Admin extends Model
{
    use HasFactory;

    public $table = 'Admin';

    public $timestamps = false;

    protected $fillable = [];
}
