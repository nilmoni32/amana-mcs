<?php

namespace App\Http\Controllers;

use App\Models\Mo;
use App\Models\Monominee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class MONomineeController extends Controller
{
    public function index($id){ 
        //Getting the Mo Chain Code.
        $mo = Mo::find($id);
        //listing all the Nominees for the BM chain Code       
        $moNominees =  Monominee::orderBy('created_at', 'DESC')->where('mo_id', $mo->id)->get();
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'MO Nominee List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);      
        return view('chaincode.mo.nominee.index', compact('mo','moNominees'));  
    }

    public function create($id){
        //Getting the MO Chain Code.
        $mo = Mo::find($id);
        view()->share(['pageTitle' => 'Add MO Nominee', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);                
        return view('chaincode.mo.nominee.create', compact('mo'));         
    }

    public function store(Request $request){

        //dd($request->all());
        $this->validate($request,[ 
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:bms,contact_no',
            'email'         => 'nullable|email|unique:bms,email', 
            'nid'           => 'nullable|numeric|unique:bms,nid', 
            'present_address'   => 'nullable|max:255', 
            'permanent_address' => 'nullable|max:255',
            'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'relation'      => 'required|string', 
            'relation_percentage'=> 'required|numeric', 
        ]);

        //coverting date format from m-d-Y to Y-m-d as database stores date in 'Y-m-d' format        
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
                
        $moNominee = Monominee::create([
            'mo_id'             => $request->mo_id,
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
            $moNominee->update(['photo'=> $imgPhoto, 'signature'=> $imgSignature, ]); // if image exists for that ingredient we just update it 
        } 

        
        if($moNominee){
            session()->flash('success', 'New MO Account is added successfully'); 
            return redirect()->route('MOcode.nominee.index', $moNominee->mo_id);
            
        }else{            
            session()->flash('error', 'Error occurred while adding new MO Account.');  
            return redirect()->back();   
        }
    }

    public function show($id){
        //Getting the MO Nominee Account.
        $moNominee = Monominee::find($id);
        //getting the MO Account using MO Nominee Foreign-key.
        $mo = Mo::find($moNominee->mo_id);
        view()->share(['pageTitle' => 'MO Nominee Personal Details', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.mo.nominee.show', compact('mo', 'moNominee'));  
    }

    public function edit($id){
        //Getting the MO Nominee Account.
        $moNominee = Monominee::find($id);
        //getting the MO Account using MO Nominee Foreign-key.
        $mo = Mo::find($moNominee->mo_id);
        view()->share(['pageTitle' => 'Edit MO Nominee Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);          
        return view('chaincode.mo.nominee.edit', compact('mo', 'moNominee'));   
    }

    public function update(Request $request){

        $this->validate($request,[ 
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:bms,contact_no,' . $request->id,  //append the id of the instance currently being updated to ignore the unique validator,
            'email'         => 'nullable|email|unique:bms,email,'. $request->id,  //append the id of the instance currently being updated to ignore the unique validator,, 
            'nid'           => 'nullable|numeric|unique:bms,nid,'. $request->id,  //append the id of the instance currently being updated to ignore the unique validator,, 
            'present_address'   => 'nullable|max:255', 
            'permanent_address' => 'nullable|max:255',
            'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'relation'      => 'required|string', 
            'relation_percentage'=> 'required|numeric', 
        ]);

        //coverting date format from m-d-Y to Y-m-d as database stores date in 'Y-m-d' format        
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');

        // Getting the Bm Nominee Record.
        $moNominee= Monominee::find($request->id);
                
        // updating the Bm Nominee data.        
        $moNominee->name =  $request->name;  
        $moNominee->father_name =  $request->father_name;
        $moNominee->husband_name =  $request->husband_name;
        $moNominee->mother_name = $request->mother_name;
        $moNominee->date_of_birth = $date_of_birth;
        $moNominee->contact_no = $request->contact_no;
        $moNominee->email = $request->email;
        $moNominee->nid = $request->nid;
        $moNominee->present_address = $request->present_address;
        $moNominee->permanent_address = $request->permanent_address;
        $moNominee->relation = $request->relation;
        $moNominee->relation_percentage = $request->relation_percentage;
        $moNominee->save();

        // uploading the new image for Bm   
        if($request->hasFile('photo')) {           
            $imageName = $request->photo->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($moNominee->photo){
                Storage::delete('/public/images/'.$moNominee->photo);
            }          
            $request->photo->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $moNominee->update(['photo'=> $imageName ]); // if image exists for that ingredient we just update it 
        }

        // uploading the new image for Bm Signature  
        if($request->hasFile('signature')) {           
            $imageName = $request->signature->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($moNominee->signature){
                Storage::delete('/public/images/'.$moNominee->signature);
            }          
            $request->signature->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $moNominee->update(['signature'=> $imageName ]); // if image exists for that ingredient we just update it 
        } 

        
        if($moNominee){
            session()->flash('success', 'MO Nomineee Account is Updated successfully'); 
            return redirect()->route('MOcode.nominee.index', $moNominee->mo_id);
            
        }else{            
            session()->flash('error', 'Error occurred while updating the MO Nominee Account.');  
            return redirect()->back();   
        }
    }

    public function delete($id){
        
        // Getting the Bm Nominee Record.
        $moNominee= Monominee::find($id);
        //storing the mo id before deleting the nominee account.
        $id = $moNominee->mo_id;
        //deleting the image if it is stored in Storage/app/public/images
        if($moNominee->photo){
            Storage::delete('/public/images/'.$moNominee->photo);
        }
        if($moNominee->signature){
            Storage::delete('/public/images/'.$moNominee->signature);
        }

        $moNominee->delete();

        if(!$moNominee){
            session()->flash('error', 'Error occurred while deleting the MO Nominee Account.');  
            return redirect()->back();   
         }
        session()->flash('success', 'MO Nominee Account is deleted successfully'); 
        return redirect()->route('MOcode.nominee.index', $id);
    
    }

}
