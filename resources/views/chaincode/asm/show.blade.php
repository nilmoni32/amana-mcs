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
        <li class="breadcrumb-item"><a href="{{ route('ASMcode.index') }}">{{ __('ASM List') }}</a></li>
    </ul>          
</div>
@include('partials.flash')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="tile"> 
            <div class="row profile-show-container">                
                <div class="col-md-3">
                    @if($asm->photo)
                    <img src="{{ asset('/storage/images/'. $asm->photo)}}"  class="profile-img">                                   
                    @else                                
                    <img src="https://via.placeholder.com/500X300?text=Photo" width="350" height="220" class="profile-img">
                    @endif
                </div>                    
                <div class="col-md-9 d-flex align-items-center justify-content-center">
                    <h3 class="tile-title text-center text-uppercase">{{__('ASM Account Details')}}</h3>
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
                                <td class="text-left">{{  date('d-m-Y', strtotime($asm->appointment_date )) }}</td>
                                
                            </tr>                        
                            <tr>
                                <td class="text-left h6">{{ __('ASM Code') }}</td>
                                <td class="text-left">{{ $asm->asm_code }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Full Name') }}</td>
                                <td class="text-left">{{ $asm->name }}</td>
                            </tr>
                            @if($asm->father_name)
                            <tr>
                                <td class="text-left h6">{{ __('Father\'s Name') }}</td>
                                <td class="text-left">{{ $asm->father_name }}</td>
                            </tr>
                            @endif
                            @if($asm->husband_name)
                            <tr>
                                <td class="text-left h6">{{ __('Husband\'s Name') }}</td>
                                <td class="text-left">{{ $asm->husband_name }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-left h6">{{ __('Mother\'s Name') }}</td>
                                <td class="text-left">{{ $asm->mother_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Date of Birth') }}</td>
                                <td class="text-left">{{  date('d-m-Y', strtotime($asm->date_of_birth )) }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('Phone Number') }}</td>
                                <td class='text-left'>{{ $asm->contact_no }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('NID No') }}</td>
                                <td class='text-left'>{{ $asm->nid }}</td>
                            </tr>
                            @if($asm->email)
                            <tr>
                                <td class='text-left h6'>{{ __('Email') }}</td>
                                <td class='text-left'>{{ $asm->email }}</td>
                            </tr>
                            @endif
                            @if($asm->present_address == $asm->permanent_address)
                            <tr>
                                <td class='text-left h6'>{{ __('Present Address') }}</td>                            
                                <td class='text-left'>{{ $asm->present_address }}</td>
                            </tr>
                            @else
                            <tr>
                                <td class='text-left h6'>{{ __('Present Address') }}</td>                            
                                <td class='text-left'>{{ $asm->present_address }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('Permanent Address') }}</td>                            
                                <td class='text-left'>{{ $asm->permanent_address }}</td>
                            </tr>                        
                            @endif
                            @if($asm->signature)
                            <tr>
                                <td class='text-left h6'>{{ __('Signature') }}</td>
                                <td class='text-left'>
                                    <img src='{{ asset('/storage/images/'. $asm->signature) }}' width='150'>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-left h6">{{ __('Branch Code') }}</td>
                                <td class="text-left">{{ $asm->branch_code }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Branch Name') }}</td>
                                <td class="text-left">{{ $asm->branch_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Requirement Type') }}</td>
                                <td class="text-left">{{ $asm->requirement_type }}</td>
                            </tr>
                            @if($asm->mr_no)
                            <tr>
                                <td class='text-left h6'>{{ __('MR No') }}</td>
                                <td class="text-left">{{ $asm->mr_no }}</td>
                            </tr>
                            @endif
                            @if($asm->mr_amount)
                            <tr>
                                <td class='text-left h6'>{{ __('MR Amount') }}</td>
                                <td class="text-left">{{ $asm->mr_amount }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </fieldset>
                @if($asm->rsm_code || $asm->dgm_code || $asm->gm_code)
                <fieldset class="border p-2 mb-3">
                    <legend class="w-auto h5">{{ __('Chain Code') }}</legend>
                    <table class="table table-hover table-bordered">
                        <tbody>                            
                            @if($asm->rsm_code)
                            <tr>
                                <td class='text-left h6'>{{ __('RSM Code') }}</td>
                                <td class="text-left">{{ $asm->rsm_code }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('RSM Name') }}</td>
                                <td class="text-left">{{ $asm->rsm_name }}</td>
                            </tr>
                            @if($asm->rsm_code_change_notes)
                            <tr>
                                <td class='text-left h6'>{{ __('RSM Change Notes') }}</td>
                                <td class="text-left">{{ $asm->rsm_code_change_notes }}</td>
                            </tr>
                            @endif
                            @endif  

                            @if($asm->dgm_code)
                            <tr>
                                <td class='text-left h6'>{{ __('DGM Code') }}</td>
                                <td class="text-left">{{ $asm->dgm_code }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('DGM Name') }}</td>
                                <td class="text-left">{{ $asm->dgm_name }}</td>
                            </tr>
                            @if($asm->dgm_code_change_notes)
                            <tr>
                                <td class='text-left h6'>{{ __('DGM Change Notes') }}</td>
                                <td class="text-left">{{ $asm->dgm_code_change_notes }}</td>
                            </tr>
                            @endif
                            @endif

                            @if($asm->gm_code)
                            <tr>
                                <td class='text-left h6'>{{ __('GM Code') }}</td>
                                <td class="text-left">{{ $asm->gm_code }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('GM Name') }}</td>
                                <td class="text-left">{{ $asm->gm_name }}</td>
                            </tr>
                            @if($asm->gm_code_change_notes)
                            <tr>
                                <td class='text-left h6'>{{ __('GM Change Notes') }}</td>
                                <td class="text-left">{{ $asm->gm_code_change_notes }}</td>
                            </tr>
                            @endif
                            @endif
    
                        </tbody>
                    </table>
                </fieldset>
                @endif
                
                <div class="mb-5">
                    <a href="{{ route('ASMcode.index') }}" class="btn btn-primary pull-right">{{ __('Go Back') }}</a>  
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection





