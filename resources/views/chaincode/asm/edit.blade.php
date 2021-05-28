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
        <li class="breadcrumb-item"><a href="{{ route('ASMcode.index') }}">{{ __('ASM List') }}</a></li>
    </ul>
</div>
@include('partials.flash')
<div class="row">
    <div class="col-md-2 nominee-padding">
        <div class="tile p-0">
            @include('chaincode.asm.includes.sidebar')
        </div>
    </div>
    <div class="col-10 mx-auto nominee-padding">
        <div class="tile">
            <h3 class="tile-title text-center">{{__('Edit ASM Account Details')}}</h3>
            <form action=" {{ route('ASMcode.update') }} " method="POST" role="form" enctype="multipart/form-data">
                @csrf
                <hr>
                <div class="tile-body">
                    {{-- BM personal details --}}
                    <fieldset class="form-group border p-3">
                        <legend class="w-auto px-2 h6">{{ __('ASM\'s Personal Data') }}</legend>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="asm_code">{{ __('ASM Code') }}<span class="text-danger"> *</span></label>
                                    <input class="form-control @error('asm_code') is-invalid @enderror" type="text"
                                        name="asm_code" id="asm_code" value="{{ old('asm_code', $asm->asm_code) }}" required>
                                    @error('asm_code') {{ $message }}@enderror
                                </div>
                                <input type="hidden" name="id" value="{{$asm->id}}">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="appointment_date">{{ __('Appointment Date') }}<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control datetimepicker @error('appointment_date') is-invalid @enderror" 
                                    name="appointment_date" id="appointment_date" placeholder="choose date (d-m-Y)"
                                         value="{{ old('appointment_date', date('d-m-Y', strtotime($asm->appointment_date)) ) }}" autocomplete="off" required>
                                    @error('appointment_date') {{ $message }}@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="name">{{ __('Full Name') }}<span class="text-danger"> *</span></label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                                        name="name" id="name" value="{{ old('name', $asm->name) }}" required>
                                    @error('name') {{ $message }}@enderror
                                </div>
                            </div>
                        </div>                    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="father_name">{{ __('Father\'s Name') }}</label>
                                    <input class="form-control @error('father_name') is-invalid @enderror" type="text"
                                        name="father_name" id="father_name" value="{{ old('father_name', $asm->father_name) }}">
                                    @error('father_name') {{ $message }}@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="husband_name">{{ __('Husband\'s Name') }}</label>
                                    <input class="form-control @error('husband_name') is-invalid @enderror" type="text"
                                        name="husband_name" id="husband_name" value="{{ old('husband_name', $asm->husband_name ) }}">
                                    @error('husband_name') {{ $message }}@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="mother_name">{{ __('Mother\'s Name') }}</label>
                                    <input class="form-control @error('mother_name') is-invalid @enderror" type="text"
                                        name="mother_name" id="mother_name" value="{{ old('mother_name', $asm->mother_name) }}">
                                    @error('mother_name') {{ $message }}@enderror
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="date_of_birth">{{ __('Date of Birth') }}<span class="text-danger"> *</span></label>
                                    <input class="form-control datetimepicker @error('date_of_birth') is-invalid @enderror" type="text"
                                        name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', date('d-m-Y', strtotime($asm->date_of_birth ))) }}" 
                                        placeholder="choose date (d-m-Y)" autocomplete="off" required>
                                    @error('date_of_birth') {{ $message }}@enderror
                                </div>
                            </div>                       
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="contact_no">{{ __('Contact No') }}<span class="text-danger"> *</span></label>
                                    <input class="form-control @error('contact_no') is-invalid @enderror" type="text"
                                        name="contact_no" id="contact_no" value="{{ old('contact_no', $asm->contact_no) }}" required>
                                    @error('contact_no') {{ $message }}@enderror
                                </div>
                            </div>                           
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="email">{{ __('E-mail') }}</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        name="email" id="email" value="{{ old('email', $asm->email ) }}">
                                    @error('email') {{ $message }}@enderror
                                </div>
                            </div>   
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="nid">{{ __('NID No') }}<span class="text-danger"> *</span></label>
                                    <input class="form-control @error('nid') is-invalid @enderror" type="text"
                                        name="nid" id="nid" value="{{ old('nid', $asm->nid) }}" required>
                                    @error('nid') {{ $message }}@enderror
                                </div>
                            </div>                         
                        </div>
                                        
                        <div class="row">                            
                            <div class="col-md-6">
                                <div class="form-group mb-1">
                                    <label class="control-label" for="present_address">{{ __('Present Address') }}</label>
                                    <textarea class="form-control" rows="4" name="present_address"
                                        id="present_address">{{ old('present_address', $asm->present_address) }}</textarea>
                                </div>
                                <div class="mt-0">
                                <input type="checkbox" id="checkAdd">
                                <label for="checkAdd">{{ __('Is permanent address same as present address?') }}</label> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="permanent_address">{{ __('Permanent Address') }}</label>
                                    <textarea class="form-control" rows="4" name="permanent_address"
                                        id="permanent_address">{{ old('permanent_address',$asm->present_address) }}</textarea>
                                </div>                                
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-2 text-left">                                
                                @if($asm->photo)
                                <img src="{{ asset('/storage/images/'. $asm->photo)}}" width="150"
                                    id="uploadphoto">
                                @else                                
                                <img src="https://via.placeholder.com/500X300?text=Photo" width="150" id="uploadphoto">
                                @endif
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="photo">{{ __('Upload Photo') }}</label>
                                    <input type="file" name="photo" class="form-control fileinput-padding @error('photo') is-invalid @enderror"
                                        id="photo">
                                    <div class="invalid-feedback active">
                                        <i class="fa fa-exclamation-circle fa-fw"></i> @error('photo')
                                        <span>{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-left">                                
                                @if($asm->signature)
                                <img src="{{ asset('/storage/images/'. $asm->signature)}}" width="150"
                                    id="uploadsignature">
                                @else
                                <img src="https://via.placeholder.com/500X300?text=Signature" width="150" id="uploadsignature">
                                @endif
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="signature">{{ __('Upload Signature') }}</label>
                                    <input type="file" name="signature" class="form-control fileinput-padding @error('signature') is-invalid @enderror"
                                        id="signature" accept="image/*,.pdf">
                                    <div class="invalid-feedback active">
                                        <i class="fa fa-exclamation-circle fa-fw"></i> @error('signature')
                                        <span>{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    </fieldset>
                    {{-- BM chain code --}}
                    <fieldset class="form-group border p-3">
                        <legend class="w-auto px-2 h6">{{ __('ASM\'s Chain Code Data') }}</legend>
                        <div class="row">                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="rsm_code">{{ __('Select RSM') }}</label>
                                    <select name="rsm_code" id="rsm_code" class="form-control">
                                        @foreach($rsms as $rsm)
                                        <option></option>
                                        @php $check = $rsm->rsm_code == $asm->rsm_code ?
                                        'selected' : '';
                                        @endphp
                                        <option value="{{ $rsm->rsm_code }}" {{ $check }}>{{ $rsm->name }}</option>
                                        @endforeach
                                    </select>
                                </div>  
                                <input type="hidden" name="rsm_name" id="rsm_name" value="{{ $asm->rsm_name }}">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="dgm_code">{{ __('Select DGM') }}</label>
                                    <select name="dgm_code" id="dgm_code" class="form-control">
                                        @foreach($dgms as $dgm)
                                        <option></option>
                                        @php $check = $dgm->dgm_code == $asm->dgm_code ?
                                        'selected' : '';
                                        @endphp
                                        <option value="{{ $dgm->dgm_code }}" {{ $check }}>{{ $dgm->name }}</option>
                                        @endforeach
                                    </select>
                                </div>  
                                <input type="hidden" name="dgm_name" id="dgm_name" value="{{ $asm->dgm_name }}">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="gm_code">{{ __('Select GM') }}</label>
                                    <select name="gm_code" id="gm_code" class="form-control">
                                        @foreach($gms as $gm)
                                        <option></option>
                                        @php $check = $gm->gm_code == $asm->gm_code ?
                                        'selected' : '';
                                        @endphp
                                        <option value="{{ $gm->gm_code }}" {{ $check }}>{{ $gm->name }}</option>
                                        @endforeach
                                    </select>
                                </div> 
                                <input type="hidden" name="gm_name" id="gm_name" value="{{ $asm->gm_name }}"> 
                            </div>
                        </div>
                        <div class="row">                            
                            <div class="col-md-4">
                                <div class="form-group mb-1">
                                    <label class="control-label" for="rsm_code_change_notes">{{ __('RSM Change Notes') }}</label>
                                    <textarea class="form-control" rows="3" name="rsm_code_change_notes"
                                        id="rsm_code_change_notes">{{ old('rsm_code_change_notes', $asm->rsm_code_change_notes) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-1">
                                    <label class="control-label" for="dgm_code_change_notes">{{ __('DGM Change Notes') }}</label>
                                    <textarea class="form-control" rows="3" name="dgm_code_change_notes"
                                        id="dgm_code_change_notes">{{ old('dgm_code_change_notes', $asm->dgm_code_change_notes) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-1">
                                    <label class="control-label" for="gm_code_change_notes">{{ __('GM Change Notes') }}</label>
                                    <textarea class="form-control" rows="3" name="gm_code_change_notes"
                                        id="gm_code_change_notes">{{ old('gm_code_change_notes', $asm->gm_code_change_notes) }}</textarea>
                                </div>
                            </div>                            
                        </div>
                    </fieldset>
                    {{-- BM others data such as branch name, MR no --}}
                    <fieldset class="form-group border p-3">
                        <legend class="w-auto px-2 h6">{{ __('ASM\'s Others Data') }}</legend>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="requirement_type">{{ __('Requirement Type') }}</label>
                                    <select class="form-control custom-select mt-15 @error('requirement_type') is-invalid @enderror"
                                        id="requirement_type" name="requirement_type">
                                        <option value="" disabled selected>{{ __('Select requirement type') }}</option>
                                        @foreach(['Promoted', 'Directly Appointed'] as $requirement)
                                        @php $check = $requirement == $asm->requirement_type ?
                                        'selected' : '';
                                        @endphp
                                        <option value="{{ $requirement }}" {{ $check }}>{{ $requirement }}</option>
                                        @endforeach
                                    </select>
                                    @error('requirement_type') {{ $message }} @enderror
                                </div>
                            </div>                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="mr_no">{{ __('MR No') }}</label>
                                    <input class="form-control @error('mr_no') is-invalid @enderror" type="text"
                                        name="mr_no" id="mr_no" value="{{ old('mr_no', $asm->mr_no) }}">
                                    @error('mr_no') {{ $message }}@enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="mr_amount">{{ __('MR Amount') }}</label>
                                    <input class="form-control @error('mr_amount') is-invalid @enderror" type="text"
                                        name="mr_amount" id="mr_amount" value="{{ old('mr_amount', $asm->mr_amount) }}">
                                    @error('mr_amount') {{ $message }}@enderror
                                </div>
                            </div> 
                            <input type="hidden" name="branch_name" id="branch_name" value="{{ $asm->branch_name }}">                                        
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="branch_code">{{ __('Select Branch') }}</label>
                                    <select name="branch_code" id="branch_code" class="form-control">
                                        @foreach($branches as $branch)
                                        <option></option>
                                        @php $check = $branch->branch_code == $asm->branch_code ?
                                        'selected' : '';
                                        @endphp
                                        <option value="{{ $branch->branch_code }}" {{ $check }}>{{ $branch->branch_name }}</option>
                                        @endforeach
                                    </select>
                                </div>                                
                            </div>
                        </div>  
                        
                    </fieldset>
                </div>
                <div class="tile-footer text-right">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>{{ __('Update Chain Code') }}</button>
                    &nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="{{ route('ASMcode.index') }}"><i
                            class="fa fa-fw fa-lg fa-arrow-left"></i>{{ __('Go Back') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script type="text/javascript">
    // getting CSRF Token from meta tag
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
    $(document).ready(function () {
        $('.datetimepicker').datetimepicker({
            timepicker:false,
            datepicker:true,        
            format: 'd-m-Y',              
        });
        //copy address
        $('#checkAdd').change(function() {
            if(this.checked) {
                $('#permanent_address').val($('#present_address').val());    
            }else{
                $('#permanent_address').val(''); 
            }
        });

        //Getting Branch Name 
        $('#branch_code').select2({
                placeholder: "Select a branch",              
                multiple: false, 
                width: '100%',
               // minimumResultsForSearch: -1,                        
        });

        //setting branch name when a branch option is selected.
        $('#branch_code').on('change', function(){
            $('#branch_name').val($(this).children("option:selected").text());
        });


        //getting RSM Name
        $('#rsm_code').select2({
                placeholder: "Select RSM",              
                multiple: false, 
                width: '100%',
               // minimumResultsForSearch: -1,                        
        });

        //setting rsm name when an asm option is selected.
        $('#rsm_code').on('change', function(){
            $('#rsm_name').val($(this).children("option:selected").text());
        });
        //getting DGM Name
        $('#dgm_code').select2({
                placeholder: "Select DGM",              
                multiple: false, 
                width: '100%',
               // minimumResultsForSearch: -1,                        
        });
        //setting dgm name when an asm option is selected.        
        $('#dgm_code').on('change', function(){
            $('#dgm_name').val($(this).children("option:selected").text());
        });
        //getting GM Name
        $('#gm_code').select2({
                placeholder: "Select GM",              
                multiple: false, 
                width: '100%',
               // minimumResultsForSearch: -1,                        
        });
        //setting dgm name when an asm option is selected.        
        $('#gm_code').on('change', function(){
            $('#gm_name').val($(this).children("option:selected").text());
        });


        //  This code show the image beforeUpload
        function readURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    //get the id value of the image to be shown for example uploadphoto, uploadsignature
                    var id = 'upload' + $(input).attr('id');

                    reader.onload = function(e) {
                    $('#' + id).attr('src', e.target.result);
                    }
                    
                    reader.readAsDataURL(input.files[0]); // convert to base64 string
                }
            }

            $("#photo").change(function() {
                readURL(this);
            });

            $("#signature").change(function() {
                readURL(this);
            });


        

       

    });

</script>

@endpush