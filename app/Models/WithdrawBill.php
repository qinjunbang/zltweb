<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WithdrawBill extends Model
{
    //   
     public $table='withdraw_bills';
     protected $fillable = [
						     'bills_id',
						     'card_number',
						     'check_code',
						     'money',
						     'time'
						     ];
}
