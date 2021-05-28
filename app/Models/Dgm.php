<?php

namespace App\Models;

use App\Models\Dgmnominee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dgm extends Model
{
    use HasFactory;

    /**
    * @var array
    */
    protected $fillable = ['dgm_code','name', 'appointment_date','father_name', 'husband_name','mother_name','date_of_birth', 'contact_no',
   'email', 'nid', 'present_address', 'permanent_address', 'gm_name', 'gm_code', 'requirement_type', 'mr_no', 'mr_amount', 'branch_name',
   'branch_code', 'photo', 'signature', 'gm_code_change_notes'];


   /**
     * Defining One to Many Relations 
    * so one product may have many attributes
    * @return \Illuminate\Database\Eloquent\Relations\HasMany      
    */
    public function dgmnominees(){
        return $this->hasMany(Dgmnominee::class);
    }
}
