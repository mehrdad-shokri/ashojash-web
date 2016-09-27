
@extends('admin.layout')
@section('content')
    <div class="box">
        <div class="box-header">All Cities</div>
        <div class="box-body">
            <div class="dataTables_wrapper form-inline ">
                <div class="row">
                    {{--<div class="col-md-6 "></div>
                    <div class="col-md-6">
                        <div class="dataTables_filter pull-right" id="example1_filter">
                            <label>Search:<input aria-controls="example1" placeholder="" class="form-control input-sm"
                                                 type="search">
                            </label>
                        </div>
                    </div>--}}
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
                                <th aria-label="Rendering engine: activate to sort column descending"
                                    aria-sort="ascending" style="width: 182px;" colspan="1" rowspan="1"
                                    aria-controls="example1" tabindex="0" class="sorting_asc">Display name
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
                            @foreach($availableCities as $k => $city)
                                <tr class="{{$k %2==0 ? "odd" : "even"}} clickable-row" role="row"
                                    data-href="{{action('Admin\CitiesController@show',$city->slug)}}">
                                    <td>{{$city->name}}</td>
                                    <td>{{$city->display_name}}</td>
                                    <td>{{jDateTime::dateCarbon($city->created_at)}}</td>
                                    <td>{{$city->updated_at->diffforhumans()}}</td>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
                @include('admin.partials.tablefooter',['elements'=>$availableCities])

            </div>
        </div>
    </div>
@stop
@section('footer.scripts')
    <script src="/js/admin.table.js"></script>
@stop