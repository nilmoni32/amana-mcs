<?php

namespace App\Http\Controllers;

use App\Models\Dgm;
use App\Models\Gm;
use App\Models\Branch;
use App\Models\Dgmnominee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class DGMController extends Controller
{
    public function index(){        
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'DGM [Deputy General Manager] List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);      
        return view('chaincode.dgm.index');        
    }

    /*
    * Ajax Route for Datatables Ajax Pagination, Sort and Search.
    */    
    public function getdgmdata(Request $request){

        $columns = array( 
            0   => 'id', 
            1   => 'appointment_date',         
            2   => 'dgm_code',
            3   => 'name',             
            4   => 'gm_code',            
            5   => 'id',
        );

        $totalData = Dgm::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length'); //Number of records that the table can display in the current draw
        $start = $request->input('start');  //Paging first record indicator. This is the start point in the current data set (0 index based - i.e. 0 is the first record).
        $order = $columns[$request->input('order.0.column')]; //order[0]column: Column to which ordering should be applied.
        $dir = $request->input('order.0.dir'); // order[0]dir: Ordering direction for this column. It will be asc or desc.

        if(empty($request->input('search.value'))) //search[value]:The Global search value.
        {            
        $dgms = Dgm::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value');
            
            $dgms =  Dgm::where('id','LIKE',"%{$search}%")
                    ->orWhere('appointment_date', 'LIKE',"%{$search}%")                  
                    ->orWhere('name', 'LIKE',"%{$search}%")                        
                    ->orWhere('dgm_code', 'LIKE',"%{$search}%")
                    ->orWhere('gm_code', 'LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

            $totalFiltered = Dgm::where('id','LIKE',"%{$search}%")
                        ->orWhere('appointment_date', 'LIKE',"%{$search}%")                        
                        ->orWhere('name', 'LIKE',"%{$search}%")                        
                        ->orWhere('dgm_code', 'LIKE',"%{$search}%")
                        ->orWhere('gm_code', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if(!empty($dgms))
        {
        foreach ($dgms as $dgm)
        {
            $show =  route('DGMcode.show', $dgm->id);
            $edit =  route('DGMcode.edit', $dgm->id);
            $del =   route('DGMcode.delete', $dgm->id);
            $disabled = Dgmnominee::where('dgm_id', $dgm->id)->count() ? 'disabled' : '';

            $nestedData['id'] = $dgm->id;
            $nestedData['appointment_date'] = Carbon::parse($dgm->appointment_date)->format('Y-m-d');            
            $nestedData['name'] = $dgm->name;            
            $nestedData['dgm_code'] = $dgm->dgm_code;
            $nestedData['gm_code'] = $dgm->gm_code;
            
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
     * Create DGM
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){          
        $branches = Branch::orderBy('created_at', 'desc')->get();
        //get general manager lists
        $gms = Gm::orderBy('created_at', 'desc')->get();
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Add DGM Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);       
        return view('chaincode.dgm.create', compact('branches','gms'));  
    }


    /**
     * Store the DGM Personal & Chain Code Data
     * @param Request $request  
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request){
        //dd($request->all());  

        $this->validate($request,[
            'dgm_code'      => 'required|unique:dgms,dgm_code',               
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:dgms,contact_no',
            'email'         => 'nullable|email|unique:dgms,email', 
            'nid'           => 'nullable|numeric|unique:dgms,nid', 
            'present_address'   => 'nullable|max:255', 
            'permanent_address' => 'nullable|max:255',          
            'gm_name'       => 'nullable|string|max:191',
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
                
        $dgm = Dgm::create([
            'dgm_code'          => $request->dgm_code,
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
            'gm_name'           => $request->gm_name,
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
            $dgm->update(['photo'=> $imgPhoto, 'signature'=> $imgSignature, ]); // if image exists for that ingredient we just update it 
        } 

        
        if($dgm){
            session()->flash('success', 'New DGM Account is added successfully'); 
            return redirect()->route('DGMcode.index');
        }else{            
            session()->flash('error', 'Error occurred while adding new DGM Account.');  
            return redirect()->back();   
        }

    }

    public function show($id){
        $dgm = Dgm::find($id);
        view()->share(['pageTitle' => 'DGM Personal Details', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.dgm.show', compact('dgm'));  
    }


    public function edit($id){
        $dgm = Dgm::find($id);
        $branches = Branch::orderBy('created_at', 'desc')->get();  
        //get general manager lists
        $gms = Gm::orderBy('created_at', 'desc')->get();

        view()->share(['pageTitle' => 'Edit DGM Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.dgm.edit', compact('dgm', 'branches', 'gms'));   
    }


    public function update(Request $request){
        //dd($request->all());

        $this->validate($request,[
            'dgm_code'      => 'required|unique:dgms,dgm_code,'. $request->id,   //append the id of the instance currently being updated to ignore the unique validator               
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:dgms,contact_no,'.$request->id,
            'email'         => 'nullable|email|unique:dgms,email,'.$request->id, 
            'nid'           => 'nullable|numeric|unique:dgms,nid,'.$request->id,
            'present_address'   => 'nullable|max:191', 
            'permanent_address' => 'nullable|max:191',
            'gm_name'       => 'nullable|string|max:191',
            'gm_code'       => 'nullable|numeric',            
            'mr_no'         => 'nullable|max:255', 
            'mr_amount'     => 'nullable|regex:/^\d+(\.\d{1,2})?$/', 
            'branch_name'   => 'nullable|string|max:191', 
            'branch_code'   => 'nullable|numeric', 
            'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'gm_code_change_notes' => 'nullable|max:191',
        ]);

        //coverting date format from m-d-Y to Y-m-d as database stroes date in 'Y-m-d' format
        $appointment_date = Carbon::createFromFormat('d-m-Y', $request->appointment_date)->format('Y-m-d');
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d'); 
        // Getting the DGM record
        $dgm= Dgm::find($request->id);
        // updating the DGM data.
        $dgm->dgm_code = $request->dgm_code;
        $dgm->appointment_date = $appointment_date;
        $dgm->date_of_birth = $date_of_birth;
        $dgm->name = $request->name;
        $dgm->father_name = $request->father_name;
        $dgm->husband_name = $request->husband_name;
        $dgm->mother_name = $request->mother_name;
        $dgm->contact_no = $request->contact_no;
        $dgm->email = $request->email;
        $dgm->nid = $request->nid;
        $dgm->present_address = $request->present_address;
        $dgm->permanent_address = $request->permanent_address;         
        $dgm->gm_name = $request->gm_name;
        $dgm->gm_code = $request->gm_code;
        $dgm->mr_no = $request->mr_no;
        $dgm->requirement_type = $request->requirement_type;
        $dgm->mr_amount = $request->mr_amount;
        $dgm->branch_name = $request->branch_name;
        $dgm->branch_code = $request->branch_code;
        $dgm->gm_code_change_notes = $request->gm_code_change_notes;  

        $dgm->save();

        // uploading the new image for Bm   
        if($request->hasFile('photo')) {           
            $imageName = $request->photo->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($dgm->photo){
                Storage::delete('/public/images/'.$dgm->photo);
            }          
            $request->photo->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $dgm->update(['photo'=> $imageName ]); // if image exists for that ingredient we just update it 
        }

        // uploading the new image for Bm Signature  
        if($request->hasFile('signature')) {           
            $imageName = $request->signature->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($dgm->signature){
                Storage::delete('/public/images/'.$dgm->signature);
            }          
            $request->signature->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $dgm->update(['signature'=> $imageName ]); // if image exists for that ingredient we just update it 
        }
        if($dgm){
            session()->flash('success', 'DGM Account is updated successfully'); 
            return redirect()->route('DGMcode.index');
        }else{            
            session()->flash('error', 'Error occurred while updating the DGM Account.');  
            return redirect()->back();   
        }

        
        
    }


    public function delete($id){
        $dgm = Dgm::find($id);
        //deleting the image if it is stored in Storage/app/public/images
        if($dgm->photo){
            Storage::delete('/public/images/'.$dgm->photo);
        }
        if($dgm->signature){
            Storage::delete('/public/images/'.$dgm->signature);
        }

        $dgm->delete();

        if(!$dgm){
            session()->flash('error', 'Error occurred while deleting the DGM Account.');  
            return redirect()->back();   
         }
        session()->flash('success', 'DGM Account is deleted successfully'); 
        return redirect()->route('DGMcode.index');
    
    }



}
