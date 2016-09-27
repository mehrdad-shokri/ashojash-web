<div class="row menu-form rtl">
    <div class="col-xs-6"><!--- Name Field --->
        <div class="form-group">
            {!! Form::label('menu_item', 'نام آیتم:') !!}
            {!! Form::text('menu_item', null, ['class' => 'form-control','placeholder'=>'مثل: چلو کباب سلطانی یا، قهوه فرانسه']) !!}
        </div>
    </div>
    <div class="col-xs-3">
        <!--- Price Field --->
        <div class="form-group">
            {!! Form::label('price', 'قیمت:') !!}
            {!! Form::text('price', null, ['class' => 'form-control input-rtl','type'=>'number','placeholder'=>'به تومان']) !!}
        </div>

    </div>
    <div class="col-xs-3">
        <div class="form-group">
            <h6 id="priceHint" class="faNum hidden" style="font-size: 12pt; color: #009300"></h6>
            <ul id="priceError" class="hidden">
                <li style="color: #DD2C00">به طور کامل یک عدد وارد کنید.</li>
            </ul>
        </div>
    </div>
    <div class="col-xs-12">
        <!--- Ingredients Field --->
        <div class="form-group">
            {!! Form::label('ingredients', 'مخلفات:') !!}
            {!! Form::text('ingredients', null, ['class' => 'form-control','placeholder'=>'مثل: راسته گوسفند، برنج طارم اعلاء و کره یا، قهوه فرانسه و شکر.']) !!}

        </div>
    </div>
    {{--<div class="col-xs-12">
        {!! Form::label('', 'ساعات سرو:') !!}
        <span class="fa fa-question-circle" style="color: #bbb; font-size: 12pt"
              title="ساعات سرو این آیتم، اگر همیشه موجود است این فیلد را خالی بگذارید"></span>

    </div>
    <div class="col-xs-12">
        <div class="col-xs-12 serving-hour-container">
            <div class="col-xs-4 float-children-right clock-picker-container" id="0">
                <div class="col-xs-4" style="direction: ltr; padding: 0;">
                    <div class="input-group clockpicker">
                        <input type="text" class="form-control" id="clockPickerTo0" name="clockPickerTo[]">
                                               <span class="input-group-addon">
                                                <span class="fa fa-clock-o"></span>
                                             </span>
                    </div>
                </div>
                <div class="col-xs-1 text-center" style="font-size: 1.5em; padding: 0;">تا</div>
                <div class="col-xs-4 " style="direction: ltr; padding: 0;">
                    <div class="input-group clockpicker">
                        <input type="text" class="form-control" id="clockPickerFrom0" name="clockPickerFrom[]">
                                               <span class="input-group-addon">
                                                <span class="fa fa-clock-o"></span>
                                             </span>
                    </div>
                </div>
                <div class="col-xs-1 text-center" style="font-size: 1.5em; padding: 0;">از</div>
            </div>
            <span class="add-btn fa fa-plus-circle  float-children-right" id="add-clock-picker"></span>
        </div>
          </div>
        --}}

    <!--- add Field --->
    <div class="col-xs-12 faNum" style="margin-top: 12px;">
        @if (count($errors) > 0)

            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="col-xs-12">
        <div id="flash_placeholder"></div>
    </div>
    <!---  submit Field --->

</div>