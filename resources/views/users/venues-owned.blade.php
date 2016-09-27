@extends('users.user-base-layout')
@section('innerContent')
    <h1 class="text-center top-xs-40">
        کسب و کارهای شما
    </h1>
    <div class="row top-xs-60 text-center">
        <table class="table table-striped">
            <thead>
            <tr style="font-weight: 100;
font-size: 17px;">
                <th class="text-center">
                    نام کسب و کار
                </th>
                <th class="text-center">
                    تاریخ شروع اعتبار
                </th>
                <th class="text-center">
                    تاریخ اتمام اعتبار
                </th>
            </tr>
            </thead>
            <tbody>
            @foreach($venues as $venue)
                <tr class="clickable-row hand"
                    @if($venue->valid_until->gt($now))
                    data-href="{{action('BusinessOwner\VenuesController@info',$venue->slug)}}"
                    @else
                    data-href="{{action("VenuesController@getClaim",array($venue->location->city->slug,$venue->slug))}}"
                        @endif
                        >
                    <td>{{$venue->name}}</td>
                    <td>{{jDateTime::dateCarbon($venue->starts_at)}}</td>
                    <td>
                        @if($venue->valid_until->gt($now))
                            {{jDateTime::dateCarbon($venue->valid_until)}}
                        @else
                            <span class="alert alert-danger " style="padding: 5px">

    پایان یافته

</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <ul>

        </ul>
    </div>
@stop
@section('footer.innerScripts')
    <script>
        jQuery(document).ready(function ($) {
            $(".clickable-row").click(function () {
                window.document.location = $(this).data("href");
            });
        });
    </script>
@stop