<?php

namespace App\Http\Controllers;

use App\Models\Rsm;
use App\Models\Rsmnominee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class RSMNomineeController extends Controller
{
    
    public function index($id){ 
        //Getting the RSM Chain Code.
        $rsm = Rsm::find($id);
        //listing all the Nominees for the RSM chain Code       
        $rsmNominees =  Rsmnominee::orderBy('created_at', 'DESC')->where('rsm_id', $rsm->id)->get();
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'RSM Nominee List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);      
        return view('chaincode.rsm.nominee.index', compact('rsm','rsmNominees'));  
    }

    public function create($id){
        //Getting the RSM Chain Code.
        $rsm = Rsm::find($id);
        view()->share(['pageTitle' => 'Add RSM Nominee', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);                
        return view('chaincode.rsm.nominee.create', compact('rsm'));         
    }

    public function store(Request $request){
        //dd($request->all());
         $this->validate($request,[ 
             'name'          => 'required|string|max:191',
             'father_name'   => 'nullable|string|max:191',
             'husband_name'  => 'nullable|string|max:191', 
             'mother_name'   => 'nullable|string|max:191',
             'date_of_birth' => 'required|date',
             'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:rsmnominees,contact_no',
             'email'         => 'nullable|email|unique:rsmnominees,email', 
             'nid'           => 'nullable|numeric|unique:rsmnominees,nid', 
             'present_address'   => 'nullable|max:255', 
             'permanent_address' => 'nullable|max:255',
             'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
             'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
             'relation'      => 'required|string', 
             'relation_percentage'=> 'required|numeric', 
         ]);
 
         //coverting date format from m-d-Y to Y-m-d as database stores date in 'Y-m-d' format        
         $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
                 
         $rsmNominee = Rsmnominee::create([
             'rsm_id'            => $request->rsm_id,
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
 
         // uploading image for RSM opening Account   
         if($request->hasFile('photo') && $request->hasFile('signature')) {           
             $imgPhoto       = $request->photo->getClientOriginalName();  
             $imgSignature   = $request->signature->getClientOriginalName();           
             $request->photo->storeAs('images', $imgPhoto, 'public'); 
             $request->signature->storeAs('images', $imgSignature, 'public');
             // store image at storage/app/public/images. 
             // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
             $rsmNominee->update(['photo'=> $imgPhoto, 'signature'=> $imgSignature, ]); // if image exists for that ingredient we just update it 
         } 
 
         
         if($rsmNominee){
             session()->flash('success', 'New RSM Account is added successfully'); 
             return redirect()->route('RSMcode.nominee.index', $rsmNominee->rsm_id);
             
         }else{            
             session()->flash('error', 'Error occurred while adding new RSM Account.');  
             return redirect()->back();   
         }
     }


     public function show($id){
        //Getting the RSM Nominee Account.
        $rsmNominee = Rsmnominee::find($id);
        //getting the RSM Account using RSM Nominee Foreign-key.
        $rsm = Rsm::find($rsmNominee->rsm_id);
        view()->share(['pageTitle' => 'RSM Nominee Personal Details', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.rsm.nominee.show', compact('rsm', 'rsmNominee'));  
    }

    public function edit($id){
        //Getting the RSM Nominee Account.
        $rsmNominee = Rsmnominee::find($id);
        //getting the RSM Account using RSM Nominee Foreign-key.
        $rsm = Rsm::find($rsmNominee->rsm_id);                
        view()->share(['pageTitle' => 'Edit RSM Nominee Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);          
        return view('chaincode.rsm.nominee.edit', compact('rsm', 'rsmNominee'));   
    }

    public function update(Request $request){
        //dd($request->all());
        $this->validate($request,[ 
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'date_of_birth' => 'required|date',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:rsmnominees,contact_no,' . $request->id,  //append the id of the instance currently being updated to ignore the unique validator,
            'email'         => 'nullable|email|unique:rsmnominees,email,'. $request->id,  //append the id of the instance currently being updated to ignore the unique validator,, 
            'nid'           => 'nullable|numeric|unique:rsmnominees,nid,'. $request->id,  //append the id of the instance currently being updated to ignore the unique validator,, 
            'present_address'   => 'nullable|max:255', 
            'permanent_address' => 'nullable|max:255',
            'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'relation'      => 'required|string', 
            'relation_percentage'=> 'required|numeric', 
        ]);

        //coverting date format from m-d-Y to Y-m-d as database stores date in 'Y-m-d' format        
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');

        // Getting the RSM Nominee Record.
        $rsmNominee= Rsmnominee::find($request->id);
                
        // updating the Rsm Nominee data.
        
        $rsmNominee->name =  $request->name;  
        $rsmNominee->father_name =  $request->father_name;
        $rsmNominee->husband_name =  $request->husband_name;
        $rsmNominee->mother_name = $request->mother_name;
        $rsmNominee->date_of_birth = $date_of_birth;
        $rsmNominee->contact_no = $request->contact_no;
        $rsmNominee->email = $request->email;
        $rsmNominee->nid = $request->nid;
        $rsmNominee->present_address = $request->present_address;
        $rsmNominee->permanent_address = $request->permanent_address;
        $rsmNominee->relation = $request->relation;
        $rsmNominee->relation_percentage = $request->relation_percentage;
        $rsmNominee->save();

        // uploading the new image for Rsm   
        if($request->hasFile('photo')) {           
            $imageName = $request->photo->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($rsmNominee->photo){
                Storage::delete('/public/images/'.$rsmNominee->photo);
            }          
            $request->photo->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $rsmNominee->update(['photo'=> $imageName ]); // if image exists for that ingredient we just update it 
        }

        // uploading the new image for Rsm Signature  
        if($request->hasFile('signature')) {           
            $imageName = $request->signature->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($rsmNominee->signature){
                Storage::delete('/public/images/'.$rsmNominee->signature);
            }          
            $request->signature->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $rsmNominee->update(['signature'=> $imageName ]); // if image exists for that ingredient we just update it 
        } 

        
        if($rsmNominee){
            session()->flash('success', 'RSM Nominee Account is Updated successfully'); 
            return redirect()->route('RSMcode.nominee.index', $rsmNominee->rsm_id);
            
        }else{            
            session()->flash('error', 'Error occurred while Updating this RSM Nominee Account.');  
            return redirect()->back();   
        }
    }


    public function delete($id){
        
        $rsmNominee = Rsmnominee::find($id);
        //storing the rsm id before deleting the nominee id.
        $id = $rsmNominee->rsm_id;
        //deleting the image if it is stored in Storage/app/public/images
        if($rsmNominee->photo){
            Storage::delete('/public/images/'.$rsmNominee->photo);
        }
        if($rsmNominee->signature){
            Storage::delete('/public/images/'.$rsmNominee->signature);
        }

        $rsmNominee->delete();

        if(!$rsmNominee){
            session()->flash('error', 'Error occurred while deleting the RSM Nominee Account.');  
            return redirect()->back();   
         }
        session()->flash('success', 'RSM Nominee Account is deleted successfully'); 
        return redirect()->route('RSMcode.nominee.index', $id);
    
    }



}
