@extends('layout-full-width')

@section('content')
    <div class="stick-to-navbar">
        @include('cities.partials.hero')
        @foreach($venuesLists as $key=> $venuesList)
            <div class="cuisine  {{($key%2==0)?"even":"odd"}}">
                @include('cities.partials.cuisine',['venuesList'=>$venuesList,'cuisine'=>$cuisines[$key]])
            </div>
        @endforeach
    </div>
    </div>
@stop
@section('header.stylesheets')
    <link rel="stylesheet" href="/css/home.css">
@stop
@section('footer.scripts')
    <script src="/js/async-loader.js"></script>
    <script src="/js/hero-quote.js"></script>

@stop