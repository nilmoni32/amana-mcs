<?php

namespace App\Http\Controllers;

use App\Models\Bm;
use App\Models\Gm;
use App\Models\Mo;
use App\Models\Asm;
use App\Models\Dgm;
use App\Models\Rsm;
use App\Models\Branch;
use App\Models\Monominee;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Http\Requests\StoreBmRequest;
use Illuminate\Support\Facades\Storage;

class MOController extends Controller
{
     
    public function index(){        
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'MO[Marketing Officer] List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);      
        return view('chaincode.mo.index');        
    }

    /*
    * Ajax Route for Datatables Ajax Pagination, Sort and Search.
    */    
    public function getmodata(Request $request){

        $columns = array( 
            0   => 'id', 
            1   => 'appointment_date',         
            2   => 'mo_code',
            3   => 'name',           
            4   => 'bm_code',
            5   => 'asm_code',
            6   => 'rsm_code',            
            8   => 'id',
        );

        $totalData = Mo::count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length'); //Number of records that the table can display in the current draw
        $start = $request->input('start'); // Paging first record indicator. This is the start point in the current data set (0 index based - i.e. 0 is the first record).
        $order = $columns[$request->input('order.0.column')]; //order[0]column: Column to which ordering should be applied.
        $dir = $request->input('order.0.dir'); // order[0]dir: Ordering direction for this column. It will be asc or desc.

        if(empty($request->input('search.value'))) //search[value]:The Global search value.
        {            
        $mos = Mo::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
        $search = $request->input('search.value');
            
            $mos =  Mo::where('id','LIKE',"%{$search}%")
                        ->orWhere('appointment_date', 'LIKE',"%{$search}%")
                        ->orWhere('mo_code', 'LIKE',"%{$search}%")
                        ->orWhere('name', 'LIKE',"%{$search}%")
                        ->orWhere('bm_code', 'LIKE',"%{$search}%")
                        ->orWhere('asm_code', 'LIKE',"%{$search}%")
                        ->orWhere('rsm_code', 'LIKE',"%{$search}%")
                        ->offset($start)
                        ->limit($limit)
                        ->orderBy($order,$dir)
                        ->get();

            $totalFiltered = Mo::where('id','LIKE',"%{$search}%")
                        ->orWhere('appointment_date', 'LIKE',"%{$search}%")
                        ->orWhere('mo_code', 'LIKE',"%{$search}%")
                        ->orWhere('name', 'LIKE',"%{$search}%")
                        ->orWhere('bm_code', 'LIKE',"%{$search}%")
                        ->orWhere('asm_code', 'LIKE',"%{$search}%")
                        ->orWhere('rsm_code', 'LIKE',"%{$search}%")
                        ->count();
        }

        $data = array();
        if(!empty($mos))
        {
        foreach ($mos as $mo)
        {
            $show =  route('MOcode.show', $mo->id);
            $edit =  route('MOcode.edit', $mo->id);
            $del =  route('MOcode.delete', $mo->id);
            $disabled = Monominee::where('mo_id', $mo->id)->count() ? 'disabled' : '';

            $nestedData['id'] = $mo->id;
            $nestedData['appointment_date'] = Carbon::parse($mo->appointment_date)->format('Y-m-d');
            $nestedData['mo_code'] = $mo->mo_code;
            $nestedData['name'] = $mo->name;
            $nestedData['bm_code'] = $mo->bm_code;
            $nestedData['asm_code'] = $mo->asm_code;
            $nestedData['rsm_code'] = $mo->rsm_code;
            
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
        //get Branch Manager lists
        $bms = Bm::orderBy('created_at', 'desc')->get();
        //get area sales manager lists
        $asms = Asm::orderBy('created_at', 'desc')->get();
        //get regional sales manager lists
        $rsms = Rsm::orderBy('created_at', 'desc')->get();
        //get deputy manager lists
        $dgms = Dgm::orderBy('created_at', 'desc')->get();
        //get general manager lists
        $gms = Gm::orderBy('created_at', 'desc')->get();

        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Add MO Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);       
        return view('chaincode.mo.create', compact('branches','bms', 'asms', 'rsms', 'dgms','gms'));  
    }


    /**
     * Store the MO Personal & Chain Code Data
     * @param Request $request  
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request){
        //dd($request->all());  

        $this->validate($request,[
            'mo_code'       => 'required|unique:mos,mo_code',               
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:mos,contact_no',
            'email'         => 'nullable|email|unique:mos,email', 
            'nid'           => 'nullable|numeric|unique:mos,nid', 
            'present_address'   => 'nullable|max:255', 
            'permanent_address' => 'nullable|max:255', 
            'bm_name'       => 'nullable|string|max:191',
            'asm_name'      => 'nullable|string|max:191', 
            'rsm_name'      => 'nullable|string|max:191',
            'dgm_name'      => 'nullable|string|max:191', 
            'gm_name'       => 'nullable|string|max:191',
            'bm_code'       => 'nullable|numeric',  
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
                
        $Mo = Mo::create([
            'mo_code'           => $request->mo_code,
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
            'bm_name'           => $request->bm_name,
            'asm_name'          => $request->asm_name,
            'rsm_name'          => $request->rsm_name,
            'dgm_name'          => $request->dgm_name,
            'gm_name'           => $request->gm_name,
            'bm_code'           => $request->bm_code,
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
            $Mo->update(['photo'=> $imgPhoto, 'signature'=> $imgSignature, ]); // if image exists for that ingredient we just update it 
        } 

        
        if($Mo){
            session()->flash('success', 'New Mo Account is added successfully'); 
            return redirect()->route('MOcode.index');
        }else{            
            session()->flash('error', 'Error occurred while adding new MO Account.');  
            return redirect()->back();   
        }

    }

    public function show($id){
        $mo = Mo::find($id);
        view()->share(['pageTitle' => 'MO Personal Details', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.mo.show', compact('mo'));  
    }

    public function edit($id){        
        $mo = Mo::find($id);
        $branches = Branch::orderBy('created_at', 'desc')->get();
        //get Branch Manager lists
        $bms = Bm::orderBy('created_at', 'desc')->get();
        //get area sales manager lists
        $asms = Asm::orderBy('created_at', 'desc')->get();        
        //get regional sales manager lists
        $rsms = Rsm::orderBy('created_at', 'desc')->get();        
        //get deputy manager lists
        $dgms = Dgm::orderBy('created_at', 'desc')->get();
        //get general manager lists
        $gms = Gm::orderBy('created_at', 'desc')->get();

        view()->share(['pageTitle' => 'Edit MO Account', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('chaincode.mo.edit', compact('mo', 'branches', 'bms','asms', 'rsms', 'dgms', 'gms'));   
    }


    public function update(Request $request){
        //dd($request->all());

        $this->validate($request,[
            'mo_code'       => 'required|unique:mos,mo_code,'. $request->id,  //append the id of the instance currently being updated to ignore the unique validator               
            'name'          => 'required|string|max:191',
            'father_name'   => 'nullable|string|max:191',
            'husband_name'  => 'nullable|string|max:191', 
            'mother_name'   => 'nullable|string|max:191',
            'contact_no'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:mos,contact_no,'.$request->id,
            'email'         => 'nullable|email|unique:mos,email,'.$request->id, 
            'nid'           => 'nullable|numeric|unique:mos,nid,'.$request->id,
            'present_address'   => 'nullable|max:191', 
            'permanent_address' => 'nullable|max:191', 
            'bm_name'       => 'nullable|string|max:191',
            'asm_name'      => 'nullable|string|max:191', 
            'rsm_name'      => 'nullable|string|max:191',
            'dgm_name'      => 'nullable|string|max:191', 
            'gm_name'       => 'nullable|string|max:191',
            'bm_code'       => 'nullable|numeric',  
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
            'bm_code_change_notes'   => 'nullable|max:191', 
            'asm_code_change_notes' => 'nullable|max:191',
            'rsm_code_change_notes'   => 'nullable|max:191', 
            'dgm_code_change_notes' => 'nullable|max:191',
            'gm_code_change_notes' => 'nullable|max:191',
        ]);

        //coverting date format from m-d-Y to Y-m-d as database stroes date in 'Y-m-d' format
        $appointment_date = Carbon::createFromFormat('d-m-Y', $request->appointment_date)->format('Y-m-d');
        $date_of_birth = Carbon::createFromFormat('d-m-Y', $request->date_of_birth)->format('Y-m-d'); 
        // Getting the Bm record
        $mo= Mo::find($request->id);
        // updating the Bm data.
        $mo->mo_code = $request->mo_code;
        $mo->appointment_date = $appointment_date;
        $mo->date_of_birth = $date_of_birth;
        $mo->name = $request->name;
        $mo->father_name = $request->father_name;
        $mo->husband_name = $request->husband_name;
        $mo->mother_name = $request->mother_name;
        $mo->contact_no = $request->contact_no;
        $mo->email = $request->email;
        $mo->nid = $request->nid;
        $mo->present_address = $request->present_address;
        $mo->permanent_address = $request->permanent_address;
        $mo->bm_name = $request->bm_name;
        $mo->asm_name = $request->asm_name;
        $mo->rsm_name = $request->rsm_name;
        $mo->dgm_name = $request->dgm_name;
        $mo->gm_name = $request->gm_name;
        $mo->bm_code = $request->bm_code;
        $mo->asm_code = $request->asm_code;
        $mo->rsm_code = $request->rsm_code;
        $mo->dgm_code = $request->dgm_code;
        $mo->gm_code = $request->gm_code;
        $mo->mr_no = $request->mr_no;
        $mo->requirement_type = $request->requirement_type;
        $mo->mr_amount = $request->mr_amount;
        $mo->branch_name = $request->branch_name;
        $mo->branch_code = $request->branch_code;
        $mo->bm_code_change_notes = $request->bm_code_change_notes;
        $mo->asm_code_change_notes = $request->asm_code_change_notes;
        $mo->rsm_code_change_notes = $request->rsm_code_change_notes;
        $mo->dgm_code_change_notes = $request->dgm_code_change_notes;
        $mo->gm_code_change_notes = $request->gm_code_change_notes;  

        $mo->save();

        // uploading the new image for Bm   
        if($request->hasFile('photo')) {           
            $imageName = $request->photo->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($mo->photo){
                Storage::delete('/public/images/'.$mo->photo);
            }          
            $request->photo->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $mo->update(['photo'=> $imageName ]); // if image exists for that ingredient we just update it 
        }

        // uploading the new image for Bm Signature  
        if($request->hasFile('signature')) {           
            $imageName = $request->signature->getClientOriginalName();   
            //deleting the image if it is stored in Storage/app/public/images
            if($mo->signature){
                Storage::delete('/public/images/'.$mo->signature);
            }          
            $request->signature->storeAs('images', $imageName, 'public'); 
            // store image at storage/app/public/images. 
            // we need to create symbolic link to access public/storage/images/ : php artisan storage:link
            $mo->update(['signature'=> $imageName ]); // if image exists for that ingredient we just update it 
        }
        if($mo){
            session()->flash('success', 'MO Account is updated successfully'); 
            return redirect()->route('MOcode.index');
        }else{            
            session()->flash('error', 'Error occurred while updating the MO Account.');  
            return redirect()->back();   
        }

        
        
    }


    public function delete($id){
        $mo = Mo::find($id);
        //deleting the image if it is stored in Storage/app/public/images
        if($mo->photo){
            Storage::delete('/public/images/'.$mo->photo);
        }
        if($mo->signature){
            Storage::delete('/public/images/'.$mo->signature);
        }

        $mo->delete();

        if(!$mo){
            session()->flash('error', 'Error occurred while deleting the MO Account.');  
            return redirect()->back();   
         }
        session()->flash('success', 'MO Account is deleted successfully'); 
        return redirect()->route('MOcode.index');
    
    }

       
}
