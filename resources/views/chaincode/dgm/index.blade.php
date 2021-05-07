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
    <a href="{{ route('DGMcode.create') }}" class="btn btn-primary pull-right">{{ __('Add DGM') }}</a>        
</div>
@include('partials.flash')
<div class="row">
    <div class="col-md-12">
        <div class="tile">
            <div class="tile-body">
                <div class="table-scrollbar">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr>
                                <th> Sl </th>
                                <th> Appoint. Date </th>
                                <th> DSM Code </th>
                                <th> Name </th>                                
                                <th> GM Code </th>
                                <th> GM Name </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dgms as $dgm)
                                <tr>
                                    <td>{{ $loop->index + 1  }}</td>
                                    <td>{{ $dgm->appointment_date }}</td>
                                    <td>{{ $dgm->dgm_code }}</td>
                                    <td>{{ $dgm->name }}</td>
                                    <td>{{ $dgm->gm_code }}</td> 
                                    <td>{{ $dgm->gm_name }}</td>                                   
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="{{ route('DGMcode.edit', $dgm->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>                                       
                                            <a href="{{ route('DGMcode.delete', $dgm->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {!! $dgms->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



