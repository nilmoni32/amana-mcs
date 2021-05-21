<?php

namespace App\Http\Controllers;


use App\Models\Asm;
use App\Models\Asmnominee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class ASMNomineeController extends Controller
{
    public function index($id){ 
        //Getting the ASM Chain Code.
        $asm = Asm::find($id);
        //listing all the Nominees for the ASM chain Code       
        $asmNominees =  Asmnominee::orderBy('created_at', 'DESC')->where('asm_id', $asm->id)->get();
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'ASM Nominee List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);      
        return view('chaincode.asm.nominee.index', compact('asm','asmNominees'));  
    }

    public function create($id){
        //Getting the ASM Chain Code.
        $asm = Asm::find($id);
        view()->share(['pageTitle' => 'Add ASM Nominee', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);                
        return view('chaincode.asm.nominee.create', compact('asm'));         
    }

    public function store(Request $request){
       //dd($request->all());
        $this->validate($request,[ 
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:asmnominees,contact_no',
            'email'         => 'nullable|email|unique:asmnominees,email', 
            'nid'           => 'nullable|numeric|unique:asmnominees,nid', 
            'present_address'   => 'nullable|max:255', 
            'permanent_address' => 'nullable|max:255',
            'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'relation'      => 'required|string', 
            'relation_percentage'=> 'required|numeric', 
        ]);

        //coverting date format from m-d-Y to Y-m-d as database stores date in 'Y-m-d' format        
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
                
        $asmNominee = Asmnominee::create([
            'asm_id'            => $request->asm_id,
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

        // uploading image for ASM opening Account   
        if($request->hasFile('photo') && $request->hasFile('signature')) {           
            $imgPhoto       = $request->photo->getClientOriginalName();  
            $imgSignature   = $request->signature->getClientOriginalName();           
            $request->photo->storeAs('images', $imgPhoto, 'public'); 
            $request->signature->storeAs('images', $imgSignature, 'public');
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $asmNominee->update(['photo'=> $imgPhoto, 'signature'=> $imgSignature, ]); // if image exists for that ingredient we just update it 
        } 

        
        if($asmNominee){
            session()->flash('success', 'New ASM Account is added successfully'); 
            return redirect()->route('ASMcode.nominee.index', $asmNominee->asm_id);
            
        }else{            
            session()->flash('error', 'Error occurred while adding new ASM Account.');  
            return redirect()->back();   
        }
    }

    public function show($id){
        //Getting the ASM Nominee Account.
        $asmNominee = Asmnominee::find($id);
        //getting the ASM Account using ASM Nominee Foreign-key.
        $asm = Asm::find($asmNominee->asm_id);
        view()->share(['pageTitle' => 'ASM Nominee Personal Details', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.asm.nominee.show', compact('asm', 'asmNominee'));  
    }

    public function edit($id){
        //Getting the ASM Nominee Account.
        $asmNominee = Asmnominee::find($id);
        //getting the ASM Account using ASM Nominee Foreign-key.
        $asm = Asm::find($asmNominee->asm_id);
        view()->share(['pageTitle' => 'Edit ASM Nominee Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);          
        return view('chaincode.asm.nominee.edit', compact('asm', 'asmNominee'));   
    }

    public function update(Request $request){
        //dd($request->all());
        $this->validate($request,[ 
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:asmnominees,contact_no,' . $request->id,  //append the id of the instance currently being updated to ignore the unique validator,
            'email'         => 'nullable|email|unique:asmnominees,email,'. $request->id,  //append the id of the instance currently being updated to ignore the unique validator,, 
            'nid'           => 'nullable|numeric|unique:asmnominees,nid,'. $request->id,  //append the id of the instance currently being updated to ignore the unique validator,, 
            'present_address'   => 'nullable|max:255', 
            'permanent_address' => 'nullable|max:255',
            'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'relation'      => 'required|string', 
            'relation_percentage'=> 'required|numeric', 
        ]);

        //coverting date format from m-d-Y to Y-m-d as database stores date in 'Y-m-d' format        
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');

        // Getting the ASM Nominee Record.
        $asmNominee= Asmnominee::find($request->id);
                
        // updating the Asm Nominee data.
        
        $asmNominee->name =  $request->name;  
        $asmNominee->father_name =  $request->father_name;
        $asmNominee->husband_name =  $request->husband_name;
        $asmNominee->mother_name = $request->mother_name;
        $asmNominee->date_of_birth = $date_of_birth;
        $asmNominee->contact_no = $request->contact_no;
        $asmNominee->email = $request->email;
        $asmNominee->nid = $request->nid;
        $asmNominee->present_address = $request->present_address;
        $asmNominee->permanent_address = $request->permanent_address;
        $asmNominee->relation = $request->relation;
        $asmNominee->relation_percentage = $request->relation_percentage;
        $asmNominee->save();

        // uploading the new image for Asm   
        if($request->hasFile('photo')) {           
            $imageName = $request->photo->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($asmNominee->photo){
                Storage::delete('/public/images/'.$asmNominee->photo);
            }          
            $request->photo->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $asmNominee->update(['photo'=> $imageName ]); // if image exists for that ingredient we just update it 
        }

        // uploading the new image for Asm Signature  
        if($request->hasFile('signature')) {           
            $imageName = $request->signature->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($asmNominee->signature){
                Storage::delete('/public/images/'.$asmNominee->signature);
            }          
            $request->signature->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $asmNominee->update(['signature'=> $imageName ]); // if image exists for that ingredient we just update it 
        } 

        
        if($asmNominee){
            session()->flash('success', 'ASM Nominee Account is Updated successfully'); 
            return redirect()->route('ASMcode.nominee.index', $asmNominee->asm_id);
            
        }else{            
            session()->flash('error', 'Error occurred while Updating this ASM Nominee Account.');  
            return redirect()->back();   
        }
    }

    public function delete($id){
        
        $asmNominee = Asmnominee::find($id);
        //storing the asm id before deleting the nominee id.
        $id = $asmNominee->asm_id;
        //deleting the image if it is stored in Storage/app/public/images
        if($asmNominee->photo){
            Storage::delete('/public/images/'.$asmNominee->photo);
        }
        if($asmNominee->signature){
            Storage::delete('/public/images/'.$asmNominee->signature);
        }

        $asmNominee->delete();

        if(!$asmNominee){
            session()->flash('error', 'Error occurred while deleting the ASM Nominee Account.');  
            return redirect()->back();   
         }
        session()->flash('success', 'ASM Nominee Account is deleted successfully'); 
        return redirect()->route('ASMcode.nominee.index', $id);
    
    }


}
