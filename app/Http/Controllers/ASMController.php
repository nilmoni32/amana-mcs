<?php

namespace App\Http\Controllers;

use App\Models\Gm;
use App\Models\Asm;
use App\Models\Dgm;
use App\Models\Rsm;
use App\Models\Branch;
use App\Models\Asmnominee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreBmRequest;
use Illuminate\Support\Facades\Storage;

class ASMController extends Controller
{
    public function index(){        
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'ASM[Assistant Sales Manager] List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);      
        return view('chaincode.asm.index');        
    }

    /*
    * Ajax Route for Datatables Ajax Pagination, Sort and Search.
    */    
    public function getasmdata(Request $request){

        $columns = array( 
            0   => 'id', 
            1   => 'appointment_date',         
            2   => 'asm_code',
            3   => 'name',           
            4   => 'rsm_code',
            5   => 'dgm_code',
            6   => 'gm_code',            
            8   => 'id',
        );

        $totalData = Asm::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length'); //Number of records that the table can display in the current draw
        $start = $request->input('start'); // Paging first record indicator. This is the start point in the current data set (0 index based - i.e. 0 is the first record).
        $order = $columns[$request->input('order.0.column')]; //order[0]column: Column to which ordering should be applied.
        $dir = $request->input('order.0.dir'); // order[0]dir: Ordering direction for this column. It will be asc or desc.

        if(empty($request->input('search.value'))) //search[value]:The Global search value.
        {            
        $asms = Asm::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value');
            
            $asms =  Asm::where('id','LIKE',"%{$search}%")
                        ->orWhere('appointment_date', 'LIKE',"%{$search}%")
                        ->orWhere('asm_code', 'LIKE',"%{$search}%")
                        ->orWhere('name', 'LIKE',"%{$search}%")
                        ->orWhere('rsm_code', 'LIKE',"%{$search}%")
                        ->orWhere('dgm_code', 'LIKE',"%{$search}%")
                        ->orWhere('gm_code', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = Asm::where('id','LIKE',"%{$search}%")
                        ->orWhere('appointment_date', 'LIKE',"%{$search}%")
                        ->orWhere('asm_code', 'LIKE',"%{$search}%")
                        ->orWhere('name', 'LIKE',"%{$search}%")
                        ->orWhere('rsm_code', 'LIKE',"%{$search}%")
                        ->orWhere('dgm_code', 'LIKE',"%{$search}%")
                        ->orWhere('gm_code', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if(!empty($asms))
        {
        foreach ($asms as $asm)
        {
            $show =  route('ASMcode.show', $asm->id);
            $edit =  route('ASMcode.edit', $asm->id);
            $del =  route('ASMcode.delete', $asm->id);
            $disabled = Asmnominee::where('asm_id', $asm->id)->count() ? 'disabled' : '';

            $nestedData['id'] = $asm->id;
            $nestedData['appointment_date'] = Carbon::parse($asm->appointment_date)->format('Y-m-d');
            $nestedData['asm_code'] = $asm->asm_code;
            $nestedData['name'] = $asm->name;
            $nestedData['rsm_code'] = $asm->rsm_code;
            $nestedData['dgm_code'] = $asm->dgm_code;
            $nestedData['gm_code'] = $asm->gm_code;
            
            $nestedData['options'] = "<div class='text-center'>
                                        <div class='btn-group' role='group' aria-label='Second group'>
                                            <a href='{$show}' title='SHOW' class='btn btn-sm btn-primary text-light'><i class='fa fa-user mr-1'></i></a> 
                                            <a href='{$edit}' title='EDIT' class='btn btn-sm btn-warning'><i class='fa fa-edit mr-1'></i></a>
                                            <a href='{$del}' title='DELETE' class='btn btn-sm btn-danger delete-confirm {$disabled}'><i class='fa fa-trash mr-1'></i></a>
                                        </div>
                                      </div>";
            $data[] = $nestedData;

        }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),  
            "recordsTotal"    => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data"            => $data   
            );

        echo json_encode($json_data); 

    }

    /**
     * Create ASM
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){          
        $branches = Branch::orderBy('created_at', 'desc')->get();
        //get regional sales manager lists
        $rsms = Rsm::orderBy('created_at', 'desc')->get();
        //get deputy manager lists
        $dgms = Dgm::orderBy('created_at', 'desc')->get();
        //get general manager lists
        $gms = Gm::orderBy('created_at', 'desc')->get();

        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Add ASM Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);       
        return view('chaincode.asm.create', compact('branches','rsms', 'dgms','gms'));  
    }


    /**
     * Store the ASM Personal & Chain Code Data
     * @param Request $request  
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request){
        //dd($request->all());  

        $this->validate($request,[
            'asm_code'       => 'required|unique:asms,asm_code',               
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:asms,contact_no',
            'email'         => 'nullable|email|unique:asms,email', 
            'nid'           => 'nullable|numeric|unique:asms,nid', 
            'present_address'   => 'nullable|max:255', 
            'permanent_address' => 'nullable|max:255',            
            'rsm_name'      => 'nullable|string|max:191',
            'dgm_name'      => 'nullable|string|max:191', 
            'gm_name'       => 'nullable|string|max:191',           
            'rsm_code'      => 'nullable|numeric',
            'dgm_code'      => 'nullable|numeric', 
            'gm_code'       => 'nullable|numeric',            
            'mr_no'         => 'nullable|max:255', 
            'mr_amount'     => 'nullable|regex:/^\d+(\.\d{1,2})?$/', 
            'branch_name'   => 'nullable|string|max:191', 
            'branch_code'   => 'nullable|numeric', 
            'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
        ]);

        //coverting date format from m-d-Y to Y-m-d as database stores date in 'Y-m-d' format
        $appointment_date = Carbon::createFromFormat('d-m-Y', $request->appointment_date)->format('Y-m-d');
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
                
        $Asm = Asm::create([
            'asm_code'          => $request->asm_code,
            'name'              => $request->name,
            'appointment_date'  => $appointment_date,
            'father_name'       => $request->father_name, 
            'husband_name'      => $request->husband_name,
            'mother_name'       => $request->mother_name,
            'date_of_birth'     => $date_of_birth,
            'contact_no'        => $request->contact_no,
            'email'             => $request->email,
            'nid'               => $request->nid,
            'present_address'   => $request->present_address,
            'permanent_address' => $request->permanent_address,          
            'rsm_name'          => $request->rsm_name,
            'dgm_name'          => $request->dgm_name,
            'gm_name'           => $request->gm_name,           
            'rsm_code'          => $request->rsm_code,
            'dgm_code'          => $request->dgm_code,
            'gm_code'           => $request->gm_code,
            'requirement_type'  => $request->requirement_type,
            'mr_no'             => $request->mr_no,
            'mr_amount'         => $request->mr_amount,
            'branch_name'       => $request->branch_name,
            'branch_code'       => $request->branch_code,
        ]);

        // uploading image for BM opening Account   
        if($request->hasFile('photo') && $request->hasFile('signature')) {           
            $imgPhoto       = $request->photo->getClientOriginalName();  
            $imgSignature   = $request->signature->getClientOriginalName();           
            $request->photo->storeAs('images', $imgPhoto, 'public'); 
            $request->signature->storeAs('images', $imgSignature, 'public');
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $Asm->update(['photo'=> $imgPhoto, 'signature'=> $imgSignature, ]); // if image exists for that ingredient we just update it 
        } 

        
        if($Asm){
            session()->flash('success', 'New ASM Account is added successfully'); 
            return redirect()->route('ASMcode.index');
        }else{            
            session()->flash('error', 'Error occurred while adding new ASM Account.');  
            return redirect()->back();   
        }

    }

    public function show($id){
        $asm = Asm::find($id);
        view()->share(['pageTitle' => 'ASM Personal Details', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.asm.show', compact('asm'));  
    }

    public function edit($id){
        $asm = Asm::find($id);
        $branches = Branch::orderBy('created_at', 'desc')->get();        
        //get regional sales manager lists
        $rsms = Rsm::orderBy('created_at', 'desc')->get();
        //get deputy manager lists
        $dgms = Dgm::orderBy('created_at', 'desc')->get();
        //get general manager lists
        $gms = Gm::orderBy('created_at', 'desc')->get();

        view()->share(['pageTitle' => 'Edit ASM Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.asm.edit', compact('asm', 'branches', 'rsms', 'dgms', 'gms'));   
    }

    public function update(Request $request){
        //dd($request->all());

        $this->validate($request,[
            'asm_code'      => 'required|unique:asms,asm_code,'. $request->id,  //append the id of the instance currently being updated to ignore the unique validator               
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:asms,contact_no,'.$request->id,
            'email'         => 'nullable|email|unique:asms,email,'.$request->id, 
            'nid'           => 'nullable|numeric|unique:asms,nid,'.$request->id,
            'present_address'   => 'nullable|max:191', 
            'permanent_address' => 'nullable|max:191', 
            'rsm_name'      => 'nullable|string|max:191',
            'dgm_name'      => 'nullable|string|max:191', 
            'gm_name'       => 'nullable|string|max:191',            
            'rsm_code'      => 'nullable|numeric',
            'dgm_code'      => 'nullable|numeric', 
            'gm_code'       => 'nullable|numeric',            
            'mr_no'         => 'nullable|max:255', 
            'mr_amount'     => 'nullable|regex:/^\d+(\.\d{1,2})?$/', 
            'branch_name'   => 'nullable|string|max:191', 
            'branch_code'   => 'nullable|numeric', 
            'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250',             
            'rsm_code_change_notes'   => 'nullable|max:191', 
            'dgm_code_change_notes' => 'nullable|max:191',
            'gm_code_change_notes' => 'nullable|max:191',
        ]);

        //coverting date format from m-d-Y to Y-m-d as database stroes date in 'Y-m-d' format
        $appointment_date = Carbon::createFromFormat('d-m-Y', $request->appointment_date)->format('Y-m-d');
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d'); 
        // Getting the ASM record
        $asm= Asm::find($request->id);
        // updating the ASM data.
        $asm->asm_code = $request->asm_code;
        $asm->appointment_date = $appointment_date;
        $asm->date_of_birth = $date_of_birth;
        $asm->name = $request->name;
        $asm->father_name = $request->father_name;
        $asm->husband_name = $request->husband_name;
        $asm->mother_name = $request->mother_name;
        $asm->contact_no = $request->contact_no;
        $asm->email = $request->email;
        $asm->nid = $request->nid;
        $asm->present_address = $request->present_address;
        $asm->permanent_address = $request->permanent_address;       
        $asm->rsm_name = $request->rsm_name;
        $asm->dgm_name = $request->dgm_name;
        $asm->gm_name = $request->gm_name;       
        $asm->rsm_code = $request->rsm_code;
        $asm->dgm_code = $request->dgm_code;
        $asm->gm_code = $request->gm_code;
        $asm->mr_no = $request->mr_no;
        $asm->requirement_type = $request->requirement_type;
        $asm->mr_amount = $request->mr_amount;
        $asm->branch_name = $request->branch_name;
        $asm->branch_code = $request->branch_code;       
        $asm->rsm_code_change_notes = $request->rsm_code_change_notes;
        $asm->dgm_code_change_notes = $request->dgm_code_change_notes;
        $asm->gm_code_change_notes = $request->gm_code_change_notes;  

        $asm->save();

        // uploading the new image for Bm   
        if($request->hasFile('photo')) {           
            $imageName = $request->photo->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($asm->photo){
                Storage::delete('/public/images/'.$asm->photo);
            }          
            $request->photo->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $asm->update(['photo'=> $imageName ]); // if image exists for that ingredient we just update it 
        }

        // uploading the new image for Bm Signature  
        if($request->hasFile('signature')) {           
            $imageName = $request->signature->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($asm->signature){
                Storage::delete('/public/images/'.$asm->signature);
            }          
            $request->signature->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $asm->update(['signature'=> $imageName ]); // if image exists for that ingredient we just update it 
        }
        if($asm){
            session()->flash('success', 'ASM Account is updated successfully'); 
            return redirect()->route('ASMcode.index');
        }else{            
            session()->flash('error', 'Error occurred while updating the ASM Account.');  
            return redirect()->back();   
        }

        
        
    }


    public function delete($id){
        $asm = Asm::find($id);
        //deleting the image if it is stored in Storage/app/public/images
        if($asm->photo){
            Storage::delete('/public/images/'.$asm->photo);
        }
        if($asm->signature){
            Storage::delete('/public/images/'.$asm->signature);
        }

        $asm->delete();

        if(!$asm){
            session()->flash('error', 'Error occurred while deleting the ASM Account.');  
            return redirect()->back();   
         }
        session()->flash('success', 'ASM Account is deleted successfully'); 
        return redirect()->route('ASMcode.index');
    
    }
    


}
