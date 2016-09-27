<div class="row top-xs-5">
    @if($currentDaySchedules->count()>0)
        <div class="col-xs-12">
            <div class="col-xs-9">
                @foreach($currentDaySchedules as $currentDaySchedule)
                    <span class="faNum">{{$currentDaySchedule->opening_at}}</span>
                    <span>
                        تا
                    </span>
                    <span class="faNum">{{$currentDaySchedule->closing_at}}</span>
                    @if($currentDaySchedules->last()->getKey()!=$currentDaySchedule->getKey())
                        <span class="time-separator">,</span>
                    @endif
                @endforeach
            </div>
            <div class="col-xs-3" style="font-size: 14px;font-weight: bold">
                امروز
            </div>
        </div>
    @endif
    @if($schedules->count()>0)
        <div class="row top-xs-10 hidden col-xs-12" id="timings-all">
                @for ($i=0; $i<=6;$i++)
                    <?php $daySchedules = $schedules->where('day', $i);?>
                    @if($daySchedules->count()>0)
                        <div class="col-xs-9">
                            @foreach($daySchedules as $daySchedule)
                                <span class="faNum">{{$daySchedule->opening_at}}</span>
                                <span>
                                        تا
                                    </span>
                                <span class="faNum">{{$daySchedule->closing_at}}</span>
                                @if($daySchedules->last()->getKey()!=$daySchedule->getKey())
                                    <span class="time-separator">,</span>
                                @endif
                            @endforeach
                        </div>
                        <div class="col-xs-3">
                            @if(($currentDaySchedules->count()!=0)&&($daySchedules->count()!=0) &&( $currentDaySchedules->first()->day==$daySchedules->first()->day))
                                <span style="font-weight: bold">{{UI::getDayString($daySchedules->first()->day)}}</span>
                            @else
                                <span>{{UI::getDayString($daySchedules->first()->day)}}</span>
                            @endif
                        </div>
                    @endif
                @endfor
        </div>
    @endif
</div>