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
                Dashboard
            </div>
            <div class="panel-body">
                <form name='update_super_admin' id='update_super_admin' class="smart-wizard form-horizontal" method="post"   >

                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    {*
                    
                    <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                    <button class="btn btn-bricky" tabindex="5"   type="submit"  value="Change Password" name="change_password" id="change_password" style="width: 162px; margin-left: 122px;">Change Password</button>                                
                    </div>
                    </div>

                    {if $active_status}  
                    <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                    <button class="btn btn-bricky" tabindex="5"   type="submit"  value="Block Software" name="block_software" id="block_software" style="width: 162px; margin-left: 122px;" onclick="check_super_admin_delete_reason();">Block Software</button>                                
                    </div>
                    </div>
                    {/if}
                    {if !$active_status}  
                    <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                    <button class="btn btn-bricky" tabindex="5"   type="submit"  value="Un Block Software" name="unblock_software" id="unblock_software" style="width: 162px; margin-left: 122px;" onclick="check_super_admin_delete_reason();">Un Block Software</button>                                
                    </div>
                    </div>
                    {/if}
                    <div class="form-group" id="delete">
                    <div class="col-sm-2 col-sm-offset-2">
                    <button class="btn btn-bricky" tabindex="5"   type="button"  value="Delete Software" name="delete_software_button" id="delete_software_button" style="width: 162px; margin-left: 122px;" onclick="check_super_admin_delete_reason(this.value);">Delete Software</button>                                
                    </div>
                    </div>


                    <div id="delete_soft_ware" style="display: none">

                    <div class="form-group" style="width: 268px;">
                    <div class="col-sm-9" >
                    <label class="col-sm-2 control-label" for="delete_reason" style="width: 194px;">
                    Reason For Deletion:<span class="symbol required"></span>
                    </label>


                    </div>
                    </div>

                    <div class="form-group">

                    <div class="col-sm-9" style="width: 258px; margin-top: 2px; margin-right: -38px; margin-left: 228px;">
                    <textarea id="delete_reason"  name="delete_reason" class="tinymce form-control"  tabindex="3"  rows='10' >
                        
                    </textarea>{form_error('delete_reason')}


                    </div>

                    </div>

                    <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                    <button class="btn btn-bricky" tabindex="5"   type="submit"  value="Delete Software" name="delete_software" id="delete_software" style="width: 162px; margin-left: 122px;">Delete Software</button>                                
                    </div>
                    </div>
                    </div>



                    <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                    <button class="btn btn-bricky" tabindex="5"   type="submit"  value="Back To Login" name="back_login" id="back_login" style="width: 162px; margin-left: 122px;">Log out</button>                                
                    </div>
                    </div>
                    *}

                    <div >
                    <b>DASHBOARD</b>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

{include file="super_admin/layout/footer.tpl" title="Example Smarty Page" name=""}

{include file="super_admin/layout/page_footer.tpl" title="Example Smarty Page" name=""}  