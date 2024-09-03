<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $table = 'languages';
    protected $fillable = [
        'abbr', 
        'locale',
        'name',
        'native',
        'direction',
        'active',
        ];

    protected $hidden = [
        'created_at', 
        'updated_at', 
        'active',
    
    ];

    public function scopeActive($query){
        return $query->where('active', 1);
    }
}
