<?php

namespace App\Models;

use App\Models\Rsm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rsmnominee extends Model
{
    
    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['rsm_id','name', 'father_name', 'husband_name','mother_name','date_of_birth', 'contact_no',
   'email', 'nid', 'present_address', 'permanent_address', 'photo', 'signature', 'relation', 'relation_percentage'];

   /**
     * Defining inverse relationship.
     * it means this product image belongs to a particular product.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function rsmchaincode(){
        return $this->belongsTo(Rsm::class);        
    }

    
}
