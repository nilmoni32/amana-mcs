<?php

namespace App\Http\Controllers;

use App\Models\Dgm;
use Illuminate\Http\Request;

class DGMController extends Controller
{
    public function index(){        
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'Deputy General Manager(DGM) List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);
        $dgms = Dgm::orderBy('created_at', 'asc')->paginate(18);
        return view('chaincode.dgm.index', compact('dgms'));        
    }
}
