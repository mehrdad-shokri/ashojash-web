@extends('layout-basic')

@section('content')
    @include('biz-owner.partials.venue-nav')
    @yield('innerContent')
@stop
@section('header.stylesheets')
    <link rel="stylesheet" href="/css/biz-owner.css">
    @yield('header.innerStylesheets')
@stop
@section('footer.scripts')
    @yield('footer.innerScripts')
@stop