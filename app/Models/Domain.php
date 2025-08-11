<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domain extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'domain_name',
        'expiry_date',
        'domain_content',
        'domain_buyer',
        'client_email',
        'type_domain',
        'email_status',
        'status',


    ];
       protected $casts = [
        'client_email' => 'array', // JSON ↔ array auto convert
    ];
}

