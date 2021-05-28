<?php

namespace App\Models;

use App\Models\Gmnominee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gm extends Model
{
    use HasFactory;
    /**
    * @var array
    */
    protected $fillable = ['gm_code','name', 'appointment_date','father_name', 'husband_name','mother_name','date_of_birth', 'contact_no',
   'email', 'nid', 'present_address', 'permanent_address', 'requirement_type', 'mr_no', 'mr_amount', 'branch_name',
   'branch_code', 'photo', 'signature'];


   /**
     * Defining One to Many Relations 
    * so one product may have many attributes
    * @return \Illuminate\Database\Eloquent\Relations\HasMany      
    */
    public function gmnominees(){
        return $this->hasMany(Gmnominee::class);
    }
}
