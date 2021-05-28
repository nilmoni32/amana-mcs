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
    <a href="{{ route('RSMcode.create') }}" class="btn btn-primary pull-right">{{ __('Add RSM') }}</a>        
</div>
@include('partials.flash')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-scrollbar">
                    <table class="table table-hover table-bordered" id="asmTable">
                        <thead>
                            <tr>
                                <th> Sl </th>
                                <th> Appoint. Date </th>
                                <th> RSM Code </th>
                                <th> Name </th>                              
                                <th> DGM Code </th>
                                <th> GM Code </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
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
   $(document).ready(function(){

      // DataTable
      $('#asmTable').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('RSMcode.getrsmdata')}}",
         columns: [
            { data: 'id' },
            { data: 'appointment_date' },           
            { data: 'rsm_code' },
            { data: 'name' },            
            { data: 'dgm_code' },
            { data: 'gm_code' },                     
            { data: 'options' },
         ]
      });

      
      $(document).on('click', '.delete-confirm', function(event){
            event.preventDefault();
            const url = $(this).attr('href');
            swal({
                title: 'Are you sure?',
                text: 'This record and it`s details will be permanantly deleted!',
                icon: 'warning',
                buttons: ["Cancel", "Yes!"],
            }).then(function(value) {
                if (value) {
                    window.location.href = url;
                }
            });
        });
      

    });

    
    </script>
@endpush



