@extends('users.user-base-layout')

@section('innerContent')
    <h1 class="setting-heading">
        اطلاعات حساب کاربری
    </h1>
    <div class="col-xs-8 col-xs-offset-4">
        <div class="top-xs-40">
            <!--- full name Field --->
            {!! Form::open(["action"=>"UsersController@settings",'method'=>"PATCH"]) !!}
            <div class="form-group">
                {!! Form::label('name', 'نام کامل شما*') !!}
                {!! Form::text('name', $currentUser->name, ['class' => 'form-control']) !!}
            </div>
            <!--- selectfield Field --->
            {!! Form::label('city', 'کجا زندگی می کنید؟') !!}
            <div class="form-group">

                @if(is_null($user->city))
                    <select name="city" id="" class="form-control">
                        <option value=""></option>
                        @foreach($availableCities as $city)
                            <option value="{{$city->slug}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                @else
                    <select name="city" id="" class="form-control">
                        @foreach($availableCities as $city)
                            <option value="{{$city->slug}}"
                                    selected="{{$user->city->getKey()==$city->getKey()?"selected":""}}">{{$city->name}}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            <!--- bio Field --->
            <div class="form-group">
                {!! Form::label('bio', 'کمی درباره خودتان:') !!}
                {!! Form::textarea('bio', $currentUser->bio, ['class' => 'form-control bio-textarea' ,'id'=>'bio-container']) !!}
                <label class="faNum bio-info">
                    بیوگرافی شما حداکثر 140 کاراکتر می تواند باشد.
                </label>
                <label id="char-left" class="bio-info" style="    float: left;
    margin-left: 15px;
">
                    140
                </label>
            </div>
            <!--- phone Field --->
            <div class="form-group">
                {!! Form::label('phone', 'شماره تماس شما:') !!}
                {!! Form::text('phone', $currentUser->phone, ['class' => 'form-control','placeholder'=>'09129876543']) !!}
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
                    {!! Form::submit('ذخیره', ['class' => 'btn btn-success']) !!}
                </div>
                {!! Form::close() !!}
        </div>
    </div>

@stop
@section('footer.scripts')
    <script>
        var bioTextArea = $("#bio-container");
        var charLeftContainer = $("#char-left");
        charLeftContainer.text(140 - bioTextArea.val().length);
        bioTextArea.on("keyup", function () {
                    var length = bioTextArea.val().length;
                    var charLeft = 140 - length;

                    if (length > 140) {
                        bioTextArea.val(bioTextArea.val().slice(0, 140))
                        charLeftContainer.text(0);
                    }
                    else {
                        charLeftContainer.text(charLeft);
                        if (charLeft <= 10)
                            charLeftContainer.addClass("text-danger");
                        else
                            charLeftContainer.removeClass("text-danger");
                    }
                }
        )
    </script>
@stop