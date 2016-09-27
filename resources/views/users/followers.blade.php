@extends('users.user-base-layout')
@section('innerContent')

    <div class="col-xs-12 col-md-8 rtl top-xs-40">
        <h4 class="text-muted faNum  right-xs-40"><span
                    class="dark-black follow-title" style="">
                            فالوورها</span>&nbsp;<span class="text-small">({{$followers->count()}})</span></h4>
        @foreach($followers as $follower)
            @include('users.partials.user-small-thumbnail',['user'=>$follower])
        @endforeach
    </div>
    <div class="col-xs-12 col-md-8 rtl top-xs-40">
        <h4 class="text-muted faNum  right-xs-40"><span
                    class="dark-black follow-title">
                در حال دنبال کردن
            </span>&nbsp;<span
                    class="text-small">({{$follows->count()}})</span></h4>
        @foreach($follows as $follow)
            @include('users.partials.user-small-thumbnail',['user'=>$follow])
        @endforeach
    </div>

@stop
@section('footer.innerScripts')
    <script src="/js/follows.js"></script>
    {{-- @include('layouts.partials.scripts.profile-dropzone')--}}
@stop