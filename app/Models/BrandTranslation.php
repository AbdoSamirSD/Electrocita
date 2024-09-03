<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BrandTranslation extends Model
{
    use HasFactory;

    protected $table = 'brands_translations';

    protected $fillable = [
        'name',
        'locale',
        'brand_id',
    ];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
}
