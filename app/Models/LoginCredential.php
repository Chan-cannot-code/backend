<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\LoginCredential as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class LoginCredential extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'login_credentials';
    protected $guarded = [];


    public $incrementing = false;


    protected $primaryKey = 'school_id';


    protected $fillable = [
        'fullname',
        'custom_email',
        'school_id',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(LoginCredential::class, 'school_id');
    }

    public function products()
    {
        return $this->belongsTo(Products::class, 'product');
    }
}
