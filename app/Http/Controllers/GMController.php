<?php

namespace App\Http\Controllers;


use App\Models\Gm;
use App\Models\Branch;
use App\Models\Gmnominee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class GMController extends Controller
{
    public function index(){        
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'GM [General Manager] List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);      
        return view('chaincode.gm.index');        
    }

    /*
    * Ajax Route for Datatables Ajax Pagination, Sort and Search.
    */    
    public function getgmdata(Request $request){

        $columns = array( 
            0   => 'id', 
            1   => 'appointment_date',         
            2   => 'gm_code',
            3   => 'name',             
            4   => 'contact_no',            
            5   => 'id',
        );

        $totalData = Gm::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length'); //Number of records that the table can display in the current draw
        $start = $request->input('start');  //Paging first record indicator. This is the start point in the current data set (0 index based - i.e. 0 is the first record).
        $order = $columns[$request->input('order.0.column')]; //order[0]column: Column to which ordering should be applied.
        $dir = $request->input('order.0.dir'); // order[0]dir: Ordering direction for this column. It will be asc or desc.

        if(empty($request->input('search.value'))) //search[value]:The Global search value.
        {            
        $gms = Gm::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value');
            
            $gms =  Gm::where('id','LIKE',"%{$search}%")
                    ->orWhere('appointment_date', 'LIKE',"%{$search}%")                  
                    ->orWhere('name', 'LIKE',"%{$search}%")                        
                    ->orWhere('gm_code', 'LIKE',"%{$search}%")
                    ->orWhere('contact_no', 'LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

            $totalFiltered = Gm::where('id','LIKE',"%{$search}%")
                        ->orWhere('appointment_date', 'LIKE',"%{$search}%")                        
                        ->orWhere('name', 'LIKE',"%{$search}%")                        
                        ->orWhere('gm_code', 'LIKE',"%{$search}%")
                        ->orWhere('contact_no', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if(!empty($gms))
        {
        foreach ($gms as $gm)
        {
            $show =  route('GMcode.show', $gm->id);
            $edit =  route('GMcode.edit', $gm->id);
            $del =   route('GMcode.delete', $gm->id);
            $disabled = Gmnominee::where('gm_id', $gm->id)->count() ? 'disabled' : '';

            $nestedData['id'] = $gm->id;
            $nestedData['appointment_date'] = Carbon::parse($gm->appointment_date)->format('Y-m-d');            
            $nestedData['name'] = $gm->name;            
            $nestedData['gm_code'] = $gm->gm_code;
            $nestedData['contact_no'] = $gm->contact_no;
            
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
     * Create GM
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){          
        $branches = Branch::orderBy('created_at', 'desc')->get();        
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Add GM Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);       
        return view('chaincode.gm.create', compact('branches'));  
    }


    /**
     * Store the GM Personal & Chain Code Data
     * @param Request $request  
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request){
        //dd($request->all());  

        $this->validate($request,[
            'gm_code'       => 'required|unique:gms,gm_code',               
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:gms,contact_no',
            'email'         => 'nullable|email|unique:gms,email', 
            'nid'           => 'nullable|numeric|unique:gms,nid', 
            'present_address'   => 'nullable|max:255', 
            'permanent_address' => 'nullable|max:255',
            'mr_no'         => 'nullable|max:255', 
            'mr_amount'     => 'nullable|regex:/^\d+(\.\d{1,2})?$/', 
            'branch_name'   => 'nullable|string|max:191', 
            'branch_code'   => 'nullable|numeric', 
            'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'requirement_type' => 'required|string',
        ]);

        //coverting date format from m-d-Y to Y-m-d as database stores date in 'Y-m-d' format
        $appointment_date = Carbon::createFromFormat('d-m-Y', $request->appointment_date)->format('Y-m-d');
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d');
                
        $gm = Gm::create([
            'gm_code'           => $request->gm_code,
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
            $gm->update(['photo'=> $imgPhoto, 'signature'=> $imgSignature, ]); // if image exists for that ingredient we just update it 
        } 

        
        if($gm){
            session()->flash('success', 'New GM Account is added successfully'); 
            return redirect()->route('GMcode.index');
        }else{            
            session()->flash('error', 'Error occurred while adding new GM Account.');  
            return redirect()->back();   
        }

    }

    public function show($id){
        $gm = Gm::find($id);
        view()->share(['pageTitle' => 'GM Personal Details', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.gm.show', compact('gm'));  
    }

    public function edit($id){
        $gm = Gm::find($id);
        $branches = Branch::orderBy('created_at', 'desc')->get();
        view()->share(['pageTitle' => 'Edit GM Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.gm.edit', compact('gm', 'branches'));   
    }


    public function update(Request $request){
        //dd($request->all());

        $this->validate($request,[
            'gm_code'       => 'required|unique:gms,gm_code,'. $request->id,   //append the id of the instance currently being updated to ignore the unique validator               
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:gms,contact_no,'.$request->id,
            'email'         => 'nullable|email|unique:gms,email,'.$request->id, 
            'nid'           => 'nullable|numeric|unique:gms,nid,'.$request->id,
            'present_address'   => 'nullable|max:191', 
            'permanent_address' => 'nullable|max:191',
            'mr_no'         => 'nullable|max:255', 
            'mr_amount'     => 'nullable|regex:/^\d+(\.\d{1,2})?$/', 
            'branch_name'   => 'nullable|string|max:191', 
            'branch_code'   => 'nullable|numeric', 
            'photo'         => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250', 
            'signature'     => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:250',
        ]);

        //coverting date format from m-d-Y to Y-m-d as database stroes date in 'Y-m-d' format
        $appointment_date = Carbon::createFromFormat('d-m-Y', $request->appointment_date)->format('Y-m-d');
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d'); 
        // Getting the GM record
        $gm= Gm::find($request->id);
        // updating the GM data.
        $gm->gm_code = $request->gm_code;
        $gm->appointment_date = $appointment_date;
        $gm->date_of_birth = $date_of_birth;
        $gm->name = $request->name;
        $gm->father_name = $request->father_name;
        $gm->husband_name = $request->husband_name;
        $gm->mother_name = $request->mother_name;
        $gm->contact_no = $request->contact_no;
        $gm->email = $request->email;
        $gm->nid = $request->nid;
        $gm->present_address = $request->present_address;
        $gm->permanent_address = $request->permanent_address; 
        $gm->mr_no = $request->mr_no;
        $gm->requirement_type = $request->requirement_type;
        $gm->mr_amount = $request->mr_amount;
        $gm->branch_name = $request->branch_name;
        $gm->branch_code = $request->branch_code;
        $gm->save();

        // uploading the new image for Bm   
        if($request->hasFile('photo')) {           
            $imageName = $request->photo->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($gm->photo){
                Storage::delete('/public/images/'.$gm->photo);
            }          
            $request->photo->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $gm->update(['photo'=> $imageName ]); // if image exists for that ingredient we just update it 
        }

        // uploading the new image for Bm Signature  
        if($request->hasFile('signature')) {           
            $imageName = $request->signature->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($gm->signature){
                Storage::delete('/public/images/'.$gm->signature);
            }          
            $request->signature->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $gm->update(['signature'=> $imageName ]); // if image exists for that ingredient we just update it 
        }
        if($gm){
            session()->flash('success', 'GM Account is updated successfully'); 
            return redirect()->route('GMcode.index');
        }else{            
            session()->flash('error', 'Error occurred while updating the GM Account.');  
            return redirect()->back();   
        }
        
    }


    public function delete($id){
        $gm = Gm::find($id);
        //deleting the image if it is stored in Storage/app/public/images
        if($gm->photo){
            Storage::delete('/public/images/'.$gm->photo);
        }
        if($gm->signature){
            Storage::delete('/public/images/'.$gm->signature);
        }

        $gm->delete();

        if(!$gm){
            session()->flash('error', 'Error occurred while deleting the GM Account.');  
            return redirect()->back();   
         }
        session()->flash('success', 'GM Account is deleted successfully'); 
        return redirect()->route('GMcode.index');
    
    }


}
