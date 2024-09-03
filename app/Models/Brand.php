<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    use Translatable;
    protected $fillable = [
        'photo',
        'is_active'
    ];

    public $casts = [
        'is_active' => 'boolean'
    ];

    public $with = ['translations'];
    public function translations(){
        return $this->hasMany(BrandTranslation::class);
    }

    public $translatedAttributes = [
        'name',
    ];
}
