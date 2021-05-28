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
        <li class="breadcrumb-item"><a href="{{ route('RSMcode.index') }}">{{ __('RSM List') }}</a></li>
    </ul>          
</div>
@include('partials.flash')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="tile"> 
            <div class="row profile-show-container">                
                <div class="col-md-3">
                    @if($rsm->photo)
                    <img src="{{ asset('/storage/images/'. $rsm->photo)}}"  class="profile-img">                                   
                    @else                                
                    <img src="https://via.placeholder.com/500X300?text=Photo" width="350" height="220" class="profile-img">
                    @endif
                </div>                    
                <div class="col-md-9 d-flex align-items-center justify-content-center">
                    <h3 class="tile-title text-center text-uppercase">{{__('RSM Account Details')}}</h3>
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
                                <td class="text-left">{{  date('d-m-Y', strtotime($rsm->appointment_date )) }}</td>
                                
                            </tr>                        
                            <tr>
                                <td class="text-left h6">{{ __('RSM Code') }}</td>
                                <td class="text-left">{{ $rsm->rsm_code }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Full Name') }}</td>
                                <td class="text-left">{{ $rsm->name }}</td>
                            </tr>
                            @if($rsm->father_name)
                            <tr>
                                <td class="text-left h6">{{ __('Father\'s Name') }}</td>
                                <td class="text-left">{{ $rsm->father_name }}</td>
                            </tr>
                            @endif
                            @if($rsm->husband_name)
                            <tr>
                                <td class="text-left h6">{{ __('Husband\'s Name') }}</td>
                                <td class="text-left">{{ $rsm->husband_name }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-left h6">{{ __('Mother\'s Name') }}</td>
                                <td class="text-left">{{ $rsm->mother_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Date of Birth') }}</td>
                                <td class="text-left">{{  date('d-m-Y', strtotime($rsm->date_of_birth )) }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('Phone Number') }}</td>
                                <td class='text-left'>{{ $rsm->contact_no }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('NID No') }}</td>
                                <td class='text-left'>{{ $rsm->nid }}</td>
                            </tr>
                            @if($rsm->email)
                            <tr>
                                <td class='text-left h6'>{{ __('Email') }}</td>
                                <td class='text-left'>{{ $rsm->email }}</td>
                            </tr>
                            @endif
                            @if($rsm->present_address == $rsm->permanent_address)
                            <tr>
                                <td class='text-left h6'>{{ __('Present Address') }}</td>                            
                                <td class='text-left'>{{ $rsm->present_address }}</td>
                            </tr>
                            @else
                            <tr>
                                <td class='text-left h6'>{{ __('Present Address') }}</td>                            
                                <td class='text-left'>{{ $rsm->present_address }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('Permanent Address') }}</td>                            
                                <td class='text-left'>{{ $rsm->permanent_address }}</td>
                            </tr>                        
                            @endif
                            @if($rsm->signature)
                            <tr>
                                <td class='text-left h6'>{{ __('Signature') }}</td>
                                <td class='text-left'>
                                    <img src='{{ asset('/storage/images/'. $rsm->signature) }}' width='150'>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-left h6">{{ __('Branch Code') }}</td>
                                <td class="text-left">{{ $rsm->branch_code }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Branch Name') }}</td>
                                <td class="text-left">{{ $rsm->branch_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Requirement Type') }}</td>
                                <td class="text-left">{{ $rsm->requirement_type }}</td>
                            </tr>
                            @if($rsm->mr_no)
                            <tr>
                                <td class='text-left h6'>{{ __('MR No') }}</td>
                                <td class="text-left">{{ $rsm->mr_no }}</td>
                            </tr>
                            @endif
                            @if($rsm->mr_amount)
                            <tr>
                                <td class='text-left h6'>{{ __('MR Amount') }}</td>
                                <td class="text-left">{{ $rsm->mr_amount }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </fieldset>
                @if($rsm->dgm_code || $rsm->gm_code)
                <fieldset class="border p-2 mb-3">
                    <legend class="w-auto h5">{{ __('Chain Code') }}</legend>
                    <table class="table table-hover table-bordered">
                        <tbody>                            
                           
                            @if($rsm->dgm_code)
                            <tr>
                                <td class='text-left h6'>{{ __('DGM Code') }}</td>
                                <td class="text-left">{{ $rsm->dgm_code }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('DGM Name') }}</td>
                                <td class="text-left">{{ $rsm->dgm_name }}</td>
                            </tr>
                            @if($rsm->dgm_code_change_notes)
                            <tr>
                                <td class='text-left h6'>{{ __('DGM Change Notes') }}</td>
                                <td class="text-left">{{ $rsm->dgm_code_change_notes }}</td>
                            </tr>
                            @endif
                            @endif

                            @if($rsm->gm_code)
                            <tr>
                                <td class='text-left h6'>{{ __('GM Code') }}</td>
                                <td class="text-left">{{ $rsm->gm_code }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('GM Name') }}</td>
                                <td class="text-left">{{ $rsm->gm_name }}</td>
                            </tr>
                            @if($rsm->gm_code_change_notes)
                            <tr>
                                <td class='text-left h6'>{{ __('GM Change Notes') }}</td>
                                <td class="text-left">{{ $rsm->gm_code_change_notes }}</td>
                            </tr>
                            @endif
                            @endif
    
                        </tbody>
                    </table>
                </fieldset>
                @endif
                
                <div class="mb-5">
                    <a href="{{ route('RSMcode.index') }}" class="btn btn-primary pull-right">{{ __('Go Back') }}</a>  
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection





