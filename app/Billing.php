<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{

  public function billdetail(){
    return $this->hasMany(BillingDetail::class,'billing_id');
  }

  public function customer(){
    return $this->hasOne(Customer::class, 'id', 'customer_id');
  }

  protected $fillable = [
    'billing_date',
    'customer_id',
    'status_id',
    'amount',
    'comment'
  ];
}
