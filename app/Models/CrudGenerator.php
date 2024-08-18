<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrudGenerator extends Model
{
    use HasFactory;

    protected $table = "crud_generator";

    protected $guarded = [];

    protected $casts = [
        'support' => 'array'
    ];
}
