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
    <div class="col-md-2 nominee-padding">
        <div class="tile p-0">
            @include('chaincode.mo.includes.sidebar')
        </div>
    </div>
    <div class="col-10 mx-auto nominee-padding">
        <div class="tile">
            <div class="tile-body">
                <div class="table-scrollbar">
                    <table class="table table-hover table-bordered" id="MoNomineeTable">
                        <thead>
                            <tr>
                                <th> Sl </th>
                                <th> Name </th>
                                <th> Father's Name</th>
                                <th> Husband's Name </th>                                                            
                                <th> Relation Type</th>
                                <th> Percentage Relations </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead> 
                        <tbody>
                            @foreach($moNominees as $moNominee)
                            <tr>
                                <td class="text-center" style="padding: 0.5rem; vertical-align: 0 ;">
                                    {{ $loop->index + 1 }}
                                </td>
                                <td style="padding: 0.5rem; vertical-align: 0 ;">
                                    {{ $moNominee->name }}</td> 
                                <td style="padding: 0.5rem; vertical-align: 0 ;">
                                    {{ $moNominee->father_name }}</td> 
                                <td style="padding: 0.5rem; vertical-align: 0 ;">
                                    {{ $moNominee->husband_name }}</td> 
                                <td style="padding: 0.5rem; vertical-align: 0 ;">
                                    {{ $moNominee->relation }}</td>
                                <td style="padding: 0.5rem; vertical-align: 0 ;">
                                    {{ $moNominee->relation_percentage }}</td>                               
                                <td class="text-center" style="vertical-align: 0 ;">
                                    <div class="btn-group" role="group" aria-label="Second group">
                                        <a href="{{ route('MOcode.nominee.show', $moNominee->id) }}" 
                                            title='SHOW' class='btn btn-sm btn-primary text-light'><i class='fa fa-user mr-1'></i></a>
                                        <a href="{{ route('MOcode.nominee.edit', $moNominee->id) }}"
                                            title='EDIT' class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                        <a href="{{ route('MOcode.nominee.delete', $moNominee->id) }}"
                                            title='DELETE' class="btn btn-sm btn-danger delete-confirm"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>                                              
                    </table>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/plugins/dataTables.bootstrap.min.js') }}"></script> 
<script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script type="text/javascript">
    $('#MoNomineeTable').DataTable();
    
    $('.delete-confirm').on('click', function (event) {
        event.preventDefault();
        const url = $(this).attr('href');
        swal({
            title: 'Are you sure?',
            text: 'This record and it`s details will be permanantly deleted!',
            icon: 'warning',
            buttons: true,
            buttons: ["Cancel", "Yes!"],
        }).then(function(value) {
            if (value) {
                window.location.href = url;
            }
        });
    });
  
</script>
@endpush





