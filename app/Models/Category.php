<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'translation_lang', 
        'translation_of',
        'name',
        'slug',
        'active',
        'photo',
    ];

    protected $hidden = [
        'created_at', 
        'updated_at', 
    ];

    public function categoriesrel(){
        return $this->hasMany(Category::class, 'translation_of');
    }

    public function vendors(){
        return $this->hasMany(Vendor::class, 'category_id');
    }

    public function subcategory(){
        return $this->hasMany(Subcategory::class, 'category_id');
    }
}
