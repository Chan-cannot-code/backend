<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $primaryKey = 'product_id';

    protected $guarded = [];

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'description',
        'image',
        'category',
        'school_id'
    ];

    public function loginCredentials()
    {
        return $this->belongsTo(LoginCredential::class, 'school_id');
    }
}
