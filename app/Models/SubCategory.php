<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    protected $table = 'sub_categories';
    protected $fillable = [
        'category_id',
        'translation_lang', 
        'translation_of',
        'name',
        'slug',
        'description',
        'photo',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function subcategoriesrel(){
        return $this->hasMany(SubCategory::class, 'translation_of');
    }
}
