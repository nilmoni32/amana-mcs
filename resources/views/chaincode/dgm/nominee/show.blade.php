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
        <li class="breadcrumb-item"><a href="{{ route('DGMcode.nominee.index', $dgm->id) }}">{{ __('DGM Nominee List') }}</a></li>
    </ul>          
</div>
@include('partials.flash')
<div class="row">
    <div class="col-md-2 nominee-padding">
        <div class="tile p-0">
            @include('chaincode.dgm.includes.sidebar')
        </div>
    </div>
    <div class="col-md-9 nominee-padding">
        <div class="tile"> 
            <div class="row profile-show-container">                
                <div class="col-md-3">
                    @if($dgmNominee->photo)
                    <img src="{{ asset('/storage/images/'. $dgmNominee->photo)}}"  class="profile-img">                                   
                    @else                                
                    <img src="https://via.placeholder.com/500X300?text=Photo" width="350" height="220" class="profile-img">
                    @endif
                </div>                    
                <div class="col-md-9 d-flex align-items-center justify-content-center">
                    <h3 class="tile-title text-center text-uppercase">{{__('DGM Nominee Account Personal Details')}}</h3>
                </div>
            </div>
            <hr>
            <div class="tile-body">
                <table class="table table-hover table-bordered">
                    <tbody>                       
                        <tr>
                            <td class="text-left h6">{{ __('Full Name') }}</td>
                            <td class="text-left">{{ $dgmNominee->name }}</td>
                        </tr>
                        @if($dgmNominee->father_name)
                        <tr>
                            <td class="text-left h6">{{ __('Father\'s Name') }}</td>
                            <td class="text-left">{{ $dgmNominee->father_name }}</td>
                        </tr>
                        @endif
                        @if($dgmNominee->husband_name)
                        <tr>
                            <td class="text-left h6">{{ __('Husband\'s Name') }}</td>
                            <td class="text-left">{{ $dgmNominee->husband_name }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-left h6">{{ __('Mother\'s Name') }}</td>
                            <td class="text-left">{{ $dgmNominee->mother_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-left h6">{{ __('Date of Birth') }}</td>
                            <td class="text-left">{{  date('d-m-Y', strtotime($dgmNominee->date_of_birth )) }}</td>
                        </tr>
                        <tr>
                            <td class='text-left h6'>{{ __('Phone Number') }}</td>
                            <td class='text-left'>{{ $dgmNominee->contact_no }}</td>
                        </tr>
                        <tr>
                            <td class='text-left h6'>{{ __('NID No') }}</td>
                            <td class='text-left'>{{ $dgmNominee->nid }}</td>
                        </tr>
                        @if($dgmNominee->email)
                        <tr>
                            <td class='text-left h6'>{{ __('Email') }}</td>
                            <td class='text-left'>{{ $dgmNominee->email }}</td>
                        </tr>
                        @endif
                        @if($dgmNominee->present_address == $dgmNominee->permanent_address)
                        <tr>
                            <td class='text-left h6'>{{ __('Present Address') }}</td>                            
                            <td class='text-left'>{{ $dgmNominee->present_address }}</td>
                        </tr>
                        @else
                        <tr>
                            <td class='text-left h6'>{{ __('Present Address') }}</td>                            
                            <td class='text-left'>{{ $dgmNominee->present_address }}</td>
                        </tr>
                        <tr>
                            <td class='text-left h6'>{{ __('Permanent Address') }}</td>                            
                            <td class='text-left'>{{ $dgmNominee->permanent_address }}</td>
                        </tr>                        
                        @endif
                        @if($dgmNominee->signature)
                        <tr>
                            <td class='text-left h6'>{{ __('Signature') }}</td>
                            <td class='text-left'>
                                <img src='{{ asset('/storage/images/'. $dgmNominee->signature) }}' width='150'>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-left h6">{{ __('Relation') }}</td>
                            <td class="text-left">{{ $dgmNominee->relation }}</td>
                        </tr>
                        <tr>
                            <td class="text-left h6">{{ __('Relation Percentage (%)') }}</td>
                            <td class="text-left">{{ $dgmNominee->relation_percentage }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="mb-5">
                    <a href="{{ route('DGMcode.nominee.index', $dgm->id) }}" class="btn btn-primary pull-right">{{ __('Go Back') }}</a>  
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection





