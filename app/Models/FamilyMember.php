<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    protected $fillable = ['family_id', 'name', 'birthdate', 'is_married', 'wedding_date', 'education', 'photo'];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }
}