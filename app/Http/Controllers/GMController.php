<?php

namespace App\Http\Controllers;

use App\Models\Gm;
use Illuminate\Http\Request;

class GMController extends Controller
{
    public function index(){        
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'General Manager(GM) List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);
        $gms = Gm::orderBy('created_at', 'asc')->paginate(18);
        return view('chaincode.gm.index', compact('gms'));        
    }
}
