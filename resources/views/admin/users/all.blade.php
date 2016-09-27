<?php $page_title = "Users list";
    $page_description = ""
?>

@extends('admin.layout')
@section('content')
    <div class="box">
        <div class="box-header">All users</div>
        <div class="box-body">
            <div class="dataTables_wrapper form-inline ">
                <div class="row">
                    <div class="col-md-12">
                        <div class="dataTables_filter bottom-xs-20" id="example1_filter">
                            {!! Form::open(['action'=>"Admin\UsersController@postSearchEmail"]) !!}

                            <div class="form-group">
                                <input aria-controls="user" placeholder="email"
                                       class="form-control userPlaceholder"
                                       type="search" id="user-search" name="email">
                            </div>

                            {!! Form::submit('search', ['class' => 'btn btn-primary']) !!}
                        </div>
                        </label>
                    </div>
                </div>
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
                                Username
                            </th>
                            <th aria-label="Platform(s): activate to sort column ascending" style="width: 197px;"
                                colspan="1" rowspan="1" aria-controls="example1" tabindex="0" class="sorting">
                                Email
                            </th>
                            <th aria-label="Engine version: activate to sort column ascending" style="width: 90px;"
                                colspan="1" rowspan="1" aria-controls="example1" tabindex="0" class="sorting">Score
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

                        @foreach($users as $k => $user)
                            <tr class="{{$k %2==0 ? "odd" : "even"}} clickable-row" role="row"
                                data-href="{{action('Admin\UsersController@show',$user->username)}}">
                                <td>{{$user->name}}</td>
                                <td>{{$user->username}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->score}}</td>
                                <td>{{jDateTime::dateCarbon($user->created_at)}}</td>
                                <td class="faNum dir-rl">{{$user->updated_at->diffforhumans()}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @include('admin.partials.tablefooter',['elements'=>$users])

        </div>
    </div>
    </div>

    </div>
@stop
@section('footer.scripts')
    <script src="/js/admin.table.js"></script>
    {{--   <script src="/js/admin.table.js"></script>
       <script>
           $("#user-search").on("keyup", function () {
               var value = $(this).val();
               if (value.length != 0)
                   sendUserSearchRequest(value);
           });
           function sendUserSearchRequest(value) {
               $.ajax("/admin/user/search" + value, {
                   headers: {
                       'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                   },
                   beforeSend: function () {

                   },
                   dataType: "json",
                   data: {},
                   success: function (data) {
   //                    populate data to the table
                   },
                   error: function () {
                       swal({
                           title: "خطا",
                           text: "موردی یافت نشد",
                           type: "error",
                           confirmButtonText: 'باشه',
                           showConfirmButton: true
                       });
                   },
                   type: "POST"
               });
           }
       </script>--}}
    <script src="{{asset('js/typeahead.bundle.min.js')}}"></script>
    <script src="{{asset("js/bloodhound.min.js")}}"></script>
    <scrtip src="{{asset("js/typeahead.jquery.min.js")}}"></scrtip>
    <script src="{{asset("js/search-user.js")}}"></script>
    {{UI::setTimeDefault()}}
@stop