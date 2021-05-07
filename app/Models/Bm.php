<?php

namespace App\Models;

use App\Models\Bmnominee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bm extends Model
{
    use HasFactory;
    
     /**
     * @var array
     */
    protected $fillable = ['bm_code','name', 'appointment_date','father_name', 'husband_name','mother_name','date_of_birth', 'contact_no',
   'email', 'nid', 'present_address', 'permanent_address', 'asm_name', 'rsm_name', 'dgm_name', 'gm_name', 'asm_code', 'rsm_code', 'dgm_code', 'gm_code',
   'requirement_type', 'mr_no', 'mr_amount', 'branch_name', 'branch_code', 'photo', 'signature', 'asm_code_change_notes', 'rsm_code_change_notes', 
   'dgm_code_change_notes', 'gm_code_change_notes'];


   /**
     * Defining One to Many Relations 
    * so one product may have many attributes
    * @return \Illuminate\Database\Eloquent\Relations\HasMany      
    */
    public function bmnominees(){
        return $this->hasMany(Bmnominee::class);
    }


   
}
