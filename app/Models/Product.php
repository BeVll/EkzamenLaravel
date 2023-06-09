<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable =[
        'name',
        'priority',
        'price',
        'discountPrice',
        'isDeleted',
        'category_id',
        'description',
        'status'
    ];
}
