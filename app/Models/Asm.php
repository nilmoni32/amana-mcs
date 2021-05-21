<?php

namespace App\Models;

use App\Models\Asmnominee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Asm extends Model
{
    use HasFactory;

    /**
    * @var array
    */
    protected $fillable = ['asm_code','name', 'appointment_date','father_name', 'husband_name','mother_name','date_of_birth', 'contact_no',
   'email', 'nid', 'present_address', 'permanent_address', 'rsm_name', 'dgm_name', 'gm_name', 'rsm_code', 'dgm_code', 'gm_code',
   'requirement_type', 'mr_no', 'mr_amount', 'branch_name', 'branch_code', 'photo', 'signature', 'rsm_code_change_notes', 
   'dgm_code_change_notes', 'gm_code_change_notes'];


   /**
     * Defining One to Many Relations 
    * so one product may have many attributes
    * @return \Illuminate\Database\Eloquent\Relations\HasMany      
    */
    public function asmnominees(){
        return $this->hasMany(Asmnominee::class);
    }
}
