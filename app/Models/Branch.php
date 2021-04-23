<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

     /**
     * @var array
     */
    protected $fillable = ['branch_code','branch_name', 'incharge_code','designation', 'incharge_name','mobile_num','phone_num', 'address' ];
}
