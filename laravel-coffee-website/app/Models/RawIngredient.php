<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RawIngredient extends Model
{
    use HasFactory;
    protected $table = 'tbl_raw_ingredient';
    protected $guarded = [];

    public function ingredient()
    {
        return $this->hasMany(Ingredient::class);
    }
}
