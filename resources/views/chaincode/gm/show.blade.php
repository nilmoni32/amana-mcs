@extends('layouts.app')

@section('title')
{{ $pageTitle }} 
@endsection

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-tags"></i>&nbsp;{{ $pageTitle }}</h1>  
        <p>{{ $subTitle }}</p>    
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{ route('GMcode.index') }}">{{ __('GM List') }}</a></li>
    </ul>          
</div>
@include('partials.flash')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="tile"> 
            <div class="row profile-show-container">                
                <div class="col-md-3">
                    @if($gm->photo)
                    <img src="{{ asset('/storage/images/'. $gm->photo)}}"  class="profile-img">                                   
                    @else                                
                    <img src="https://via.placeholder.com/500X300?text=Photo" width="350" height="220" class="profile-img">
                    @endif
                </div>                    
                <div class="col-md-9 d-flex align-items-center justify-content-center">
                    <h3 class="tile-title text-center text-uppercase">{{__('GM Account Details')}}</h3>
                </div>
            </div>
            <hr>
            <div class="tile-body">
                <fieldset class="border p-2 mb-4">
                    <legend class="w-auto h5">{{ __('Personal Details') }}</legend>
                    <table class="table table-hover table-bordered">
                        <tbody>
                            <tr>
                                <td class="text-left h6">{{ __('Appointment Date') }}</td>
                                <td class="text-left">{{  date('d-m-Y', strtotime($gm->appointment_date )) }}</td>
                                
                            </tr>                        
                            <tr>
                                <td class="text-left h6">{{ __('GM Code') }}</td>
                                <td class="text-left">{{ $gm->gm_code }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Full Name') }}</td>
                                <td class="text-left">{{ $gm->name }}</td>
                            </tr>
                            @if($gm->father_name)
                            <tr>
                                <td class="text-left h6">{{ __('Father\'s Name') }}</td>
                                <td class="text-left">{{ $gm->father_name }}</td>
                            </tr>
                            @endif
                            @if($gm->husband_name)
                            <tr>
                                <td class="text-left h6">{{ __('Husband\'s Name') }}</td>
                                <td class="text-left">{{ $gm->husband_name }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-left h6">{{ __('Mother\'s Name') }}</td>
                                <td class="text-left">{{ $gm->mother_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Date of Birth') }}</td>
                                <td class="text-left">{{  date('d-m-Y', strtotime($gm->date_of_birth )) }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('Phone Number') }}</td>
                                <td class='text-left'>{{ $gm->contact_no }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('NID No') }}</td>
                                <td class='text-left'>{{ $gm->nid }}</td>
                            </tr>
                            @if($gm->email)
                            <tr>
                                <td class='text-left h6'>{{ __('Email') }}</td>
                                <td class='text-left'>{{ $gm->email }}</td>
                            </tr>
                            @endif
                            @if($gm->present_address == $gm->permanent_address)
                            <tr>
                                <td class='text-left h6'>{{ __('Present Address') }}</td>                            
                                <td class='text-left'>{{ $gm->present_address }}</td>
                            </tr>
                            @else
                            <tr>
                                <td class='text-left h6'>{{ __('Present Address') }}</td>                            
                                <td class='text-left'>{{ $gm->present_address }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('Permanent Address') }}</td>                            
                                <td class='text-left'>{{ $gm->permanent_address }}</td>
                            </tr>                        
                            @endif
                            @if($gm->signature)
                            <tr>
                                <td class='text-left h6'>{{ __('Signature') }}</td>
                                <td class='text-left'>
                                    <img src='{{ asset('/storage/images/'. $gm->signature) }}' width='150'>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-left h6">{{ __('Branch Code') }}</td>
                                <td class="text-left">{{ $gm->branch_code }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Branch Name') }}</td>
                                <td class="text-left">{{ $gm->branch_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Requirement Type') }}</td>
                                <td class="text-left">{{ $gm->requirement_type }}</td>
                            </tr>
                            @if($gm->mr_no)
                            <tr>
                                <td class='text-left h6'>{{ __('MR No') }}</td>
                                <td class="text-left">{{ $gm->mr_no }}</td>
                            </tr>
                            @endif
                            @if($gm->mr_amount)
                            <tr>
                                <td class='text-left h6'>{{ __('MR Amount') }}</td>
                                <td class="text-left">{{ $gm->mr_amount }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </fieldset>
                             
                <div class="mb-5">
                    <a href="{{ route('GMcode.index') }}" class="btn btn-primary pull-right">{{ __('Go Back') }}</a>  
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection





