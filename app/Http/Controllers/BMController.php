<?php

namespace App\Http\Controllers;


use App\Models\Bm;
use App\Models\Gm;
use App\Models\Asm;
use App\Models\Dgm;
use App\Models\Rsm;
use App\Models\Branch;
use App\Models\Bmnominee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreBmRequest;
use Illuminate\Support\Facades\Storage;

class BMController extends Controller
{
    
    public function index(){        
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'Branch Manager(BM) List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);      
        return view('chaincode.bm.index');        
    }

    /*
    * Ajax Route for Datatables Ajax Pagination, Sort and Search.
    */    
    public function getbmdata(Request $request){

        $columns = array( 
            0 => 'id', 
            1 => 'appointment_date',         
            2 => 'bm_code',
            3 => 'name',           
            4=> 'asm_code',
            5=> 'rsm_code',
            6=> 'agm_code',            
            8=> 'id',
        );

        $totalData = Bm::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length'); //Number of records that the table can display in the current draw
        $start = $request->input('start'); // Paging first record indicator. This is the start point in the current data set (0 index based - i.e. 0 is the first record).
        $order = $columns[$request->input('order.0.column')]; //order[0]column: Column to which ordering should be applied.
        $dir = $request->input('order.0.dir'); // order[0]dir: Ordering direction for this column. It will be asc or desc.

        if(empty($request->input('search.value'))) //search[value]:The Global search value.
        {            
        $bms = Bm::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value');
            
            $bms =  Bm::where('id','LIKE',"%{$search}%")
                        ->orWhere('appointment_date', 'LIKE',"%{$search}%")
                        ->orWhere('bm_code', 'LIKE',"%{$search}%")
                        ->orWhere('name', 'LIKE',"%{$search}%")
                        ->orWhere('asm_code', 'LIKE',"%{$search}%")
                        ->orWhere('rsm_code', 'LIKE',"%{$search}%")
                        ->orWhere('agm_code', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = Bm::where('id','LIKE',"%{$search}%")
                        ->orWhere('appointment_date', 'LIKE',"%{$search}%")
                        ->orWhere('bm_code', 'LIKE',"%{$search}%")
                        ->orWhere('name', 'LIKE',"%{$search}%")
                        ->orWhere('asm_code', 'LIKE',"%{$search}%")
                        ->orWhere('rsm_code', 'LIKE',"%{$search}%")
                        ->orWhere('agm_code', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if(!empty($bms))
        {
        foreach ($bms as $bm)
        {
            $show =  route('BMcode.show', $bm->id);
            $edit =  route('BMcode.edit', $bm->id);
            $del =  route('BMcode.delete', $bm->id);
            $disabled = Bmnominee::where('bm_id', $bm->id)->count() ? 'disabled' : '';

            $nestedData['id'] = $bm->id;
            $nestedData['appointment_date'] = Carbon::parse($bm->appointment_date)->format('Y-m-d');
            $nestedData['bm_code'] = $bm->bm_code;
            $nestedData['name'] = $bm->name;
            $nestedData['asm_code'] = $bm->asm_code;
            $nestedData['rsm_code'] = $bm->rsm_code;
            $nestedData['agm_code'] = $bm->agm_code;
            
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
     * Create Branch Manager [BM]
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){          
        $branches = Branch::orderBy('created_at', 'desc')->get();
        //get area sales manager lists
        $asms = Asm::orderBy('created_at', 'desc')->get();
        //get regional sales manager lists
        $rsms = Rsm::orderBy('created_at', 'desc')->get();
        //get deputy manager lists
        $dgms = Dgm::orderBy('created_at', 'desc')->get();
        //get general manager lists
        $gms = Gm::orderBy('created_at', 'desc')->get();

        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Add BM Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);       
        return view('chaincode.bm.create', compact('branches', 'asms', 'rsms', 'dgms','gms'));  
    }

    /**
     * Store the BM Personal & Chain Code Data
     * @param Request $request  
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request){
        //dd($request->all());  

        $this->validate($request,[
            'bm_code'       => 'required|unique:bms,bm_code',               
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:bms,contact_no',
            'email'         => 'nullable|email|unique:bms,email', 
            'nid'           => 'nullable|numeric|unique:bms,nid', 
            'present_address'   => 'nullable|max:255', 
            'permanent_address' => 'nullable|max:255', 
            'asm_name'      => 'nullable|string|max:191', 
            'rsm_name'      => 'nullable|string|max:191',
            'dgm_name'      => 'nullable|string|max:191', 
            'gm_name'       => 'nullable|string|max:191', 
            'asm_code'      => 'nullable|numeric', 
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
                
        $Bm = Bm::create([
            'bm_code'           => $request->bm_code,
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
            'asm_name'          => $request->asm_name,
            'rsm_name'          => $request->rsm_name,
            'dgm_name'          => $request->dgm_name,
            'gm_name'           => $request->gm_name,
            'asm_code'          => $request->asm_code,
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
            $Bm->update(['photo'=> $imgPhoto, 'signature'=> $imgSignature, ]); // if image exists for that ingredient we just update it 
        } 

        
        if($Bm){
            session()->flash('success', 'New BM Account is added successfully'); 
            return redirect()->route('BMcode.index');
        }else{            
            session()->flash('error', 'Error occurred while adding new BM Account.');  
            return redirect()->back();   
        }

    }

    public function show($id){
        $bm = Bm::find($id);
        view()->share(['pageTitle' => 'BM Personal Details', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.bm.show', compact('bm'));  
    }

    public function edit($id){
        $bm = Bm::find($id);
        $branches = Branch::orderBy('created_at', 'desc')->get();
        //get area sales manager lists
        $asms = Asm::orderBy('created_at', 'desc')->get();
        //get regional sales manager lists
        $rsms = Rsm::orderBy('created_at', 'desc')->get();
        //get deputy manager lists
        $dgms = Dgm::orderBy('created_at', 'desc')->get();
        //get general manager lists
        $gms = Gm::orderBy('created_at', 'desc')->get();
        view()->share(['pageTitle' => 'Edit BM Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.bm.edit', compact('bm', 'branches','asms', 'rsms', 'dgms', 'gms'));   
    }

    public function update(Request $request){
        //dd($request->all());

        $validated = $request->validate([
            'bm_code'       => 'required|numeric|unique:bms,bm_code,'. $request->id,  //append the id of the instance currently being updated to ignore the unique validator             
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:bms,contact_no,'.$request->id, //append the id of the instance currently being updated to ignore the unique validator
            'email'         => 'nullable|email|unique:bms,email,'. $request->id, //append the id of the instance currently being updated to ignore the unique validator
            'nid'           => 'nullable|numeric|unique:bms,nid,'. $request->id, //append the id of the instance currently being updated to ignore the unique validator
            'present_address'   => 'nullable|max:255', 
            'permanent_address' => 'nullable|max:255', 
            'asm_name'      => 'nullable|string|max:191', 
            'rsm_name'      => 'nullable|string|max:191',
            'dgm_name'      => 'nullable|string|max:191', 
            'gm_name'       => 'nullable|string|max:191', 
            'asm_code'      => 'nullable|numeric', 
            'rsm_code'      => 'nullable|numeric',
            'dgm_code'      => 'nullable|numeric', 
            'gm_code'       => 'nullable|numeric',            
            'mr_no'         => 'nullable|max:255', 
            'mr_amount'     => 'nullable|regex:/^\d+(\.\d{1,2})?$/', 
            'branch_name'   => 'nullable|string|max:191', 
            'branch_code'   => 'nullable|numeric', 
            'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250',
            'asm_code_change_notes' => 'nullable|max:191',
            'rsm_code_change_notes'   => 'nullable|max:191', 
            'dgm_code_change_notes' => 'nullable|max:191',
            'gm_code_change_notes' => 'nullable|max:191',
        ]);        
        //coverting date format from m-d-Y to Y-m-d as database stroes date in 'Y-m-d' format
        $appointment_date = Carbon::createFromFormat('d-m-Y', $request->appointment_date)->format('Y-m-d');
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d'); 
        // Getting the Bm record
        $Bm= Bm::find($request->id);
        // updating the Bm data.
        $Bm->bm_code = $request->bm_code;
        $Bm->appointment_date = $appointment_date;
        $Bm->name =  $request->name;  
        $Bm->father_name =  $request->father_name;
        $Bm->husband_name =  $request->husband_name;
        $Bm->mother_name = $request->mother_name;
        $Bm->date_of_birth = $date_of_birth;
        $Bm->contact_no = $request->contact_no;
        $Bm->email = $request->email;
        $Bm->nid = $request->nid;
        $Bm->present_address = $request->present_address;
        $Bm->permanent_address = $request->permanent_address;
        $Bm->asm_name = $request->asm_name;
        $Bm->asm_code = $request->asm_code;
        $Bm->rsm_name = $request->rsm_name;
        $Bm->rsm_code = $request->rsm_code;
        $Bm->dgm_name = $request->dgm_name;
        $Bm->dgm_code = $request->dgm_code;
        $Bm->gm_name = $request->gm_name;
        $Bm->gm_code = $request->gm_code;
        $Bm->requirement_type = $request->requirement_type;
        $Bm->mr_no = $request->mr_no;
        $Bm->mr_amount = $request->mr_amount;
        $Bm->branch_name = $request->branch_name;
        $Bm->branch_code = $request->branch_code;
        $Bm->asm_code_change_notes = $request->asm_code_change_notes;
        $Bm->rsm_code_change_notes = $request->rsm_code_change_notes;
        $Bm->dgm_code_change_notes = $request->dgm_code_change_notes;
        $Bm->gm_code_change_notes = $request->gm_code_change_notes;
        
        $Bm->save();

        // uploading the new image for Bm   
        if($request->hasFile('photo')) {           
            $imageName = $request->photo->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($Bm->photo){
                Storage::delete('/public/images/'.$Bm->photo);
            }          
            $request->photo->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $Bm->update(['photo'=> $imageName ]); // if image exists for that ingredient we just update it 
        }

        // uploading the new image for Bm Signature  
        if($request->hasFile('signature')) {           
            $imageName = $request->signature->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($Bm->signature){
                Storage::delete('/public/images/'.$Bm->signature);
            }          
            $request->signature->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $Bm->update(['signature'=> $imageName ]); // if image exists for that ingredient we just update it 
        }
        if($Bm){
            session()->flash('success', 'BM Account is updated successfully'); 
            return redirect()->route('BMcode.index');
        }else{            
            session()->flash('error', 'Error occurred while updating the BM Account.');  
            return redirect()->back();   
        }

        
        
    }

    public function delete($id){
        $Bm = Bm::find($id);
        //deleting the image if it is stored in Storage/app/public/images
        if($Bm->photo){
            Storage::delete('/public/images/'.$Bm->photo);
        }
        if($Bm->signature){
            Storage::delete('/public/images/'.$Bm->signature);
        }

        $Bm->delete();

        if(!$Bm){
            session()->flash('error', 'Error occurred while deleting the BM Account.');  
            return redirect()->back();   
         }
        session()->flash('success', 'BM Account is deleted successfully'); 
        return redirect()->route('BMcode.index');
    
    }
          
    
}
