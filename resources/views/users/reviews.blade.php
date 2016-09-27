@extends('users.user-base-layout')

@section('innerContent')
    <div class=" rtl">
        <div class="col-xs-12 top-xs-20 bottom-xs-20 text-center">
            <h4 class="review-heading right-xs-20">
                نقدهای
                {{$user->name}}
            </h4>
        </div>

        <div class="row">
            <div class="col-xs-12">
                @include('users.partials.user-reviews',$reviews)
            </div>
        </div>
    </div>
@stop
@section('footer.innerScripts')
    <script src="/js/jquery.infinitescroll.js"></script>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
    <script src="{{asset("/js/review-loader.js")}}">
    </script>
    <script src="{{asset("/js/delete-review.js")}}"></script>
@stop