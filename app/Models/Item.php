<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Item extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'items';
    protected $fillable = [
        'itemName',
        'itemDescription',
        'itemPrice',
    ];
}
