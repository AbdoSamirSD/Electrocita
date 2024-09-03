<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;
    use Translatable;
    protected $translatedAttributes = ['name'];
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'attribute_product');
    }
}
