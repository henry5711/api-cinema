<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class Movie extends Model
{
    use HasFactory, HasRoles, SoftDeletes;
    protected $fillable = [
        'name',
        'duration',
        'gender_id',
        'description'
    ];

    public function gender()
    {
        return $this->hasOne(Gender::class, 'id', 'name');
    }
}
