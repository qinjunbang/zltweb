<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankCard extends Model
{
    protected $fillable = ['mobile','card_number','card_message','card_name','mobile_card','id_card_type','id_card','uid','created_at','updated_at','prov','city'];
}