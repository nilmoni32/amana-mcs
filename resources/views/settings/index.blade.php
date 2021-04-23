@extends('layouts.app')

@section('title')
{{ $pageTitle }}
@endsection

@section('content')
<div class="app-title">
    <div>
        <h1><i class="fa fa-cogs"></i>&nbsp;{{ $pageTitle }}</h1>
        {{-- <p>{{ $subTitle }}</p> --}}
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
        <li class="breadcrumb-item"><a href="{{ route('settings') }}">{{ __('Settings') }}</a></li>
    </ul>
</div>
@include('partials.flash')
<div class="row user">
    <div class="col-3">
        <div class="tile p-0">
            <ul class="nav flex-column nav-tabs user-tabs">
                <li class="nav-item"><a class="nav-link active" href="#general" data-toggle="tab">{{ __('General') }}</a></li>                
            </ul>
        </div>
    </div>
    <div class="col-9">
        <div class="tab-content">
            <div class="tab-pane active" id="general">
                @include('settings.includes.general')
            </div>          
        </div>
    </div>
</div>

@endsection