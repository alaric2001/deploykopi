<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;
    protected $table = 'tbl_ingredient';
    protected $guarded = [];

    public function kopi()
    {
        return $this->belongsTo(Kopi::class);
    }

    public function raw_ingredient()
    {
        return $this->belongsTo(RawIngredient::class, 'rawingredient_id');
    }
}
