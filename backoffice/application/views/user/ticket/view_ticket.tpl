                 
{form_open_multipart('user/ticket_system', 'role="form" class=""  name="view_ticket" id="view_ticket" method="post" action="" enctype="multipart/form-data"')}
<input type="hidden" name="active_tab" id="active_tab" value="tab3" >

<div class="col-sm-3 padding_both">
    <div class="form-group">
        <label>{lang('ticket_tracking_id')}</label>
        <input  class="form-control" name="ticket" id="ticket" type="text"/>
    </div>
</div>
<div class="col-sm-3 padding_both_small">
    <div class="form-group  mark_paid">
        <button class="btn btn-primary" type="submit"id="view" value="view" name="view">{lang('view')}</button>
    </div>
</div>
{form_close()}
