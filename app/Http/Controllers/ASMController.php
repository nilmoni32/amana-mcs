<?php

namespace App\Http\Controllers;

use App\Models\Asm;
use Illuminate\Http\Request;

class ASMController extends Controller
{
    public function index(){        
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'Area Sales Manager(ASM) List', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);
        $asms = Asm::orderBy('created_at', 'asc')->paginate(18);
        return view('chaincode.asm.index', compact('asms'));        
    }
}
