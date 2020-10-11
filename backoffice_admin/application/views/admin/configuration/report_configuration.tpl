{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{$tran_you_must_company_address}</span>
    <span id="validate_msg2">{$tran_non_valid_file}</span>
    <span id="validate_msg3">{$tran_only_png_jpg}</span>
    <span id="validate_msg4">{$tran_you_must_enter_valid_email}</span>
    <span id="validate_msg5">{$tran_you_must_enter_valid_email}</span>
    <span id="validate_msg6">{$tran_you_must_enter_phone}</span>
    <span id="validate_msg7">{$tran_you_must_enter_valid_phone}</span>

</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {$tran_report_configuration}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                {form_open('', 'role="form" class="" method="post"  name="report_config" id="report_config"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {$tran_errors_check}
                        </div>
                    </div>
                    <div class="form-group"> 
                        <label class="col-sm-2 control-label" for="co_name">{$tran_company_address}:<span class="symbol required"></span> </label>
                        <div class="col-sm-6">
                            <textarea  class="textfixed" name="addr" id="addr"    autocomplete="Off" >{$setresult['address']}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="email">{$tran_email}<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input  type="text"  name="email" id="email"  value='{$setresult['email']}' utocomplete="Off" >
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="phone" >{$tran_phone}<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input  type="text"  name="phone" id="phone"  value='{$setresult['phone']}'   autocomplete="Off" maxlength="10"> <span id="errmsg2"></span>
                        </div>
                    </div>



                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            <button class="btn btn-bricky" name="report" id="report" value="{$tran_update}">
                                {$tran_update}
                            </button>
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  
