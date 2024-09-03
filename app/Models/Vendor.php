<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
{
    use HasFactory;
    use Notifiable;
    protected $table = 'vendors';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'image',
        'status',
        'category_id'
    ];

    protected $hidden = [
        'category_id',
    ];

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    
}
