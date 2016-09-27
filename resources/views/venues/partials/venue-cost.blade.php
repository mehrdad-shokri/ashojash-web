@for($i=0;$i<$venue->cost;$i++)
    <i class=" fa fa-dollar" dir="lrt"></i>


@endfor
@for($i=0;$i<5-$venue->cost;$i++)
    <i class="text-muted fa fa-dollar" dir="lrt" style="color: #aaa"></i>
@endfor