        <!-- Modal -->
<div class="modal fade" id="uploadPhotoModal" tabindex="-1" role="dialog"  aria-labelledby="uploadPhotoModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content upload">
            <div class="modal-header upload-profile-pic-header ">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="float:left"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title "   id="myModalLabel">آپلود عکس</h4>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12">{!! Form::open(array('id'=>'uploadForm','class'=>'dropzone','action'=>array('UsersController@addVenuePhoto',$venue->slug),'enctype'=>"multipart/form-data")) !!}
                            <div class="fallback ">
                                <input name="file" type="file"/>

                                <div class="top-xs-5">
                                    <div class="form-group">
                                    </div>
                                    <button type="submit ">آپلود</button>
                                </div>
                            </div>
                            {!! Form::close() !!}</div>
                        <div class="col-xs-12 text-muted top-xs-20" style="font-size: 13px;   line-height: 9px;">
                            <p>تنها فرمت های jpg/png</p>

                            <p>حداکثر سایز 4MB</p>

                            <p>بیشتر از 400px در ارتفاع و عرض</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
