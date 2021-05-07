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
    <a href="{{ route('branch.create') }}" class="btn btn-primary pull-right">{{ __('Add Branch') }}</a>        
</div>
@include('partials.flash')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-scrollbar">
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                            <tr>
                                <th> Branch Code </th>
                                <th> Branch Name </th>
                                <th> Incharge Code </th>
                                <th> Incharge Name </th>                            
                                <th> Designation </th>
                                <th> Contact No </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($branches as $branch)
                                <tr>
                                    <td>{{ $branch->branch_code }}</td>
                                    <td>{{ $branch->branch_name }}</td>
                                    <td>{{ $branch->incharge_code }}</td>
                                    <td>{{ $branch->incharge_name }}</td>
                                    <td>{{ $branch->designation }}</td>
                                    @if($branch->mobile_num)
                                        <td>{{ $branch->mobile_num }}</td>   
                                    @else
                                        <td>{{ $branch->phone_num }}</td>
                                    @endif 
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="{{ route('branch.edit', $branch->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>                                       
                                            <a href="{{ route('branch.delete', $branch->id) }}" class="btn btn-sm btn-danger delete-confirm"><i class="fa fa-trash"></i></a>
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
{{-- we need to add  @stack('scripts') in the app.blade.php for the following scripts --}}
@push('scripts')
<script type="text/javascript" src="{{ asset('assets/js/plugins/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/plugins/dataTables.bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
<script type="text/javascript">
    $('#sampleTable').DataTable();

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




