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
        <li class="breadcrumb-item"><a href="{{ route('BMcode.index') }}">{{ __('BM List') }}</a></li>
    </ul>          
</div>
@include('partials.flash')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="tile"> 
            <div class="row profile-show-container">                
                <div class="col-md-3">
                    @if($bm->photo)
                    <img src="{{ asset('/storage/images/'. $bm->photo)}}"  class="profile-img">                                   
                    @endif
                </div>                    
                <div class="col-md-9 d-flex align-items-center justify-content-center">
                    <h3 class="tile-title text-center text-uppercase">{{__('BM Account Details')}}</h3>
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
                                    <td class="text-left">{{  date('d-m-Y', strtotime($bm->appointment_date )) }}</td>
                                    
                                </tr>                        
                                <tr>
                                    <td class="text-left h6">{{ __('BM Code') }}</td>
                                    <td class="text-left">{{ $bm->bm_code }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left h6">{{ __('Full Name') }}</td>
                                    <td class="text-left">{{ $bm->name }}</td>
                                </tr>
                                @if($bm->father_name)
                                <tr>
                                    <td class="text-left h6">{{ __('Father\'s Name') }}</td>
                                    <td class="text-left">{{ $bm->father_name }}</td>
                                </tr>
                                @endif
                                @if($bm->husband_name)
                                <tr>
                                    <td class="text-left h6">{{ __('Husband\'s Name') }}</td>
                                    <td class="text-left">{{ $bm->husband_name }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="text-left h6">{{ __('Mother\'s Name') }}</td>
                                    <td class="text-left">{{ $bm->mother_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left h6">{{ __('Date of Birth') }}</td>
                                    <td class="text-left">{{  date('d-m-Y', strtotime($bm->date_of_birth )) }}</td>
                                </tr>
                                <tr>
                                    <td class='text-left h6'>{{ __('Phone Number') }}</td>
                                    <td class='text-left'>{{ $bm->contact_no }}</td>
                                </tr>
                                <tr>
                                    <td class='text-left h6'>{{ __('NID No') }}</td>
                                    <td class='text-left'>{{ $bm->nid }}</td>
                                </tr>
                                @if($bm->email)
                                <tr>
                                    <td class='text-left h6'>{{ __('Email') }}</td>
                                    <td class='text-left'>{{ $bm->email }}</td>
                                </tr>
                                @endif
                                @if($bm->present_address == $bm->permanent_address)
                                <tr>
                                    <td class='text-left h6'>{{ __('Present Address') }}</td>                            
                                    <td class='text-left'>{{ $bm->present_address }}</td>
                                </tr>
                                @else
                                <tr>
                                    <td class='text-left h6'>{{ __('Present Address') }}</td>                            
                                    <td class='text-left'>{{ $bm->present_address }}</td>
                                </tr>
                                <tr>
                                    <td class='text-left h6'>{{ __('Permanent Address') }}</td>                            
                                    <td class='text-left'>{{ $bm->permanent_address }}</td>
                                </tr>                        
                                @endif
                                @if($bm->signature)
                                <tr>
                                    <td class='text-left h6'>{{ __('Signature') }}</td>
                                    <td class='text-left'>
                                        <img src='{{ asset('/storage/images/'. $bm->signature) }}' width='150'>
                                    </td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="text-left h6">{{ __('Branch Code') }}</td>
                                    <td class="text-left">{{ $bm->branch_code }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left h6">{{ __('Branch Name') }}</td>
                                    <td class="text-left">{{ $bm->branch_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-left h6">{{ __('Requirement Type') }}</td>
                                    <td class="text-left">{{ $bm->requirement_type }}</td>
                                </tr>
                                @if($bm->mr_no)
                                <tr>
                                    <td class='text-left h6'>{{ __('MR No') }}</td>
                                    <td class="text-left">{{ $bm->mr_no }}</td>
                                </tr>
                                @endif
                                @if($bm->mr_amount)
                                <tr>
                                    <td class='text-left h6'>{{ __('MR Amount') }}</td>
                                    <td class="text-left">{{ $bm->mr_amount }}</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </fieldset>
                    @if($bm->asm_code || $bm->rsm_code || $bm->dgm_code || $bm->gm_code)
                    <fieldset class="border p-2 mb-3">
                        <legend class="w-auto h5">{{ __('Chain Code') }}</legend>
                        <table class="table table-hover table-bordered">
                            <tbody>
                                @if($bm->asm_code)
                                <tr>
                                    <td class='text-left h6'>{{ __('ASM Code') }}</td>
                                    <td class="text-left">{{ $bm->asm_code }}</td>
                                </tr>
                                <tr>
                                    <td class='text-left h6'>{{ __('ASM Name') }}</td>
                                    <td class="text-left">{{ $bm->asm_name }}</td>
                                </tr>
                                @if($bm->asm_code_change_notes)
                                <tr>
                                    <td class='text-left h6'>{{ __('ASM Change Notes') }}</td>
                                    <td class="text-left">{{ $bm->asm_code_change_notes }}</td>
                                </tr>
                                @endif
                                @endif 
                                
                                @if($bm->rsm_code)
                                <tr>
                                    <td class='text-left h6'>{{ __('RSM Code') }}</td>
                                    <td class="text-left">{{ $bm->rsm_code }}</td>
                                </tr>
                                <tr>
                                    <td class='text-left h6'>{{ __('RSM Name') }}</td>
                                    <td class="text-left">{{ $bm->rsm_name }}</td>
                                </tr>
                                @if($bm->rsm_code_change_notes)
                                <tr>
                                    <td class='text-left h6'>{{ __('RSM Change Notes') }}</td>
                                    <td class="text-left">{{ $bm->rsm_code_change_notes }}</td>
                                </tr>
                                @endif
                                @endif  
    
                                @if($bm->dgm_code)
                                <tr>
                                    <td class='text-left h6'>{{ __('DGM Code') }}</td>
                                    <td class="text-left">{{ $bm->dgm_code }}</td>
                                </tr>
                                <tr>
                                    <td class='text-left h6'>{{ __('DGM Name') }}</td>
                                    <td class="text-left">{{ $bm->dgm_name }}</td>
                                </tr>
                                @if($bm->dgm_code_change_notes)
                                <tr>
                                    <td class='text-left h6'>{{ __('DGM Change Notes') }}</td>
                                    <td class="text-left">{{ $bm->dgm_code_change_notes }}</td>
                                </tr>
                                @endif
                                @endif
    
                                @if($bm->gm_code)
                                <tr>
                                    <td class='text-left h6'>{{ __('GM Code') }}</td>
                                    <td class="text-left">{{ $bm->gm_code }}</td>
                                </tr>
                                <tr>
                                    <td class='text-left h6'>{{ __('GM Name') }}</td>
                                    <td class="text-left">{{ $bm->gm_name }}</td>
                                </tr>
                                @if($bm->gm_code_change_notes)
                                <tr>
                                    <td class='text-left h6'>{{ __('GM Change Notes') }}</td>
                                    <td class="text-left">{{ $bm->gm_code_change_notes }}</td>
                                </tr>
                                @endif
                                @endif
        
                            </tbody>
                        </table>
                    </fieldset>
                    @endif
                <div class="mb-5">
                    <a href="{{ route('BMcode.index') }}" class="btn btn-primary pull-right">{{ __('Go Back') }}</a>  
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection





