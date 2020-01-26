<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
  protected $fillable = [
    'name',
    'description',
    'price',
    'type_id'
  ];
}
