@if($item->cuisines->count()==0)
    <span>&nbsp</span>
@endif
@foreach($item->cuisines as $key =>$cuisine)
    @if($key==$venue->cuisines->count()-1)
        <span
                style="float:right">{{$cuisine->display_name}}</span>
    @else
        <span style="float: right">{{$cuisine->display_name}}
            ,&nbsp</span>
    @endif
@endforeach