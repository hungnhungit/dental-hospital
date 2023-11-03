<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class PhanQuyen extends Model
{
    use HasFactory;

    public $table = 'quyen';

    public $timestamps = false;

    protected $primaryKey = 'Id';

    protected $fillable = [];

    public function ham(): BelongsToMany
    {
        return $this->belongsToMany(Ham::class, 'phanquyenham', 'PhanQuyenId', 'HamId')->as('payload')->withPivot('on');
    }
}
