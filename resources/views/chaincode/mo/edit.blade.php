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
        <li class="breadcrumb-item"><a href="{{ route('MOcode.index') }}">{{ __('MO List') }}</a></li>
    </ul>
</div>
@include('partials.flash')
<div class="row">
    <div class="col-md-2 nominee-padding">
        <div class="tile p-0">
            @include('chaincode.mo.includes.sidebar')
        </div>
    </div>
    <div class="col-10 mx-auto nominee-padding">
        <div class="tile">
            <h3 class="tile-title text-center">{{__('Edit MO Account Details')}}</h3>
            <form action=" {{ route('MOcode.update') }} " method="POST" role="form" enctype="multipart/form-data">
                @csrf
                <hr>
                <div class="tile-body">
                    {{-- BM personal details --}}
                    <fieldset class="form-group border p-3">
                        <legend class="w-auto px-2 h6">{{ __('MO\'s Personal Data') }}</legend>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="mo_code">{{ __('MO Code') }}<span class="text-danger"> *</span></label>
                                    <input class="form-control @error('mo_code') is-invalid @enderror" type="text"
                                        name="mo_code" id="mo_code" value="{{ old('mo_code', $mo->mo_code) }}" required>
                                    @error('mo_code') {{ $message }}@enderror
                                </div>
                                <input type="hidden" name="id" value="{{$mo->id}}">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="appointment_date">{{ __('Appointment Date') }}<span class="text-danger"> *</span></label>
                                    <input type="text" class="form-control datetimepicker @error('appointment_date') is-invalid @enderror" 
                                    name="appointment_date" id="appointment_date" placeholder="choose date (d-m-Y)"
                                         value="{{ old('appointment_date', date('d-m-Y', strtotime($mo->appointment_date)) ) }}" autocomplete="off" required>
                                    @error('appointment_date') {{ $message }}@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="name">{{ __('Full Name') }}<span class="text-danger"> *</span></label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                                        name="name" id="name" value="{{ old('name', $mo->name) }}" required>
                                    @error('name') {{ $message }}@enderror
                                </div>
                            </div>
                        </div>                    
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="father_name">{{ __('Father\'s Name') }}</label>
                                    <input class="form-control @error('father_name') is-invalid @enderror" type="text"
                                        name="father_name" id="father_name" value="{{ old('father_name', $mo->father_name) }}">
                                    @error('father_name') {{ $message }}@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="husband_name">{{ __('Husband\'s Name') }}</label>
                                    <input class="form-control @error('husband_name') is-invalid @enderror" type="text"
                                        name="husband_name" id="husband_name" value="{{ old('husband_name', $mo->husband_name ) }}">
                                    @error('husband_name') {{ $message }}@enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="mother_name">{{ __('Mother\'s Name') }}</label>
                                    <input class="form-control @error('mother_name') is-invalid @enderror" type="text"
                                        name="mother_name" id="mother_name" value="{{ old('mother_name', $mo->mother_name) }}">
                                    @error('mother_name') {{ $message }}@enderror
                                </div>
                            </div>
                        </div>
                        <div class="row"> 
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="date_of_birth">{{ __('Date of Birth') }}<span class="text-danger"> *</span></label>
                                    <input class="form-control datetimepicker @error('date_of_birth') is-invalid @enderror" type="text"
                                        name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth', date('d-m-Y', strtotime($mo->date_of_birth ))) }}" 
                                        placeholder="choose date (d-m-Y)" autocomplete="off" required>
                                    @error('date_of_birth') {{ $message }}@enderror
                                </div>
                            </div>                       
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="contact_no">{{ __('Contact No') }}<span class="text-danger"> *</span></label>
                                    <input class="form-control @error('contact_no') is-invalid @enderror" type="text"
                                        name="contact_no" id="contact_no" value="{{ old('contact_no', $mo->contact_no) }}" required>
                                    @error('contact_no') {{ $message }}@enderror
                                </div>
                            </div>                           
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="email">{{ __('E-mail') }}</label>
                                    <input class="form-control @error('email') is-invalid @enderror" type="email"
                                        name="email" id="email" value="{{ old('email', $mo->email ) }}">
                                    @error('email') {{ $message }}@enderror
                                </div>
                            </div>   
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="nid">{{ __('NID No') }}<span class="text-danger"> *</span></label>
                                    <input class="form-control @error('nid') is-invalid @enderror" type="text"
                                        name="nid" id="nid" value="{{ old('nid', $mo->nid) }}" required>
                                    @error('nid') {{ $message }}@enderror
                                </div>
                            </div>                         
                        </div>
                                        
                        <div class="row">                            
                            <div class="col-md-6">
                                <div class="form-group mb-1">
                                    <label class="control-label" for="present_address">{{ __('Present Address') }}</label>
                                    <textarea class="form-control" rows="4" name="present_address"
                                        id="present_address">{{ old('present_address', $mo->present_address) }}</textarea>
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
                                        id="permanent_address">{{ old('permanent_address',$mo->present_address) }}</textarea>
                                </div>                                
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-2 text-left">                                
                                @if($mo->photo)
                                <img src="{{ asset('/storage/images/'. $mo->photo)}}" width="150"
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
                                @if($mo->signature)
                                <img src="{{ asset('/storage/images/'. $mo->signature)}}" width="150"
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
                        <legend class="w-auto px-2 h6">{{ __('MO\'s Chain Code Data') }}</legend>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="bm_code">{{ __('Select BM') }}</label>
                                    <select name="bm_code" id="bm_code" class="form-control">
                                        @foreach($bms as $bm)
                                        <option></option>
                                        @php $check = $bm->bm_code == $mo->bm_code ?
                                        'selected' : '';
                                        @endphp
                                        <option value="{{ $bm->bm_code }}" {{ $check }}>{{ $bm->name }}</option>
                                        @endforeach
                                    </select>
                                </div>  
                                <input type="hidden" name="bm_name" id="bm_name" value="{{ $mo->bm_name }}">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="asm_code">{{ __('Select ASM') }}</label>
                                    <select name="asm_code" id="asm_code" class="form-control">
                                        @foreach($asms as $asm)
                                        <option></option>
                                        @php $check = $asm->asm_code == $mo->asm_code ?
                                        'selected' : '';
                                        @endphp
                                        <option value="{{ $asm->asm_code }}" {{ $check }}>{{ $asm->asm_name }}</option>
                                        @endforeach
                                    </select>
                                </div>  
                                <input type="hidden" name="asm_name" id="asm_name" value="{{ $mo->asm_name }}">
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="rsm_code">{{ __('Select RSM') }}</label>
                                    <select name="rsm_code" id="rsm_code" class="form-control">
                                        @foreach($rsms as $rsm)
                                        <option></option>
                                        @php $check = $rsm->rsm_code == $mo->rsm_code ?
                                        'selected' : '';
                                        @endphp
                                        <option value="{{ $rsm->rsm_code }}" {{ $check }}>{{ $rsm->rsm_name }}</option>
                                        @endforeach
                                    </select>
                                </div>  
                                <input type="hidden" name="rsm_name" id="rsm_name" value="{{ $mo->rsm_name }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="bm_code_change_notes">{{ __('BM Change Notes') }}</label>
                                    <textarea class="form-control" rows="3" name="bm_code_change_notes"
                                        id="bm_code_change_notes">{{ old('bm_code_change_notes',$mo->bm_code_change_notes) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="asm_code_change_notes">{{ __('ASM Change Notes') }}</label>
                                    <textarea class="form-control" rows="3" name="asm_code_change_notes"
                                        id="asm_code_change_notes">{{ old('asm_code_change_notes',$mo->asm_code_change_notes) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="rsm_code_change_notes">{{ __('RSM Change Notes') }}</label>
                                    <textarea class="form-control" rows="3" name="rsm_code_change_notes"
                                        id="rsm_code_change_notes">{{ old('rsm_code_change_notes',$mo->rsm_code_change_notes) }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="dgm_code">{{ __('Select DGM') }}</label>
                                    <select name="dgm_code" id="dgm_code" class="form-control">
                                        @foreach($dgms as $dgm)
                                        <option></option>
                                        @php $check = $dgm->dgm_code == $mo->dgm_code ?
                                        'selected' : '';
                                        @endphp
                                        <option value="{{ $dgm->dgm_code }}" {{ $check }}>{{ $dgm->dgm_name }}</option>
                                        @endforeach
                                    </select>
                                </div>  
                                <input type="hidden" name="dgm_name" id="dgm_name" value="{{ $mo->dgm_name }}">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="gm_code">{{ __('Select GM') }}</label>
                                    <select name="gm_code" id="gm_code" class="form-control">
                                        @foreach($gms as $gm)
                                        <option></option>
                                        @php $check = $gm->gm_code == $mo->gm_code ?
                                        'selected' : '';
                                        @endphp
                                        <option value="{{ $gm->gm_code }}" {{ $check }}>{{ $gm->gm_name }}</option>
                                        @endforeach
                                    </select>
                                </div> 
                                <input type="hidden" name="gm_name" id="gm_name" value="{{ $mo->gm_name }}"> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="dgm_code_change_notes">{{ __('DGM Change Notes') }}</label>
                                    <textarea class="form-control" rows="3" name="dgm_code_change_notes"
                                        id="dgm_code_change_notes">{{ old('dgm_code_change_notes',$mo->dgm_code_change_notes) }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label" for="gm_code_change_notes">{{ __('GM Change Notes') }}</label>
                                    <textarea class="form-control" rows="3" name="gm_code_change_notes"
                                        id="gm_code_change_notes">{{ old('gm_code_change_notes',$mo->gm_code_change_notes) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    {{-- BM others data such as branch name, MR no --}}
                    <fieldset class="form-group border p-3">
                        <legend class="w-auto px-2 h6">{{ __('MO\'s Others Data') }}</legend>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="requirement_type">{{ __('Requirement Type') }}</label>
                                    <select class="form-control custom-select mt-15 @error('requirement_type') is-invalid @enderror"
                                        id="requirement_type" name="requirement_type">
                                        <option value="" disabled selected>{{ __('Select requirement type') }}</option>
                                        @foreach(['Promoted', 'Directly Appointed'] as $requirement)
                                        @php $check = $requirement == $mo->requirement_type ?
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
                                        name="mr_no" id="mr_no" value="{{ old('mr_no', $mo->mr_no) }}">
                                    @error('mr_no') {{ $message }}@enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="mr_amount">{{ __('MR Amount') }}</label>
                                    <input class="form-control @error('mr_amount') is-invalid @enderror" type="text"
                                        name="mr_amount" id="mr_amount" value="{{ old('mr_amount', $mo->mr_amount) }}">
                                    @error('mr_amount') {{ $message }}@enderror
                                </div>
                            </div> 
                            <input type="hidden" name="branch_name" id="branch_name">                                        
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label" for="branch_code">{{ __('Select Branch') }}</label>
                                    <select name="branch_code" id="branch_code" class="form-control">
                                        @foreach($branches as $branch)
                                        <option></option>
                                        @php $check = $branch->branch_code == $mo->branch_code ?
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
                    &nbsp;&nbsp;&nbsp;<a class="btn btn-danger" href="{{ route('MOcode.index') }}"><i
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

        //getting ASM Name
        $('#bm_code').select2({
                placeholder: "Select BM",              
                multiple: false, 
                width: '100%',
               // minimumResultsForSearch: -1,                        
        });

        //setting asm name when an asm option is selected.
        $('#bm_code').on('change', function(){
            $('#bm_name').val($(this).children("option:selected").text());
        });

        //getting ASM Name
        $('#asm_code').select2({
                placeholder: "Select ASM",              
                multiple: false, 
                width: '100%',
               // minimumResultsForSearch: -1,                        
        });

        //setting asm name when an asm option is selected.
        $('#asm_code').on('change', function(){
            $('#asm_name').val($(this).children("option:selected").text());
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