<?php

namespace App\Models;

use App\Models\Bm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bmnominee extends Model
{
    use HasFactory;

     /**
     * @var array
     */
    protected $fillable = ['bm_id','name', 'father_name', 'husband_name','mother_name','date_of_birth', 'contact_no',
   'email', 'nid', 'present_address', 'permanent_address', 'photo', 'signature', 'relation', 'relation_percentage'];

   /**
     * Defining inverse relationship.
     * it means this product image belongs to a particular product.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bmchaincode(){
        return $this->belongsTo(Bm::class);        
    }
}
