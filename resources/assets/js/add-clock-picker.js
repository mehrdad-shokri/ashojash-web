$(document).ready(function () {

        defineStaticSchedules();
        validateInputs();
        updateDeleteBtn(0, $(".clock-picker-container#0"));
        $("#add-clock-picker").click(function () {
            var servingHourContainer = $('.serving-hour-container');
            var length = servingHourContainer.children().length;
            servingHourContainer.append(createContainer(length));
            newTimePicker("clockPickerFrom" + length);
            newTimePicker("clockPickerTo" + length);
            addTimePickerFromListener("clockPickerFrom" + length);
            $("#" + length + ".delete-schedule").on("click", function () {
                $(this).closest(".clock-picker-container").remove();
                return false;
            });
        });
        function newTimePicker(elementId) {
            var element = $("input#" + elementId);
            element.timepicker('remove');
            element.timepicker({
                'show2400': true,
                'forceRoundTime': true,
                'disableTextInput': true,
                minTime: new Date(0, 0, 0, 0, 30, 0),
                'timeFormat': 'H:i'
            });
            element.on("keypress", function (event) {
                    event.preventDefault();
                }
            );
            element.on("paste", function (event) {
                    event.preventDefault();
                }
            );
        }


        function addTimePickerFromListener(elementId) {
            var timePickerFrom = $("#" + elementId);
            var timePickerTo = timePickerFrom.closest(".clock-picker-container").find(".event");

            timePickerFrom.on('change', function () {
                timePickerTo.timepicker('remove');
                timePickerTo.timepicker({
                    'show2400': true,
                    'forceRoundTime': true,
                    'disableTextInput': true,
                    'timeFormat': 'H:i',
                    minTime: $(this).val(), // 11:45:00 AM,
                    maxTime: new Date(0, 0, 0, 24, 0, 0),
                });
                timePickerTo.val(timePickerFrom.val());
            });
        }

        function updateDeleteBtn(currentId, toAppend) {
            var prevId = currentId - 1;
            var deleteBtn = toAppend.find(".delete-btn#" + (prevId));
            //var deleteBtn = document.createElement('span');
            deleteBtn.attr('id', currentId);
            $(document).on('click', '.delete-btn#' + currentId, function () {
                toAppend.remove();
                if ($('.clock-picker-container').length < 50)
                    $("#add-clock-picker").removeClass('hidden');
            });
            toAppend.prepend(deleteBtn);
        }


        function validateInputs() {
            $("button[type=submit]").on('click', function (e) {
                var button = $(this);
                var re = /^([0-9]|0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/;

                // do other things for a valid form
                $(":input.ui-timepicker-input").each(function () {
                        if (!re.test($(this).val())) {
                            swal({
                                title: "خطا",
                                text: " ساعات کسب و کار خود را کنترل کنید",
                                type: "error",
                                showConfirmButton: true,
                                confirmButtonText: "باشه",
                            });
                            e.preventDefault();
                            $(this).parent().addClass("has-error");
                        }
                    }
                );

            });
        }

        function defineStaticSchedules() {
            var container = $(".static-serving-hour-container");
            container.find("input").each(function () {
                newTimePicker($(this).attr("id"));
            });
            container.find(".listener").each(function () {
                addTimePickerFromListener($(this).attr("id"));
            });
            container.find(".delete-btn").each(function () {
                $(this).on("click", function () {
                    $(this).closest(".clock-picker-container").remove();
                });
            })
            defineDeleteBtns();
        }

        function defineDeleteBtns() {

        }

        function createContainer(length) {
            var element = $(document.createElement('div'));
            element.addClass("col-xs-12 float-children-right clock-picker-container top-xs-20");
            element.attr("id", length);
            var dayPickerContainer = $(document.createElement("div"));
            //
            dayPickerContainer.addClass("col-xs-2 rtl p0");
            var daySelect = $(document.createElement("select"));
            daySelect.addClass("day-picker");
            daySelect.attr("id", "day" + length);
            daySelect.attr("name", "day[]");

            var dayOption = $(document.createElement("option"));
            var day1 = dayOption.clone();
            var day2 = dayOption.clone();
            var day3 = dayOption.clone();
            var day4 = dayOption.clone();
            var day5 = dayOption.clone();
            var day6 = dayOption.clone();
            var day7 = dayOption.clone();
            day1.attr("value", 6);
            day1.text("شنبه");
            day2.attr("value", 0);
            day2.text("یکشنبه");
            day3.attr("value", 1);
            day3.text("دوشنبه");
            day4.attr("value", 2);
            day4.text("سه شنبه");
            day5.attr("value", 3);
            day5.text("چهارشنبه");
            day6.attr("value", 4);
            day6.text("پنج شنبه");
            day7.attr("value", 5);
            day7.text("جمعه");
            daySelect.append(day1);
            daySelect.append(day2);
            daySelect.append(day3);
            daySelect.append(day4);
            daySelect.append(day5);
            daySelect.append(day6);
            daySelect.append(day7);
            dayPickerContainer.append(daySelect);
            //
            var from = $(document.createElement("div"));
            from.addClass("col-xs-1 text-center  left-xs-20 p0");
            var fromChar = $(document.createElement("span"));
            fromChar.addClass("left");
            fromChar.addClass("time-picker-hint");
            fromChar.text("از");
            from.append(fromChar);
            //
            var clockPickerFrom = $(document.createElement("div"));
            clockPickerFrom.addClass("col-xs-3 p0 ltr");
            var clockPickerInnerFrom = $(document.createElement("div"));
            clockPickerInnerFrom.addClass("input-group clockpicker");
            var clockPickerInputFrom = $(document.createElement("input"));
            clockPickerInputFrom.addClass("form-control listener");
            clockPickerInputFrom.attr("id", "clockPickerFrom" + length);
            clockPickerInputFrom.attr("value", "");
            clockPickerInputFrom.attr("name", "clockPickerFrom[]");
            //
            var clockPickerIconContainer = $(document.createElement("span"));
            clockPickerIconContainer.addClass("input-group-addon");
            var clockIcon = $(document.createElement("span"));
            clockIcon.addClass("fa fa-clock-o");
            clockPickerIconContainer.append(clockIcon);
            //
            clockPickerInnerFrom.append(clockPickerInputFrom);
            clockPickerInnerFrom.append(clockPickerIconContainer);
            clockPickerFrom.append(clockPickerInnerFrom);
            /*
             *
             * */
            //
            var to = $(document.createElement("div"));
            to.addClass("col-xs-1 text-center");
            var toChar = $(document.createElement("span"));
            toChar.addClass("left");
            toChar.addClass("time-picker-hint");
            toChar.text("تا");
            to.append(toChar);
            //
            //
            var clockPickerTo = $(document.createElement("div"));
            clockPickerTo.addClass("col-xs-3 p0 ltr");
            var clockPickerInnerTo = $(document.createElement("div"));
            clockPickerInnerTo.addClass("input-group clockpicker");
            var clockPickerInputTo = $(document.createElement("input"));
            clockPickerInputTo.addClass("form-control event");
            clockPickerInputTo.attr("id", "clockPickerTo" + length);
            clockPickerInputTo.attr("value", "");
            clockPickerInputTo.attr("name", "clockPickerTo[]");
            //
            var clockPickerIconContainer = $(document.createElement("span"));
            clockPickerIconContainer.addClass("input-group-addon");
            var clockIcon = $(document.createElement("span"));
            clockIcon.addClass("fa fa-clock-o");
            clockPickerIconContainer.append(clockIcon);
            //
            clockPickerInnerTo.append(clockPickerInputTo);
            clockPickerInnerTo.append(clockPickerIconContainer);
            clockPickerTo.append(clockPickerInnerTo);
            //
            element.append(dayPickerContainer);
            element.append(from);
            element.append(clockPickerFrom);
            element.append(to);
            element.append(clockPickerTo);
            //
            var deleteBtnContainer = $(document.createElement("div"));
            deleteBtnContainer.addClass("col-xs-1");
            var deleteBtn = $(document.createElement("span"))
            deleteBtn.attr("id", length);
            deleteBtn.addClass("icon ion-trash-b  delete-btn delete-schedule col-xs-1");
            deleteBtnContainer.append(deleteBtn);
            element.append(deleteBtnContainer);
            return element;

        }
    }
)
;
