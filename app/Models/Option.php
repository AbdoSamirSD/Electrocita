<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    use Translatable;
    protected $translatedAttributes = ['name'];
    protected $with = ['translations'];
    protected $fillable = ['attribute_id', 'product_id'];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'product_id');
    }
}
