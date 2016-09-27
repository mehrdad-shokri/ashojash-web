<div class="row">
    <div class="col-sm-5">
        <div aria-live="polite" role="status" id="example1_info" class="dataTables_info">
            @if($elements->total()==0)
                No item to display
            @else
                Showing {{($elements->currentpage()-1)*$elements->perpage()+1}} to
                @if($elements->currentpage()==$elements->lastpage())
                    {{($elements->currentpage()-1)*$elements->perpage()+1 + $elements->total()-($elements->currentpage()-1)*$elements->perpage()-1}}
                @else
                    {{$elements->currentpage()*$elements->perpage()}}
                @endif
                of {{$elements->total()}} entries
            @endif
        </div>
    </div>
    <div class="col-sm-7">
        <div class="pull-pagination-right ">
            {!! $elements->render() !!}
        </div>
    </div>
</div>