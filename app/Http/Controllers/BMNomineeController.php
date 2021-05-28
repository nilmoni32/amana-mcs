<?php

namespace App\Http\Controllers;


use App\Models\Bm;
use App\Models\Bmnominee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;


class BMNomineeController extends Controller
{
    public function index($id){ 
        //Getting the BM Chain Code.
        $bm = Bm::find($id);
        //listing all the Nominees for the BM chain Code       
        $bmNominees =  Bmnominee::orderBy('created_at', 'DESC')->where('bm_id', $bm->id)->get();
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'BM Nominee List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);      
        return view('chaincode.bm.nominee.index', compact('bm','bmNominees'));  
    }


    public function show($id){
        //Getting the BM Nominee Account.
        $bmNominee = Bmnominee::find($id);
        //getting the BM Account using BM Nominee Foreign-key.
        $bm = Bm::find($bmNominee->bm_id);
        view()->share(['pageTitle' => 'BM Nominee Personal Details', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.bm.nominee.show', compact('bm', 'bmNominee'));  
    }

    public function create($id){
        //Getting the BM Chain Code.
        $bm = Bm::find($id);
        view()->share(['pageTitle' => 'Add BM Nominee', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);                
        return view('chaincode.bm.nominee.create', compact('bm'));         
    }

    public function store(Request $request){

        $this->validate($request,[ 
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:bmnominees,contact_no',
            'email'         => 'nullable|email|unique:bmnominees,email', 
            'nid'           => 'nullable|numeric|unique:bmnominees,nid', 
            'present_address'   => 'nullable|max:255', 
            'date_of_birth' => 'required|date',
            'permanent_address' => 'nullable|max:255',
            'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'relation'      => 'required|string', 
            'relation_percentage'=> 'required|numeric', 
        ]);

        //coverting date format from m-d-Y to Y-m-d as database stores date in 'Y-m-d' format        
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
                
        $bmNominee = Bmnominee::create([
            'bm_id'             => $request->bm_id,
            'name'              => $request->name,
            'father_name'       => $request->father_name, 
            'husband_name'      => $request->husband_name,
            'mother_name'       => $request->mother_name,
            'date_of_birth'     => $date_of_birth,
            'contact_no'        => $request->contact_no,
            'email'             => $request->email,
            'nid'               => $request->nid,
            'present_address'   => $request->present_address,
            'permanent_address' => $request->permanent_address,
            'relation'          => $request->relation,
            'relation_percentage' => $request->relation_percentage,
        ]);

        // uploading image for BM opening Account   
        if($request->hasFile('photo') && $request->hasFile('signature')) {           
            $imgPhoto       = $request->photo->getClientOriginalName();  
            $imgSignature   = $request->signature->getClientOriginalName();           
            $request->photo->storeAs('images', $imgPhoto, 'public'); 
            $request->signature->storeAs('images', $imgSignature, 'public');
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $bmNominee->update(['photo'=> $imgPhoto, 'signature'=> $imgSignature, ]); // if image exists for that ingredient we just update it 
        } 

        
        if($bmNominee){
            session()->flash('success', 'New BM Account is added successfully'); 
            return redirect()->route('BMcode.nominee.index', $bmNominee->bm_id);
            
        }else{            
            session()->flash('error', 'Error occurred while adding new BM Account.');  
            return redirect()->back();   
        }
    }

    public function edit($id){
        //Getting the BM Nominee Account.
        $bmNominee = Bmnominee::find($id);
        //getting the BM Account using BM Nominee Foreign-key.
        $bm = Bm::find($bmNominee->bm_id);
        view()->share(['pageTitle' => 'Edit BM Nominee Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);          
        return view('chaincode.bm.nominee.edit', compact('bm', 'bmNominee'));   
    }

    public function update(Request $request){

        $this->validate($request,[ 
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:bmnominees,contact_no,' . $request->id,  //append the id of the instance currently being updated to ignore the unique validator,
            'email'         => 'nullable|email|unique:bmnominees,email,'. $request->id,  //append the id of the instance currently being updated to ignore the unique validator,, 
            'nid'           => 'nullable|numeric|unique:bmnominees,nid,'. $request->id,  //append the id of the instance currently being updated to ignore the unique validator,, 
            'present_address'   => 'nullable|max:255', 
            'permanent_address' => 'nullable|max:255',
            'date_of_birth' => 'required|date',
            'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'relation'      => 'required|string', 
            'relation_percentage'=> 'required|numeric', 
        ]);

        //coverting date format from m-d-Y to Y-m-d as database stores date in 'Y-m-d' format        
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');

        // Getting the Bm Nominee Record.
        $bmNominee= Bmnominee::find($request->id);
                
        // updating the Bm Nominee data.
        
        $bmNominee->name =  $request->name;  
        $bmNominee->father_name =  $request->father_name;
        $bmNominee->husband_name =  $request->husband_name;
        $bmNominee->mother_name = $request->mother_name;
        $bmNominee->date_of_birth = $date_of_birth;
        $bmNominee->contact_no = $request->contact_no;
        $bmNominee->email = $request->email;
        $bmNominee->nid = $request->nid;
        $bmNominee->present_address = $request->present_address;
        $bmNominee->permanent_address = $request->permanent_address;
        $bmNominee->relation = $request->relation;
        $bmNominee->relation_percentage = $request->relation_percentage;
        $bmNominee->save();

        // uploading the new image for Bm   
        if($request->hasFile('photo')) {           
            $imageName = $request->photo->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($bmNominee->photo){
                Storage::delete('/public/images/'.$bmNominee->photo);
            }          
            $request->photo->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $bmNominee->update(['photo'=> $imageName ]); // if image exists for that ingredient we just update it 
        }

        // uploading the new image for Bm Signature  
        if($request->hasFile('signature')) {           
            $imageName = $request->signature->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($bmNominee->signature){
                Storage::delete('/public/images/'.$bmNominee->signature);
            }          
            $request->signature->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $bmNominee->update(['signature'=> $imageName ]); // if image exists for that ingredient we just update it 
        } 

        
        if($bmNominee){
            session()->flash('success', 'BM Nominee Account is Updated successfully'); 
            return redirect()->route('BMcode.nominee.index', $bmNominee->bm_id);
            
        }else{            
            session()->flash('error', 'Error occurred while Updating this BM Nominee Account.');  
            return redirect()->back();   
        }
    }

    public function delete($id){
        
        $bmNominee = Bmnominee::find($id);
        //storing the bm id before deleting the nominee id.
        $id = $bmNominee->bm_id;
        //deleting the image if it is stored in Storage/app/public/images
        if($bmNominee->photo){
            Storage::delete('/public/images/'.$bmNominee->photo);
        }
        if($bmNominee->signature){
            Storage::delete('/public/images/'.$bmNominee->signature);
        }

        $bmNominee->delete();

        if(!$bmNominee){
            session()->flash('error', 'Error occurred while deleting the BM Nominee Account.');  
            return redirect()->back();   
         }
        session()->flash('success', 'BM Nominee Account is deleted successfully'); 
        return redirect()->route('BMcode.nominee.index', $id);
    
    }

}
