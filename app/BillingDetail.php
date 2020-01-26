<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BillingDetail extends Model
{
  protected $fillable = [
    'billing_id',
    'reference_id',
    'quantity',
    'unit_price',
    'comment'
  ];
}
