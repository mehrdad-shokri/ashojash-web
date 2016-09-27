<!-- Modal -->
<div class="modal fade" id="changeVenueStatus" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Change venue status</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['action'=>'Admin\VenuesController@changeStatus']) !!}
                <input type="hidden" id="statusVenueId" name="venueId">
                <!--- email Field --->
                <div class="form-group">
                    {!! Form::label('Status', 'status:') !!}
                    <select name="venueStatus" id="venueStatus">
                        <option value="0">Pending</option>
                        <option value="1">Verified</option>
                        <option value="2">Opening Soon</option>
                        <option value="3">Closed temporarily</option>
                    </select>
                </div>
                <!--- assign Users Field --->

                <div class="modal-footer ">
                    <div class="form-group left">
                        {!! Form::submit('Change status', ['class' => 'btn btn-primary']) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>