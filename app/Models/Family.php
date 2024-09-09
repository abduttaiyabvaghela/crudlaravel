<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $fillable = [
        'name', 'surname', 'birthdate', 'mobile', 'address', 'state', 'city', 'pincode', 
        'marital_status', 'wedding_date', 'hobbies', 'photo'
    ];

    protected $casts = [
        'hobbies' => 'array',
    ];

    public function members()
    {
        return $this->hasMany(FamilyMember::class);
    }
}
