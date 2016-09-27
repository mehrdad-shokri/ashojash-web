<div class="static-serving-hour-container">
    @foreach($schedules as $key=>$schedule)
        <div class="col-xs-12 float-children-right clock-picker-container top-xs-20" id="{{$key+60}}">
            <div class="col-xs-2" style="direction: ltr; padding: 0;">
                <select id="day{{$key+60}}" class="rtl" name="day[]"
                        style="width: 100%;direction: rtl;height: 34px;font-size: 15px;">
                    <option value="6" {{$schedule->day=="0"?"selected":""}}>
                        شنبه
                    </option>
                    <option value="0" {{$schedule->day=="1"?"selected":""}}>
                        یکشنبه
                    </option>
                    <option value="1" {{$schedule->day=="2"?"selected":""}}>
                        دوشنبه
                    </option>
                    <option value="2" {{$schedule->day=="3"?"selected":""}}>
                        سه شنبه
                    </option>
                    <option value="3" {{$schedule->day=="4"?"selected":""}}>
                        چهارشنبه
                    </option>
                    <option value="4" {{$schedule->day=="5"?"selected":""}}>
                        پنج شنبه
                    </option>
                    <option value="5" {{$schedule->day=="6"?"selected":""}}>
                        جمعه
                    </option>
                </select>
            </div>
            <div class="col-xs-1 text-center  left-xs-20 time-picker-hint">
                <span class="left">از</span></div>
            <div class="col-xs-3 " style="direction: ltr; padding: 0;">
                <div class="input-group clockpicker">
                    <input type="text" class="form-control listener" id="clockPickerFrom{{$key+60}}"
                           value="{{$schedule->opening_at}}"
                           name="clockPickerFrom[]">
                <span class="input-group-addon">
                    <span class="fa fa-clock-o"></span>
                </span>
                    </input>
                </div>
            </div>
            <div class="col-xs-1 text-center"><span class="left time-picker-hint">تا</span></div>
            <div class="col-xs-3" style="direction: ltr; padding: 0;">
                <div class="input-group clockpicker">
                    <input type="text" class="form-control event " id="clockPickerTo{{$key+60}}"
                           value="{{$schedule->closing_at}}"
                           name="clockPickerTo[]">
                <span class="input-group-addon">
                    <span class="fa fa-clock-o"></span>
                </span>
                    </input>
                </div>
            </div>
            <div class="col-xs-1">
                <span id="{{$key+60}}" class="icon ion-trash-b  delete-btn delete-schedule col-xs-1"></span>
            </div>
        </div>
    @endforeach
</div>
<div class="serving-hour-container ">

</div>
<div class=" col-xs-12  text-center add-btn top-xs-40 circle-">

    <div class="col-md-4 col-md-offset-4 col-xs-12 col-sm-6 col-sm-offset-3 add-schedule" id="add-clock-picker">
        <i class="fa fa-plus-circle add-icon"></i><span
                > اضافه کردن بازه جدید</span>
    </div>
</div>
