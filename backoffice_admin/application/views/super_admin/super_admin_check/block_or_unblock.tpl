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
                Block OR Unblock User
            </div>
            <div class="panel-body">
                {form_open('', 'name="update_super_admin" id="update_super_admin" class="smart-wizard form-horizontal" method="post"')}

                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
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
                {form_close()}
            </div>
        </div>
    </div>
</div>

{include file="super_admin/layout/footer.tpl" title="Example Smarty Page" name=""}

{include file="super_admin/layout/page_footer.tpl" title="Example Smarty Page" name=""}  