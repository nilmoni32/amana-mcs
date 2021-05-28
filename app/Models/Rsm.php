<?php

namespace App\Models;

use App\Models\Rsmnominee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rsm extends Model
{
    use HasFactory;

    /**
    * @var array
    */
    protected $fillable = ['rsm_code','name', 'appointment_date','father_name', 'husband_name','mother_name','date_of_birth', 'contact_no',
   'email', 'nid', 'present_address', 'permanent_address', 'dgm_name', 'gm_name', 'dgm_code', 'gm_code',
   'requirement_type', 'mr_no', 'mr_amount', 'branch_name', 'branch_code', 'photo', 'signature', 
   'dgm_code_change_notes', 'gm_code_change_notes'];


   /**
     * Defining One to Many Relations 
    * so one product may have many attributes
    * @return \Illuminate\Database\Eloquent\Relations\HasMany      
    */
    public function rsmnominees(){
        return $this->hasMany(Rsmnominee::class);
    }
}
