<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawJenisKopi extends Model
{
    use HasFactory;
    protected $table = 'tbl_raw_jenis_kopi';
    protected $guarded = [];

    public function jeniskopi()
    {
        return $this->hasMany(JenisKopi::class);
    }
}
