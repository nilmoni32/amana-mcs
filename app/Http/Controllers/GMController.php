<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GMController extends Controller
{
    public function index(){    
        
        dd('GM');
        // view() helper function to attach title and subtitle using share() method. 
        //view()->share(['pageTitle' => 'Branch List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);
       // $branches = Branch::orderBy('created_at', 'asc')->get();   
        //return view('branch.index', compact('branches'));        
    }
}