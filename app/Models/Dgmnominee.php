<?php

namespace App\Models;

use App\Models\Dgm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Dgmnominee extends Model
{
    use HasFactory;

    use HasFactory;
    /**
     * @var array
     */
    protected $fillable = ['dgm_id','name', 'father_name', 'husband_name','mother_name','date_of_birth', 'contact_no',
   'email', 'nid', 'present_address', 'permanent_address', 'photo', 'signature', 'relation', 'relation_percentage'];

   /**
     * Defining inverse relationship.
     * it means this product image belongs to a particular product.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dgmchaincode(){
        return $this->belongsTo(Dgm::class);        
    }
}
