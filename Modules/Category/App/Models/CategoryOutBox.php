<?php

namespace Modules\Category\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Category\Database\factories\OutBoxFactory;

class CategoryOutBox extends Model
{
    use HasFactory;

    protected $table = 'category_outbox';
    protected $guarded = [];

    protected $casts = [
        'payload' => 'array'
    ];

}
