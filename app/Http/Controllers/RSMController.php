<?php

namespace App\Http\Controllers;

use App\Models\Rsm;
use Illuminate\Http\Request;

class RSMController extends Controller
{
    public function index(){        
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'Regional Sales Manager(RSM) List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);
        $rsms = Rsm::orderBy('created_at', 'asc')->paginate(18);
        return view('chaincode.rsm.index', compact('rsms'));        
    }
}
