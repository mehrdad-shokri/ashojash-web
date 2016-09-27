@extends('owner.layout')


@section('content')
    
@stop

@section('header.stylesheets')
    <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/css/select2.min.css" rel="stylesheet"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.css"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/4.0.1/dropzone.js"></script>
@stop
@section('footer.scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0/js/select2.min.js"></script>

    <script src="/js/fa.js"></script>
    <script> $('#tag_list').select2({
            placeholder: "Select some options",
        });</script>
    <script>$('#cuisine_list').select2({
            placeholder: "Type to search for a cuisine"
        });
    </script>
@stop


