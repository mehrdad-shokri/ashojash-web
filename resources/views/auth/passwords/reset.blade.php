@extends('layout-basic')

@section('content')
    <div class="container ashjsh-container ">
        <div class="white-bg stick-to-navbar">
            <div class="row">
                <div class="col-xs-12">
                    <h3 class="text-center">
                        بازنشانی رمز عبور
                    </h3>
                </div>
                <div class="col-xs-12 col-md-6 col-md-offset-6 top-xs-40">
                    <form role="form" method="POST" action="{{ url('/password/reset') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">


                        <!--- email Field --->
                        <div class="form-group">
                            {!! Form::label('email', 'ایمیل') !!}
                            {!! Form::email('email', null, ['class' => 'form-control ltr']) !!}
                        </div>

                        <!--- password Field --->
                        <div class="form-group">
                            {!! Form::label('password', 'رمز عبور:') !!}
                            {!! Form::password('password', ['class' => 'form-control ltr']) !!}
                        </div>
                        <!--- passwordConfirmation Field --->
                        <div class="form-group">
                            {!! Form::label('password_confirmation', 'تکرار رمز عبور:') !!}
                            {!! Form::password('password_confirmation', ['class' => 'form-control ltr']) !!}
                        </div>
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                    @endif
                    <!--- submit Field --->
                        <div class="form-group">
                            {!! Form::submit('کلمه عبور را بازنشانی کن', ['class' => 'btn btn-primary btn-grey']) !!}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
@stop