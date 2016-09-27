@extends('layout-basic')

@section('content')
    <div class="container ashjsh-container ">
        <div class="white-bg stick-to-navbar">
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="text-center">
                        رمز عبور را فراموش کرده‌اید؟ بازنشانی رمز عبور
                    </h3>
                    <p class="text-center" style="font-size: 15px">
                        ایمیل خود را وارد کنید تا لینک بازنشانی رمز عبور برایتان ارسال شود.
                    </p>
                </div>
                <div class="col-xs-12 col-md-6 col-md-offset-6 top-xs-40">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form role="form" method="POST" action="/password/email">
                    {{csrf_field()}}

                    <!--- email Field --->
                        <div class="form-group">
                            {!! Form::label('email', 'ایمیل:') !!}
                            {!! Form::email('email', null, ['class' => 'form-control ltr']) !!}
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger top-xs-20">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                    @endif
                    <!--- submit Field --->
                        <div class="form-group">
                            {!! Form::submit('لینک بازنشانی رمز عبور را بفرست', ['class' => 'btn btn-primary btn-grey']) !!}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop

<!-- resources/views/auth/password.blade.php -->


