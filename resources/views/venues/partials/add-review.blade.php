    <div class="col-xs-10 col-xs-offset-1 jumbotron review-container hand" id="js-trigger-review"
         style="    padding-bottom: 20px !important;">
        <input type="hidden" value="{{$venue->slug}}" id="venueSlug">

        <div id="review-hint">
            حداقل 70 کاراکتر درباره تجربه شخصی خود در این رستوران بنویسید.
        </div>
        <div id="review-section" class="hidden">
            <div class="col-xs-12 rtl float-children-right ">
                <div class="col-xs-3"><span
                            class="review-rating-title">قیمت</span><i
                            class="fa fa-question-circle "
                            title="قیمت را با توجه به غذا و سرویس ارزیابی کنید."
                            style="color: #bbb;vertical-align: top;"></i></div>
                <div class="col-xs-9"><select id="cost-rating">
                        <option value=""></option>
                        <option value="1">خیلی گران</option>
                        <option value="2">گران</option>
                        <option value="3">متناسب</option>
                        <option value="4">اقتصادی</option>
                        <option value="5">کاملا اقتصادی</option>
                    </select></div>
            </div>

            <div class="col-xs-12 rtl float-children-right">
                <div class="col-xs-3"><span class="review-rating-title">کیفیت غذا</span>
                </div>
                <div class="col-xs-9"><select id="quality-rating">
                        <option value=""></option>
                        <option value="1">1.0</option>
                        <option value="1.5">1.5</option>
                        <option value="2">2.0</option>
                        <option value="2.5">2.5</option>
                        <option value="3">3.0</option>
                        <option value="3.5">3.5</option>
                        <option value="4">4.0</option>
                        <option value="4.5">4.5</option>
                        <option value="5">5.0</option>
                    </select></div>
            </div>
            <div class="col-xs-12 rtl float-children-right">
                <div class="col-xs-3"><span
                            class="review-rating-title">دکور و سرویس</span></div>
                <div class="col-xs-9"><select id="decor-rating">
                        <option value=""></option>
                        <option value="1">1.0</option>
                        <option value="1.5">1.5</option>
                        <option value="2">2.0</option>
                        <option value="2.5">2.5</option>
                        <option value="3">3.0</option>
                        <option value="3.5">3.5</option>
                        <option value="4">4.0</option>
                        <option value="4.5">4.5</option>
                        <option value="5">5.0</option>
                    </select></div>
            </div>

                                            <textarea name="" id="review-text" class="col-xs-12 white-bg review-section
                                                      review-text p-bottom-0" cols="30" rows="10" placeholder=" نکته: یک مرور عالی شامل غذا، سرویس و محیط می شود.
 توصیه ای برای غذا یا نوشیدنی مورد علاقه تان دارید؟ یا چیزی که هرکس باید اینجا امتحان کند؟ آن را هم ذکر کنید!
و به یاد داشته باشید مرور شما حداقل باید 70 کاراکتر باشد :)" style="    max-width: 100%;"></textarea>

            <div class="col-xs-12 white-bg top-xs-5 review-section expand-height-parent ">
                <div class="col-xs-12 expand-height-child top-xs-10 hand upload-photo-hint fill-parent "
                     id="upload-photo-section"><i class="fa fa-photo"></i> اضافه کردن
                    عکس برای این مرور
                </div>
                <div id="upload-photo-method" class="collapse">
                    <div class="col-xs-12 text-center photo-upload-text photo-upload-text hand expand-height-child p-top-10 text-center"
                         style=" width: 100%  " id="uploadLocal" data-toggle="modal"
                         data-target="#uploadPhotoModal">
                        آپلود عکس
                    </div>
                    {{-- <div class="col-xs-6 text-center photo-upload-text photo-upload-text hand expand-height-child p-top-10"
                          style="    right: 50%;" id="uploadLocal" data-toggle="modal"
                          data-target="#uploadPhotoModal">
                         آپلود عکس
                     </div>
                     <div class="col-xs-6 text-center photo-upload-text hand photo-upload-text expand-height-child p-top-10"
                          id="uploadInstagram">
                         اضافه کردن از اینستاگرم
                     </div>--}}
                </div>
            </div>
            <div class="col-xs-12 top-xs-40">
                <div class="row">
                    <div class="col-xs-2" id="cancel-review" style="text-align: left">
                        <a href="#">کنسل</a>
                    </div>
                    <div class="col-xs-10 pr-0">
                        <div class="btn btn-success right" id="publish-btn">منتشر کن
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>