@extends('layout-basic')

@section('content')
    <div class="container ashjsh-container ">
        <div class="white-bg p0 stick-to-navbar">
            <div class="row ashjsh-row">
                <div class="col-xs-12 top-xs-60 bottom-xs-60">
                    <div class="col-xs-12 col-sm-5">
                        <img src="/img/static/404.png" alt="" style="max-width: 100%">
                    </div>
                    <div class="col-xs-12 col-sm-6 top-xs-40 right-xs-20">
                        <p style="font-size: 20px;">
                            این یک صفحه‌ی 404 است و فکر می‌کنیم کاملا واضح است که چیزی را که اینجا دنبالش هستید را پیدا
                            نخواهید کرد.
                            <br>
                            ولی می‌دانیم گرسنه‌اید پس اخم و تخم را کنار بگذارید و دکمه قرمز زیر را بزنید تا به صفحه اصلی
                            آشوجاش بروید.
                        </p>

                        <div class="col-xs-8 col-md-6 col-xs-offset-2 col-md-offset-3">
                            <a href="{{url('/')}}" class="ghost-btn text-center ">
خانه
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@stop