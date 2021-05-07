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
    <a href="{{ route('MOcode.create') }}" class="btn btn-primary pull-right">{{ __('Add MO') }}</a>        
</div>
@include('partials.flash')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-scrollbar">
                    <table class="table table-hover table-bordered" id="MoTable">
                        <thead>
                            <tr>
                                <th> id </th>
                                <th> Appoint. Date </th>
                                <th> MO Code </th>
                                <th> Name </th>  
                                <th> BM Code </th>                                                          
                                <th> ASM Code </th>
                                <th> RSM Code </th>                                
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>                       
                    </table>

                    {{-- <div class="d-flex justify-content-center">
                        {!! $bms->links() !!}
                    </div> --}}
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
      $('#MoTable').DataTable({
         processing: true,
         serverSide: true,
         ajax: "{{route('MOcode.getmodata')}}",
         columns: [
            { data: 'id' },
            { data: 'appointment_date' },           
            { data: 'mo_code' },
            { data: 'name' },
            { data: 'bm_code' },
            { data: 'asm_code' },
            { data: 'rsm_code' },                     
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




