@if($venue->cuisines->count()==0)
    <span>&nbsp</span>
@endif
@foreach($venue->cuisines as $key =>$cuisine)
    @if($key==$venue->cuisines->count()-1)
        <span
                style="float:right">{{$cuisine->name}}</span>
    @else
        <span style="float: right">{{$cuisine->name}}
            ,&nbsp</span>
    @endif
@endforeach