<!-- Modal -->
<div class="modal fade" id="assignOwnerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Assign User</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['action'=>'Admin\VenuesController@assignUser']) !!}
                <input type="hidden" id="assignVenueId" name="venueId">
                <!--- email Field --->
                <div class="form-group">
                    {!! Form::label('email', 'email:') !!}
                    {!! Form::text('email', null, ['class' => 'form-control', 'id'=>'user-email','style'=>"padding-top: 3px;"]) !!}
                </div>
                <!--- assign Users Field --->

                <div class="modal-footer ">
                    <div class="form-group left">
                        {!! Form::submit('Assign user', ['class' => 'btn btn-primary']) !!}
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>