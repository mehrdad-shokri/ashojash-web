@extends('biz-owner.biz-owner-layout')

@section('innerContent')
    <div class="container ashjsh-container  ">
        <div class="white-bg top-xs-30 bottom-xs-50 shadow-1">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="text-center">منو</h2>
                </div>
            </div>
            <div class="row ">
                <div class="col-xs-12 rtl">
                    <a href="{{action('BusinessOwner\MenusController@create',$venue->slug)}}"
                       class="btn btn-primary btn-success"><span
                                class="fa fa-plus-circle"></span> <span>آیتم جدید</span></a>

                    <div class="top-buffer">
                        <table aria-describedby="users_table" role="grid" id="example1"
                               class="table table-bordered table-striped dataTable table-hover ">
                            <thead>
                            <tr role="row">
                                <th aria-label="Rendering engine: activate to sort column descending"
                                    aria-sort="ascending" style="width: 140px; text-align: center" colspan="1"
                                    rowspan="1"
                                    aria-controls="example1" tabindex="0" class="sorting_asc">
                                    نام غذا

                                </th>
                                <th aria-label="Browser: activate to sort column ascending"
                                    style="width: 223px; text-align: center"
                                    colspan="1" rowspan="1" aria-controls="example1" tabindex="0" class="sorting">
                                    مخلفات
                                </th>
                                <th aria-label="Platform(s): activate to sort column ascending"
                                    style="width: 90px; text-align: center"
                                    colspan="1" rowspan="1" aria-controls="example1" tabindex="0" class="sorting">
                                    قیمت
                                </th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($menus as $k => $menu)
                                <tr class="{{$k %2==0 ? "odd" : "even"}} clickable-row faNum" role="row"
                                    data-href="{{action("BusinessOwner\MenusController@edit",array($venue->slug,$menu->id))}}">
                                    <td>{{$menu->menu_item}}</td>
                                    <td>{{$menu->ingredients}}</td>
                                    <td>{{number_format($menu->price,0)}} تومان</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section('header.innerStylesheets')
    {{-- <link rel="stylesheet" href="/css/bootstrap-clockpicker.min.css">--}}
@stop
@section('footer.innerScripts')
    <script src="/js/menu.js"></script>
    {{--
        <script type="text/javascript">
            $('.clockpicker').clockpicker({
                placement: 'bottom',
                align: 'left',
                donetext: 'Done'
            });
        </script>--}}
@stop
