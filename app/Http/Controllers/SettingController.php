<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    
    public function index(){
        // view() helper function to attach title and subtitle using share() method. 
        view()->share(['pageTitle' => 'Settings', 'subTitle' => 'AMCS - [Amana Multipurpose Co-operative System]']);
        return view('settings.index');        
    }

    /**
     * @param Request $request
     */
    public function update(Request $request){

        // Load all settings values submitted through the form 
        $keys = $request->except('_token');
        
        // Loop through all the settings keys and set the value to whatever submitted using the form.
        foreach ($keys as $key => $value)
        {
            Setting::set($key, $value);
        }  
        
        session()->flash('success', 'Settings updated successfully');          
        return redirect()->back();        
    }
}
