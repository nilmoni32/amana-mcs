<?php

namespace App\Http\Controllers;


use App\Models\Rsm;
use App\Models\Dgm;
use App\Models\Gm;
use App\Models\Branch;
use App\Models\Rsmnominee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreBmRequest;
use Illuminate\Support\Facades\Storage;

class RSMController extends Controller
{
    public function index(){        
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'RSM [Regional Sales Manager] List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);      
        return view('chaincode.rsm.index');        
    }

    /*
    * Ajax Route for Datatables Ajax Pagination, Sort and Search.
    */    
    public function getrsmdata(Request $request){

        $columns = array( 
            0   => 'id', 
            1   => 'appointment_date',         
            2   => 'rsm_code',
            3   => 'name', 
            4   => 'dgm_code',
            5   => 'gm_code',            
            6   => 'id',
        );

        $totalData = Rsm::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length'); //Number of records that the table can display in the current draw
        $start = $request->input('start');  //Paging first record indicator. This is the start point in the current data set (0 index based - i.e. 0 is the first record).
        $order = $columns[$request->input('order.0.column')]; //order[0]column: Column to which ordering should be applied.
        $dir = $request->input('order.0.dir'); // order[0]dir: Ordering direction for this column. It will be asc or desc.

        if(empty($request->input('search.value'))) //search[value]:The Global search value.
        {            
        $rsms = Rsm::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value');
            
            $rsms =  Rsm::where('id','LIKE',"%{$search}%")
                    ->orWhere('appointment_date', 'LIKE',"%{$search}%")
                    ->orWhere('rsm_code', 'LIKE',"%{$search}%")
                    ->orWhere('name', 'LIKE',"%{$search}%")                        
                    ->orWhere('dgm_code', 'LIKE',"%{$search}%")
                    ->orWhere('gm_code', 'LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

            $totalFiltered = Rsm::where('id','LIKE',"%{$search}%")
                        ->orWhere('appointment_date', 'LIKE',"%{$search}%")
                        ->orWhere('rsm_code', 'LIKE',"%{$search}%")
                        ->orWhere('name', 'LIKE',"%{$search}%")                        
                        ->orWhere('dgm_code', 'LIKE',"%{$search}%")
                        ->orWhere('gm_code', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if(!empty($rsms))
        {
        foreach ($rsms as $rsm)
        {
            $show =  route('RSMcode.show', $rsm->id);
            $edit =  route('RSMcode.edit', $rsm->id);
            $del =  route('RSMcode.delete', $rsm->id);
            $disabled = Rsmnominee::where('rsm_id', $rsm->id)->count() ? 'disabled' : '';

            $nestedData['id'] = $rsm->id;
            $nestedData['appointment_date'] = Carbon::parse($rsm->appointment_date)->format('Y-m-d');
            $nestedData['rsm_code'] = $rsm->rsm_code;
            $nestedData['name'] = $rsm->name;            
            $nestedData['dgm_code'] = $rsm->dgm_code;
            $nestedData['gm_code'] = $rsm->gm_code;
            
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
     * Create RSM
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){          
        $branches = Branch::orderBy('created_at', 'desc')->get();
        //get deputy manager lists
        $dgms = Dgm::orderBy('created_at', 'desc')->get();
        //get general manager lists
        $gms = Gm::orderBy('created_at', 'desc')->get();
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Add RSM Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);       
        return view('chaincode.rsm.create', compact('branches', 'dgms','gms'));  
    }


    /**
     * Store the RSM Personal & Chain Code Data
     * @param Request $request  
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request){
        //dd($request->all());  

        $this->validate($request,[
            'rsm_code'      => 'required|unique:rsms,rsm_code',               
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:rsms,contact_no',
            'email'         => 'nullable|email|unique:rsms,email', 
            'nid'           => 'nullable|numeric|unique:rsms,nid', 
            'present_address'   => 'nullable|max:255', 
            'permanent_address' => 'nullable|max:255',
            'dgm_name'      => 'nullable|string|max:191', 
            'gm_name'       => 'nullable|string|max:191',
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
                
        $rsm = Rsm::create([
            'rsm_code'          => $request->rsm_code,
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
            'dgm_name'          => $request->dgm_name,
            'gm_name'           => $request->gm_name,
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
            $rsm->update(['photo'=> $imgPhoto, 'signature'=> $imgSignature, ]); // if image exists for that ingredient we just update it 
        } 

        
        if($rsm){
            session()->flash('success', 'New RSM Account is added successfully'); 
            return redirect()->route('RSMcode.index');
        }else{            
            session()->flash('error', 'Error occurred while adding new RSM Account.');  
            return redirect()->back();   
        }

    }

    public function show($id){
        $rsm = Rsm::find($id);
        view()->share(['pageTitle' => 'RSM Personal Details', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.rsm.show', compact('rsm'));  
    }

    public function edit($id){
        $rsm = Rsm::find($id);
        $branches = Branch::orderBy('created_at', 'desc')->get();  
        //get deputy manager lists
        $dgms = Dgm::orderBy('created_at', 'desc')->get();
        //get general manager lists
        $gms = Gm::orderBy('created_at', 'desc')->get();

        view()->share(['pageTitle' => 'Edit RSM Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.rsm.edit', compact('rsm', 'branches', 'dgms', 'gms'));   
    }


    public function update(Request $request){
        //dd($request->all());

        $this->validate($request,[
            'rsm_code'      => 'required|unique:rsms,rsm_code,'. $request->id,  //append the id of the instance currently being updated to ignore the unique validator               
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:rsms,contact_no,'.$request->id,
            'email'         => 'nullable|email|unique:rsms,email,'.$request->id, 
            'nid'           => 'nullable|numeric|unique:rsms,nid,'.$request->id,
            'present_address'   => 'nullable|max:191', 
            'permanent_address' => 'nullable|max:191',
            'dgm_name'      => 'nullable|string|max:191', 
            'gm_name'       => 'nullable|string|max:191',
            'dgm_code'      => 'nullable|numeric', 
            'gm_code'       => 'nullable|numeric',            
            'mr_no'         => 'nullable|max:255', 
            'mr_amount'     => 'nullable|regex:/^\d+(\.\d{1,2})?$/', 
            'branch_name'   => 'nullable|string|max:191', 
            'branch_code'   => 'nullable|numeric', 
            'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250',  
            'dgm_code_change_notes' => 'nullable|max:191',
            'gm_code_change_notes' => 'nullable|max:191',
        ]);

        //coverting date format from m-d-Y to Y-m-d as database stroes date in 'Y-m-d' format
        $appointment_date = Carbon::createFromFormat('d-m-Y', $request->appointment_date)->format('Y-m-d');
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d'); 
        // Getting the ASM record
        $rsm= Rsm::find($request->id);
        // updating the ASM data.
        $rsm->rsm_code = $request->rsm_code;
        $rsm->appointment_date = $appointment_date;
        $rsm->date_of_birth = $date_of_birth;
        $rsm->name = $request->name;
        $rsm->father_name = $request->father_name;
        $rsm->husband_name = $request->husband_name;
        $rsm->mother_name = $request->mother_name;
        $rsm->contact_no = $request->contact_no;
        $rsm->email = $request->email;
        $rsm->nid = $request->nid;
        $rsm->present_address = $request->present_address;
        $rsm->permanent_address = $request->permanent_address; 
        $rsm->dgm_name = $request->dgm_name;
        $rsm->gm_name = $request->gm_name; 
        $rsm->dgm_code = $request->dgm_code;
        $rsm->gm_code = $request->gm_code;
        $rsm->mr_no = $request->mr_no;
        $rsm->requirement_type = $request->requirement_type;
        $rsm->mr_amount = $request->mr_amount;
        $rsm->branch_name = $request->branch_name;
        $rsm->branch_code = $request->branch_code;
        $rsm->dgm_code_change_notes = $request->dgm_code_change_notes;
        $rsm->gm_code_change_notes = $request->gm_code_change_notes;  

        $rsm->save();

        // uploading the new image for Bm   
        if($request->hasFile('photo')) {           
            $imageName = $request->photo->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($rsm->photo){
                Storage::delete('/public/images/'.$rsm->photo);
            }          
            $request->photo->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $rsm->update(['photo'=> $imageName ]); // if image exists for that ingredient we just update it 
        }

        // uploading the new image for Bm Signature  
        if($request->hasFile('signature')) {           
            $imageName = $request->signature->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($rsm->signature){
                Storage::delete('/public/images/'.$rsm->signature);
            }          
            $request->signature->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $rsm->update(['signature'=> $imageName ]); // if image exists for that ingredient we just update it 
        }
        if($rsm){
            session()->flash('success', 'RSM Account is updated successfully'); 
            return redirect()->route('RSMcode.index');
        }else{            
            session()->flash('error', 'Error occurred while updating the RSM Account.');  
            return redirect()->back();   
        }

        
        
    }

    public function delete($id){
        $rsm = Rsm::find($id);
        //deleting the image if it is stored in Storage/app/public/images
        if($rsm->photo){
            Storage::delete('/public/images/'.$rsm->photo);
        }
        if($rsm->signature){
            Storage::delete('/public/images/'.$rsm->signature);
        }

        $rsm->delete();

        if(!$rsm){
            session()->flash('error', 'Error occurred while deleting the ASM Account.');  
            return redirect()->back();   
         }
        session()->flash('success', 'ASM Account is deleted successfully'); 
        return redirect()->route('ASMcode.index');
    
    }


}
