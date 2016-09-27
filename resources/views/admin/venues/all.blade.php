@extends('admin.layout')

@section('content')
    @include('admin.venues.modals.assign-owner')
    @include('admin.venues.modals.toggle-venue-status')
    <div class="box">
        <div class="box-header">All venues</div>
        <div class="box-body">
            <div class="dataTables_wrapper form-inline ">
                <div class="row">

                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <table aria-describedby="users_table" role="grid" id="example1"
                               class="table table-bordered table-striped dataTable">
                            <thead>
                            <tr role="row">
                                <th aria-label="Rendering engine: activate to sort column descending"
                                    aria-sort="ascending" style="width: 182px;" colspan="1" rowspan="1"
                                    aria-controls="example1" tabindex="0" class="sorting_asc">Name
                                </th>
                                <th aria-label="Browser: activate to sort column ascending" style="width: 223px;"
                                    colspan="1" rowspan="1" aria-controls="example1" tabindex="0" class="sorting">
                                    Address
                                </th>
                                <th aria-label="Platform(s): activate to sort column ascending" style="width: 197px;"
                                    colspan="1" rowspan="1" aria-controls="example1" tabindex="0" class="sorting">
                                    City
                                </th>
                                <th aria-label="Engine version: activate to sort column ascending" style="width: 90px;"
                                    colspan="1" rowspan="1" aria-controls="example1" tabindex="0" class="sorting">
                                    Country
                                </th>
                                <th aria-label="CSS grade: activate to sort column ascending" style="width: 110px;"
                                    colspan="1" rowspan="1" aria-controls="example1" tabindex="0" class="sorting">Time
                                    created
                                </th>
                                <th aria-label="CSS grade: activate to sort column ascending" style="width: 110px;"
                                    colspan="1" rowspan="1" aria-controls="example1" tabindex="0" class="sorting">Time
                                    updated
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($venues as $k => $venue)
                                <tr class="{{$k %2==0 ? "odd" : "even"}} clickable-row" role="row"
                                    data-href="{{action('BusinessOwner\VenuesController@info',$venue->slug)}}">
                                    <td>{{$venue->name}}</td>
                                    <td>{{$venue->location->address}}</td>
                                    <td>{{$venue->location->city->name}}</td>
                                    <td>{{$venue->location->country->name}}</td>
                                    <td>{{jDateTime::dateCarbon($venue->created_at)}}</td>
                                    <td>{{$venue->updated_at->diffforhumans()}}</td>
                                    <td>
                                        <a href="#" class="assignVenueOwner"
                                           data-item-id="{{$venue->getKey()}}">
                                            <div class="col-xs-6">
                                                <i class="icon ion-person "
                                                   style="    font-size: 25px;    line-height: 37px;"></i></div>
                                        </a>

                                        <a href="#"
                                           class=" assignVenueStatus" data-item-id="{{$venue->getKey()}}"
                                           data-item-status="{{$venue->status}}">
                                            <div class="col-xs-6"><i
                                                        class="icon ion-lock-combination assignStatus"
                                                        style="    font-size: 25px;    line-height: 37px;"></i>
                                            </div>
                                        </a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @include('admin.partials.tablefooter',['elements'=>$venues])

            </div>
        </div>
    </div>

    </div>
@stop
@section('footer.scripts')
    <script src="/js/admin.table.js"></script>
    <script src="{{asset('js/typeahead.bundle.min.js')}}"></script>
    <script src="{{asset("js/bloodhound.min.js")}}"></script>
{{--    <scrtip src="{{asset("js/typeahead.jquery.min.js")}}"></scrtip>--}}
    <script src="/js/assign-owner.js"></script>
@stop