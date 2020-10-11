{include file="super_admin/layout/header.tpl" name=""}

<div id="span_js_messages" style="display: none;"> 
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {lang('unsubscribe_user')}
            </div>
            <div class="panel-body">
                <form name='send_newsletter' id='send_newsletter' class="smart-wizard form-horizontal" method="post"   >
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">Selelect MLM User:</label>
                        <div class="col-sm-4">
                            <input  type="text"  name="user_name" id="user_name"   autocomplete="Off"  onkeyup="ajax_showOptions(this, 'getUsersByLetters', 'no', event)"  tabindex="1" >{form_error('user_name')}
                            <span id="username_box" style="display:none;"></span>
                        </div>
                    </div>                  
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" tabindex="5"   type="submit"  value="Unsubscribe" name="unsubscribe" id="unsubscribe" style="width: 162px; margin-left: 66px;">{lang('unsubscribe')}</button>                                
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{include file="super_admin/layout/footer.tpl" title="Example Smarty Page" name=""}

{include file="super_admin/layout/page_footer.tpl" title="Example Smarty Page" name=""}  