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
        'name',
        'content', // Include the content attribute for mass assignment
        'expiry_date',
        'domain_buyer', // Include the domain buyer attribute for mass assignment
        'email_status',
        'client_email', // Include the client email attribute for mass assignment
        'status', // Include the status attribute for mass assignment


    ];
}
