@extends('biz-owner.biz-owner-layout')

@section('innerContent')
    @include('biz-owner.partials.report-review-modal')
    <div class="container ashjsh-container top-buffer">
        <div class="white-bg p0">
            <input type="hidden" value="{{$venue->slug}}" id="venueSlug">

            <div class="row margin-r-0 left-xs-0 right-xs-0">
                <div class="col-xs-12">
                    <h2 class="text-center">نظرات</h2>
                </div>
                <table class="table table-striped table-hover">
                    <thead></thead>
                    <tbody>

                    @foreach($reviews as $comment)
                        <tr class="col-xs-12 p0">
                            <td class=" col-xs-1 p0">

                                <div class="text-muted text-center" style="margin-top: 25px;margin-right: 13px">
                                    @include('layouts.partials.start-rating',array('rating'=>($comment->quality*2+$comment->decor)/3))
                                </div>
                                <div class="text-muted text-center" style="direction: ltr">
                                    @include('layouts.partials.money-rating',array('rating'=>$comment->cost))
                                </div>
                            </td>
                            <td class="col-xs-11 p0">
                                <div style="min-height: 20px" id="reviewContent">{{$comment->comment}}</div>
                                <div style="direction: rtl; margin-top: 20px;font-size: 12px" class="text-muted">
                                    <span><i class="fa fa-user left-xs-3"></i>{{$comment->user->name}}</span>
                                <span style="margin: 0 5px 0 5px"> <i
                                            class="fa  fa-calendar left-xs-3"></i> {{jDateTime::dateCarbon($comment->updated_at,'date')}}</span>
                                <span><i class="fa fa-clock-o left-xs-3"></i>{{jDateTime::dateCarbon($comment->updated_at,'time')}}
                                   </span>
                                </div>
                                <div style="margin-top: 5px;font-size: 9px">
                                    <div class="tab-content" style="display: inline-block;">
                                        <div class="tab-pane active" role="tabpanel">
                                            <span class="btn btn-xs btn-default report-btn {{($comment->status==0)?"btn-danger":""}}"
                                                  style="font-size: 8px"
                                                  data-review-id="{{$comment->getKey()}}" data-toggle="modal"
                                                  data-target="#reportReviewModal"
                                                  data-review-content="{{$comment->comment}}"
                                                    ><i
                                                        class="fa fa-flag-o"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div></div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
@section('footer.innerScripts')
    <script>

        var venueSlug = $("#venueSlug").val();
        $(".report-btn").on("click", function () {
            var btn = $(this);
            var reviewId = btn.data("review-id");
            if (btn.hasClass("btn-danger")) {

                sendReportReviewRequest(venueSlug, reviewId, btn);
                return false;
            }
        });
        $('#reportReviewModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var reviewContent = button.data('review-content');
            var reviewId = button.data("review-id");
            var modal = $(this);

            modal.find('#reviewContent').text(reviewContent);
            $("#submitReview").on("click", function () {
                sendReportReviewRequest(venueSlug, reviewId, button);
            });
        });
        function sendReportReviewRequest(venueSlug, reviewId, button) {
            $.ajax('/venue/biz-owner/venue/' + venueSlug + "/reviews/" + reviewId + "/report", {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function () {

                },
                data: function () {

                },
                success: function () {
                    if (button.hasClass("btn-danger")) {
                        swal({
                            title: "پایان",
                            text: "گزارش تخلف مرور حذف شد.",
                            type: "success",
                            confirmButtonText: "باشه",
                            showConfirmButton: true,
                        });
                    }
                    else {
                        swal({
                                    title: "پایان",
                                    text: "گزارش تخلف مرور ذخیره شد، به زودی مورد بررسی قرار خواهد گرفت.",
                                    type: "success",
                                    confirmButtonText: "باشه",
                                    showConfirmButton: true,
                                },
                                function () {
                                    $("#reportReviewModal").modal('toggle');
                                });
                    }
                    button.toggleClass("btn-danger");
                },
                error: function () {
                    swal({
                        title: "خطا",
                        text: "خطایی رخ داد، دوباره تلاش کنید.",
                        type: "error",
                        confirmButtonText: "باشه",
                    });
                },
                type: "POST"
            });
        }
    </script>
@stop