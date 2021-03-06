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
        <li class="breadcrumb-item"><a href="{{ route('BMcode.nominee.index', $bm->id) }}">{{ __('BM Nominee List') }}</a></li>
    </ul>          
</div>
@include('partials.flash')
<div class="row">
    <div class="col-md-2 nominee-padding">
        <div class="tile p-0">
            @include('chaincode.bm.includes.sidebar')
        </div>
    </div>
    <div class="col-md-9 nominee-padding">
        <div class="tile"> 
            <div class="row profile-show-container">                
                <div class="col-md-3">
                    @if($bmNominee->photo)
                    <img src="{{ asset('/storage/images/'. $bmNominee->photo)}}"  class="profile-img">                                   
                    @else                                
                    <img src="https://via.placeholder.com/500X300?text=Photo" width="350" height="220" class="profile-img">
                    @endif
                </div>                    
                <div class="col-md-9 d-flex align-items-center justify-content-center">
                    <h3 class="tile-title text-center text-uppercase">{{__('BM Nominee Account Personal Details')}}</h3>
                </div>
            </div>
            <hr>
            <div class="tile-body">
                <table class="table table-hover table-bordered">
                    <tbody>                       
                        <tr>
                            <td class="text-left h6">{{ __('Full Name') }}</td>
                            <td class="text-left">{{ $bmNominee->name }}</td>
                        </tr>
                        @if($bmNominee->father_name)
                        <tr>
                            <td class="text-left h6">{{ __('Father\'s Name') }}</td>
                            <td class="text-left">{{ $bmNominee->father_name }}</td>
                        </tr>
                        @endif
                        @if($bmNominee->husband_name)
                        <tr>
                            <td class="text-left h6">{{ __('Husband\'s Name') }}</td>
                            <td class="text-left">{{ $bmNominee->husband_name }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-left h6">{{ __('Mother\'s Name') }}</td>
                            <td class="text-left">{{ $bmNominee->mother_name }}</td>
                        </tr>
                        <tr>
                            <td class="text-left h6">{{ __('Date of Birth') }}</td>
                            <td class="text-left">{{  date('d-m-Y', strtotime($bmNominee->date_of_birth )) }}</td>
                        </tr>
                        <tr>
                            <td class='text-left h6'>{{ __('Phone Number') }}</td>
                            <td class='text-left'>{{ $bmNominee->contact_no }}</td>
                        </tr>
                        <tr>
                            <td class='text-left h6'>{{ __('NID No') }}</td>
                            <td class='text-left'>{{ $bmNominee->nid }}</td>
                        </tr>
                        @if($bmNominee->email)
                        <tr>
                            <td class='text-left h6'>{{ __('Email') }}</td>
                            <td class='text-left'>{{ $bmNominee->email }}</td>
                        </tr>
                        @endif
                        @if($bmNominee->present_address == $bmNominee->permanent_address)
                        <tr>
                            <td class='text-left h6'>{{ __('Present Address') }}</td>                            
                            <td class='text-left'>{{ $bmNominee->present_address }}</td>
                        </tr>
                        @else
                        <tr>
                            <td class='text-left h6'>{{ __('Present Address') }}</td>                            
                            <td class='text-left'>{{ $bmNominee->present_address }}</td>
                        </tr>
                        <tr>
                            <td class='text-left h6'>{{ __('Permanent Address') }}</td>                            
                            <td class='text-left'>{{ $bmNominee->permanent_address }}</td>
                        </tr>                        
                        @endif
                        @if($bmNominee->signature)
                        <tr>
                            <td class='text-left h6'>{{ __('Signature') }}</td>
                            <td class='text-left'>
                                <img src='{{ asset('/storage/images/'. $bmNominee->signature) }}' width='150'>
                            </td>
                        </tr>
                        @endif
                        <tr>
                            <td class="text-left h6">{{ __('Relation') }}</td>
                            <td class="text-left">{{ $bmNominee->relation }}</td>
                        </tr>
                        <tr>
                            <td class="text-left h6">{{ __('Relation Percentage (%)') }}</td>
                            <td class="text-left">{{ $bmNominee->relation_percentage }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="mb-5">
                    <a href="{{ route('BMcode.nominee.index', $bm->id) }}" class="btn btn-primary pull-right">{{ __('Go Back') }}</a>  
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection





