<?php

namespace App\Http\Controllers;

use App\Models\Dgm;
use App\Models\Dgmnominee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class DGMNomineeController extends Controller
{
    public function index($id){ 
        //Getting the DGM Chain Code.
        $dgm = Dgm::find($id);
        //listing all the Nominees for the DGM chain Code       
        $dgmNominees =  Dgmnominee::orderBy('created_at', 'DESC')->where('dgm_id', $dgm->id)->get();
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'DGM Nominee List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);      
        return view('chaincode.dgm.nominee.index', compact('dgm','dgmNominees'));  
    }

    public function create($id){
        //Getting the DGM Chain Code.
        $dgm = Dgm::find($id);
        view()->share(['pageTitle' => 'Add DGM Nominee', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);                
        return view('chaincode.dgm.nominee.create', compact('dgm'));         
    }
    
    public function store(Request $request){
       // dd($request->all());
         $this->validate($request,[ 
             'name'          => 'required|string|max:191',
             'father_name'   => 'nullable|string|max:191',
             'husband_name'  => 'nullable|string|max:191', 
             'mother_name'   => 'nullable|string|max:191',
             'date_of_birth' => 'required|date',
             'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:dgmnominees,contact_no',
             'email'         => 'nullable|email|unique:dgmnominees,email', 
             'nid'           => 'nullable|numeric|unique:dgmnominees,nid', 
             'present_address'   => 'nullable|max:255', 
             'permanent_address' => 'nullable|max:255',
             'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
             'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
             'relation'      => 'required|string', 
             'relation_percentage'=> 'required|numeric', 
         ]);
 
         //coverting date format from m-d-Y to Y-m-d as database stores date in 'Y-m-d' format        
         $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
                 
         $dgmNominee = Dgmnominee::create([
             'dgm_id'            => $request->dgm_id,
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
 
         // uploading image for DGM opening Account   
         if($request->hasFile('photo') && $request->hasFile('signature')) {           
             $imgPhoto       = $request->photo->getClientOriginalName();  
             $imgSignature   = $request->signature->getClientOriginalName();           
             $request->photo->storeAs('images', $imgPhoto, 'public'); 
             $request->signature->storeAs('images', $imgSignature, 'public');
             // store image at storage/app/public/images. 
             // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
             $dgmNominee->update(['photo'=> $imgPhoto, 'signature'=> $imgSignature, ]); // if image exists for that ingredient we just update it 
         } 
 
         
         if($dgmNominee){
             session()->flash('success', 'New DGM Account is added successfully'); 
             return redirect()->route('DGMcode.nominee.index', $dgmNominee->dgm_id);
             
         }else{            
             session()->flash('error', 'Error occurred while adding new DGM Account.');  
             return redirect()->back();   
         }
     }

    public function show($id){
        //Getting the DGM Nominee Account.
        $dgmNominee = Dgmnominee::find($id);
        //getting the DGM Account using DGM Nominee Foreign-key.
        $dgm = Dgm::find($dgmNominee->dgm_id);
        view()->share(['pageTitle' => 'DGM Nominee Personal Details', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.dgm.nominee.show', compact('dgm', 'dgmNominee'));  
    }


    public function edit($id){
        //Getting the DGM Nominee Account.
        $dgmNominee = Dgmnominee::find($id);
        //getting the DGM Account using DGM Nominee Foreign-key.
        $dgm = Dgm::find($dgmNominee->dgm_id);               
        view()->share(['pageTitle' => 'Edit DGM Nominee Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);          
        return view('chaincode.dgm.nominee.edit', compact('dgm', 'dgmNominee'));   
    }

    public function update(Request $request){
        //dd($request->all());
        $this->validate($request,[ 
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'date_of_birth' => 'required|date',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:dgmnominees,contact_no,' . $request->id,  //append the id of the instance currently being updated to ignore the unique validator,
            'email'         => 'nullable|email|unique:dgmnominees,email,'. $request->id,  //append the id of the instance currently being updated to ignore the unique validator,, 
            'nid'           => 'nullable|numeric|unique:dgmnominees,nid,'. $request->id,  //append the id of the instance currently being updated to ignore the unique validator,, 
            'present_address'   => 'nullable|max:255', 
            'permanent_address' => 'nullable|max:255',
            'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'relation'      => 'required|string', 
            'relation_percentage'=> 'required|numeric', 
        ]);

        //coverting date format from m-d-Y to Y-m-d as database stores date in 'Y-m-d' format        
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');

        // Getting the DGM Nominee Record.
        $dgmNominee= Dgmnominee::find($request->id);
                
        // updating the Dgm Nominee data.
        
        $dgmNominee->name =  $request->name;  
        $dgmNominee->father_name =  $request->father_name;
        $dgmNominee->husband_name =  $request->husband_name;
        $dgmNominee->mother_name = $request->mother_name;
        $dgmNominee->date_of_birth = $date_of_birth;
        $dgmNominee->contact_no = $request->contact_no;
        $dgmNominee->email = $request->email;
        $dgmNominee->nid = $request->nid;
        $dgmNominee->present_address = $request->present_address;
        $dgmNominee->permanent_address = $request->permanent_address;
        $dgmNominee->relation = $request->relation;
        $dgmNominee->relation_percentage = $request->relation_percentage;
        $dgmNominee->save();

        // uploading the new image for Dgm   
        if($request->hasFile('photo')) {           
            $imageName = $request->photo->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($dgmNominee->photo){
                Storage::delete('/public/images/'.$dgmNominee->photo);
            }          
            $request->photo->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $dgmNominee->update(['photo'=> $imageName ]); // if image exists for that ingredient we just update it 
        }

        // uploading the new image for Dgm Signature  
        if($request->hasFile('signature')) {           
            $imageName = $request->signature->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($dgmNominee->signature){
                Storage::delete('/public/images/'.$dgmNominee->signature);
            }          
            $request->signature->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $dgmNominee->update(['signature'=> $imageName ]); // if image exists for that ingredient we just update it 
        } 

        
        if($dgmNominee){
            session()->flash('success', 'DGM Nominee Account is Updated successfully'); 
            return redirect()->route('DGMcode.nominee.index', $dgmNominee->dgm_id);
            
        }else{            
            session()->flash('error', 'Error occurred while Updating this DGM Nominee Account.');  
            return redirect()->back();   
        }
    }


    public function delete($id){
        
        $dgmNominee = Dgmnominee::find($id);
        //storing the dgm id before deleting the nominee id.
        $id = $dgmNominee->dgm_id;
        //deleting the image if it is stored in Storage/app/public/images
        if($dgmNominee->photo){
            Storage::delete('/public/images/'.$dgmNominee->photo);
        }
        if($dgmNominee->signature){
            Storage::delete('/public/images/'.$dgmNominee->signature);
        }

        $dgmNominee->delete();

        if(!$dgmNominee){
            session()->flash('error', 'Error occurred while deleting the DGM Nominee Account.');  
            return redirect()->back();   
         }
        session()->flash('success', 'DGM Nominee Account is deleted successfully'); 
        return redirect()->route('DGMcode.nominee.index', $id);
    
    }




}
