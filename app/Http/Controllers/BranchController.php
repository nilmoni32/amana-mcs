<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index(){        
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'Branch List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);
        $branches = Branch::orderBy('created_at', 'asc')->get();   
        return view('branch.index', compact('branches'));        
    }

    /**
     * Create Branch
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(){  
        // Attaching pagetitle and subtitle to view.
        view()->share(['pageTitle' => 'Branch List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);       
        return view('branch.create');  
    }
    
    public function store(Request $request){

        $this->validate($request,[
            'branch_code'   => 'required|numeric|unique:branches,branch_code',
            'branch_name'   => 'required|string|max:191|unique:branches,branch_name',            
            'incharge_code' => 'nullable|numeric',
            'designation'   => 'required|string',
            'incharge_name' => 'nullable|string', 
            'mobile_num'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:branches,mobile_num', 
            'phone_num'     => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:branches,phone_num',
            'address'       => 'nullable|string|max:255',   
            'list_chain_code' =>  'required|string',               
        ]);

        $new_branch= Branch::create([
            'branch_code'       => $request->branch_code,
            'branch_name'       => $request->branch_name,
            'incharge_code'     => $request->incharge_code,
            'designation'       => $request->designation,              
            'incharge_name'     => $request->incharge_name, 
            'mobile_num'        => $request->mobile_num, 
            'phone_num'         => $request->phone_num, 
            'address'           => $request->address, 
            'list_chain_code'   => $request->list_chain_code, 
        ]);
        
        if($new_branch){
            session()->flash('success', 'New Branch is added successfully'); 
            return redirect()->route('branch.index');
        }else{            
            session()->flash('error', 'Error occurred while adding new Branch.');  
            return redirect()->back();   
        }
    }

    public function edit($id){
        $branch = Branch::find($id);
        view()->share(['pageTitle' => 'Branch List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]' ]);  
        return view('branch.edit', compact('branch'));   
    }

    public function update(Request $request){

        $this->validate($request,[
            'branch_code'   => 'required|numeric|unique:branches,branch_code,'. $request->id, //append the id of the instance currently being updated to ignore the unique validator.
            'branch_name'   => 'required|string|max:191|unique:branches,branch_name,'.$request->id,   //append the id of the instance currently being updated to ignore the unique validator.         
            'incharge_code' => 'nullable|numeric',
            'designation'   => 'nullable|string',
            'incharge_name' => 'nullable|string', 
            'mobile_num'    => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:branches,mobile_num,'.$request->id, //append the id of the instance currently being updated to ignore the unique validator. 
            'phone_num'     => 'nullable|regex:/(01)[3-9]{1}(\d){8}/|max:13|unique:branches,phone_num,'.$request->id, //append the id of the instance currently being updated to ignore the unique validator.
            'address'       => 'nullable|string|max:255', 
            'list_chain_code' =>  'required|string',                 
        ]);

        $edit_branch = Branch::find($request->id); 
        $edit_branch->branch_code = $request->branch_code;       
        $edit_branch->branch_name = $request->branch_name;
        $edit_branch->incharge_code = $request->incharge_code;
        $edit_branch->designation = $request->designation;
        $edit_branch->incharge_name = $request->incharge_name;
        $edit_branch->mobile_num = $request->mobile_num;
        $edit_branch->phone_num = $request->phone_num;
        $edit_branch->address = $request->address;
        $edit_branch->list_chain_code = $request->list_chain_code;

        $edit_branch->save();

        // setting flash message     
        session()->flash('success', 'Branch is updated successfully'); 
        return redirect()->route('branch.index'); 

    }

    public function delete($id){

        $branch = Branch::find($id);        
        $branch->delete();
        if(!$branch){            
            session()->flash('error', 'Error occurred while deleting this Branch.');  
            return redirect()->back(); 
         }
        // setting flash message     
        session()->flash('success', 'Branch is deleted successfully'); 
        return redirect()->route('branch.index');     
    }


}
