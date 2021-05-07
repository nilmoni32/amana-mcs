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
    <a href="{{ route('ASMcode.create') }}" class="btn btn-primary pull-right">{{ __('Add ASM') }}</a>        
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
                                <th> ASM Code </th>
                                <th> Name </th>
                                <th> RSM Code </th>
                                <th> AGM Code </th>
                                <th> DGM Code </th>
                                <th style="width:100px; min-width:100px;" class="text-center text-danger"><i class="fa fa-bolt"> </i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($asms as $asm)
                                <tr>
                                    <td>{{ $loop->index + 1  }}</td>
                                    <td>{{ $asm->appointment_date }}</td>
                                    <td>{{ $asm->asm_code }}</td>
                                    <td>{{ $asm->name }}</td>                                    
                                    <td>{{ $asm->rsm_code }}</td>
                                    <td>{{ $asm->agm_code }}</td>  
                                    <td>{{ $asm->dgm_code }}</td>                                    
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="{{ route('ASMcode.edit', $asm->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>                                       
                                            <a href="{{ route('ASMcode.delete', $asm->id) }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-center">
                        {!! $asms->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



