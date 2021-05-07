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
        <li class="breadcrumb-item"><a href="{{ route('MOcode.index') }}">{{ __('MO List') }}</a></li>
    </ul>          
</div>
@include('partials.flash')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="tile"> 
            <div class="row profile-show-container">                
                <div class="col-md-3">
                    @if($mo->photo)
                    <img src="{{ asset('/storage/images/'. $mo->photo)}}"  class="profile-img">                                   
                    @endif
                </div>                    
                <div class="col-md-9 d-flex align-items-center justify-content-center">
                    <h3 class="tile-title text-center text-uppercase">{{__('MO Account Details')}}</h3>
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
                                <td class="text-left">{{  date('d-m-Y', strtotime($mo->appointment_date )) }}</td>
                                
                            </tr>                        
                            <tr>
                                <td class="text-left h6">{{ __('MO Code') }}</td>
                                <td class="text-left">{{ $mo->mo_code }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Full Name') }}</td>
                                <td class="text-left">{{ $mo->name }}</td>
                            </tr>
                            @if($mo->father_name)
                            <tr>
                                <td class="text-left h6">{{ __('Father\'s Name') }}</td>
                                <td class="text-left">{{ $mo->father_name }}</td>
                            </tr>
                            @endif
                            @if($mo->husband_name)
                            <tr>
                                <td class="text-left h6">{{ __('Husband\'s Name') }}</td>
                                <td class="text-left">{{ $mo->husband_name }}</td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-left h6">{{ __('Mother\'s Name') }}</td>
                                <td class="text-left">{{ $mo->mother_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Date of Birth') }}</td>
                                <td class="text-left">{{  date('d-m-Y', strtotime($mo->date_of_birth )) }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('Phone Number') }}</td>
                                <td class='text-left'>{{ $mo->contact_no }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('NID No') }}</td>
                                <td class='text-left'>{{ $mo->nid }}</td>
                            </tr>
                            @if($mo->email)
                            <tr>
                                <td class='text-left h6'>{{ __('Email') }}</td>
                                <td class='text-left'>{{ $mo->email }}</td>
                            </tr>
                            @endif
                            @if($mo->present_address == $mo->permanent_address)
                            <tr>
                                <td class='text-left h6'>{{ __('Present Address') }}</td>                            
                                <td class='text-left'>{{ $mo->present_address }}</td>
                            </tr>
                            @else
                            <tr>
                                <td class='text-left h6'>{{ __('Present Address') }}</td>                            
                                <td class='text-left'>{{ $mo->present_address }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('Permanent Address') }}</td>                            
                                <td class='text-left'>{{ $mo->permanent_address }}</td>
                            </tr>                        
                            @endif
                            @if($mo->signature)
                            <tr>
                                <td class='text-left h6'>{{ __('Signature') }}</td>
                                <td class='text-left'>
                                    <img src='{{ asset('/storage/images/'. $mo->signature) }}' width='150'>
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td class="text-left h6">{{ __('Branch Code') }}</td>
                                <td class="text-left">{{ $mo->branch_code }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Branch Name') }}</td>
                                <td class="text-left">{{ $mo->branch_name }}</td>
                            </tr>
                            <tr>
                                <td class="text-left h6">{{ __('Requirement Type') }}</td>
                                <td class="text-left">{{ $mo->requirement_type }}</td>
                            </tr>
                            @if($mo->mr_no)
                            <tr>
                                <td class='text-left h6'>{{ __('MR No') }}</td>
                                <td class="text-left">{{ $mo->mr_no }}</td>
                            </tr>
                            @endif
                            @if($mo->mr_amount)
                            <tr>
                                <td class='text-left h6'>{{ __('MR Amount') }}</td>
                                <td class="text-left">{{ $mo->mr_amount }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </fieldset>
                <fieldset class="border p-2 mb-3">
                    <legend class="w-auto h5">{{ __('Chain Code') }}</legend>
                    <table class="table table-hover table-bordered">
                        <tbody>
                            @if($mo->bm_code)
                            <tr>
                                <td class='text-left h6'>{{ __('BM Code') }}</td>
                                <td class="text-left">{{ $mo->bm_code }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('BM Name') }}</td>
                                <td class="text-left">{{ $mo->bm_name }}</td>
                            </tr>
                            @if($mo->bm_code_change_notes)
                            <tr>
                                <td class='text-left h6'>{{ __('BM Change Notes') }}</td>
                                <td class="text-left">{{ $mo->bm_code_change_notes }}</td>
                            </tr>
                            @endif
                            @endif

                            @if($mo->asm_code)
                            <tr>
                                <td class='text-left h6'>{{ __('ASM Code') }}</td>
                                <td class="text-left">{{ $mo->asm_code }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('ASM Name') }}</td>
                                <td class="text-left">{{ $mo->asm_name }}</td>
                            </tr>
                            @if($mo->asm_code_change_notes)
                            <tr>
                                <td class='text-left h6'>{{ __('ASM Change Notes') }}</td>
                                <td class="text-left">{{ $mo->asm_code_change_notes }}</td>
                            </tr>
                            @endif
                            @endif 
                            
                            @if($mo->rsm_code)
                            <tr>
                                <td class='text-left h6'>{{ __('RSM Code') }}</td>
                                <td class="text-left">{{ $mo->rsm_code }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('RSM Name') }}</td>
                                <td class="text-left">{{ $mo->rsm_name }}</td>
                            </tr>
                            @if($mo->rsm_code_change_notes)
                            <tr>
                                <td class='text-left h6'>{{ __('RSM Change Notes') }}</td>
                                <td class="text-left">{{ $mo->rsm_code_change_notes }}</td>
                            </tr>
                            @endif
                            @endif  

                            @if($mo->dgm_code)
                            <tr>
                                <td class='text-left h6'>{{ __('DGM Code') }}</td>
                                <td class="text-left">{{ $mo->dgm_code }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('DGM Name') }}</td>
                                <td class="text-left">{{ $mo->dgm_name }}</td>
                            </tr>
                            @if($mo->dgm_code_change_notes)
                            <tr>
                                <td class='text-left h6'>{{ __('DGM Change Notes') }}</td>
                                <td class="text-left">{{ $mo->dgm_code_change_notes }}</td>
                            </tr>
                            @endif
                            @endif

                            @if($mo->gm_code)
                            <tr>
                                <td class='text-left h6'>{{ __('GM Code') }}</td>
                                <td class="text-left">{{ $mo->gm_code }}</td>
                            </tr>
                            <tr>
                                <td class='text-left h6'>{{ __('GM Name') }}</td>
                                <td class="text-left">{{ $mo->gm_name }}</td>
                            </tr>
                            @if($mo->gm_code_change_notes)
                            <tr>
                                <td class='text-left h6'>{{ __('GM Change Notes') }}</td>
                                <td class="text-left">{{ $mo->gm_code_change_notes }}</td>
                            </tr>
                            @endif
                            @endif
    
                        </tbody>
                    </table>
                </fieldset>
                
                <div class="mb-5">
                    <a href="{{ route('MOcode.index') }}" class="btn btn-primary pull-right">{{ __('Go Back') }}</a>  
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection





