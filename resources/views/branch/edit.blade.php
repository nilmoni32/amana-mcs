@extends('layouts.app')
@section('title')
{{ $pageTitle }}
@endsection

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-tags"></i>&nbsp;{{$pageTitle}}</h1>
        <p>{{ $subTitle }}</p>  
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{ route('branch.index') }}">{{ __('Branch List') }}</a></li>
    </ul>
</div>
@include('partials.flash')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="tile">
            <h3 class="tile-title">{{__('Edit Branch Details')}}</h3>
            <form action=" {{ route('branch.update') }} " method="POST" role="form" enctype="multipart/form-data">
                @csrf
                <hr>
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="branch_code">{{ __('Branch Code') }}</label>
                                <input class="form-control @error('branch_code') is-invalid @enderror" type="text"
                                    name="branch_code" id="branch_code" value="{{ old('branch_code', $branch->branch_code) }}">
                                @error('branch_code') {{ $message }}@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="branch_name">{{ __('Branch Name') }}<span class="text-danger"> *</span></label>
                                <input class="form-control @error('branch_name') is-invalid @enderror" type="text"
                                    name="branch_name" id="branch_name" value="{{ old('branch_name', $branch->branch_name) }}">
                                    <input type="hidden" name="id" value="{{$branch->id}}">
                                @error('branch_name') {{ $message }}@enderror
                            </div>                            
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="list_chain_code">{{ __('Branch Chain Code List') }}</label>
                                <input class="form-control @error('list_chain_code') is-invalid @enderror" type="text"
                                    name="list_chain_code" id="list_chain_code" value="{{ old('list_chain_code', $branch->list_chain_code) }}">
                                @error('list_chain_code') {{ $message }}@enderror
                            </div>
                        </div>
                       
                    </div>                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="incharge_code">{{ __('Incharge Code') }}</label>
                                <input class="form-control @error('incharge_code') is-invalid @enderror" type="text"
                                    name="incharge_code" id="incharge_code" value="{{ old('incharge_code', $branch->incharge_code) }}">
                                @error('incharge_code') {{ $message }}@enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="incharge_name">{{ __('Incharge Name') }}</label>
                                <input class="form-control @error('incharge_name') is-invalid @enderror" type="text"
                                    name="incharge_name" id="incharge_name" value="{{ old('incharge_name', $branch->incharge_name) }}">
                                @error('incharge_name') {{ $message }}@enderror
                            </div>
                        </div>
                        <div class="col-md-4">                         
                            <div class="form-group">
                                <label class="control-label" for="designation">{{ __('Designation') }}</label>
                                <select class="form-control custom-select mt-15 @error('designation') is-invalid @enderror"
                                    id="designation" name="designation">
                                    <option value="0">{{ __('Select designation type') }}</option>
                                    @foreach(['MO', 'BM', 'AGM','ASM','RSM','DGM','GM'] as $designation_type)
                                    <option value="{{ $designation_type }}" {{ $designation_type==$branch->designation ? "selected": "" }}>
                                        {{ $designation_type }}</option>
                                    @endforeach
                                </select>
                                @error('designation') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">                        
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="mobile_num">{{ __('Mobile No') }}</label>
                                <input class="form-control @error('mobile_num') is-invalid @enderror" type="text"
                                    name="mobile_num" id="mobile_num" value="{{ old('mobile_num', $branch->mobile_num) }}">
                                @error('mobile_num') {{ $message }}@enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="phone_num">{{ __('Phone No') }}</label>
                                <input class="form-control @error('phone_num') is-invalid @enderror" type="text"
                                    name="phone_num" id="phone_num" value="{{ old('phone_num', $branch->phone_num) }}">
                                @error('phone_num') {{ $message }}@enderror
                            </div>
                        </div>                        
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="address">{{ __('Address') }}</label>
                        <textarea class="form-control" rows="4" name="address"
                            id="address">{{ old('address', $branch->address) }}</textarea>
                    </div>
                   
                </div>
                <div class="tile-footer text-right">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                        Category</button>
                    &nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="{{ route('branch.index') }}"><i
                            class="fa fa-fw fa-lg fa-arrow-left"></i>Go Back</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection