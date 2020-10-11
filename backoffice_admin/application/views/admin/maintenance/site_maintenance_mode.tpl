{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">

    <span id="title_msg">{lang('please_enter_site_title!')}</span>
    <span id="msg_descrpn">{lang('please_enter_site_description')}</span>
    <span id="msg_date">{lang('please_select_date')}</span>
    
</div> 
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('site_maintance_mode')}
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
                <div class="row">
                    <div class="col-sm-12">
                        {form_open('admin/site_maintenance','role="form" class="" name="upload_site_maintanence" id="upload_site_maintanence"')}
                        {assign var="date" value=''}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}.
                            </div>
                        </div>
                            <input type="hidden" id="error" value="{$error_flag}">    
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="title">{lang('site_maintenancemode')}<font color="#ff0000">*</font> </label>
                            <div class="col-sm-9">
                                <select tabindex="1"class="form-control" name="status" id="status" onchange="show_site_data(this.value);">
                                    <option {if !$maintenance_mode['status']}selected{/if} value="0" >OFF</option>
                                    <option {if $maintenance_mode['status']}selected{/if} value="1" >ON</option>
                                </select>

                            </div>
                        </div>
                        {assign var="tabindexvalue" value="1"}
                        <div id="site_data" {if !$maintenance_mode['status'] } style="display: none;"{/if}>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="title">{lang('title')}<font color="#ff0000">*</font> </label>
                                <div class="col-sm-9">
                                    <input tabindex="2" class="form-control" name="title" id="title" type="text" size="30" value="{$maintenance_mode['title'] }"/>{form_error('title')}
                                    <span class="help-block" for="title"></span>
                                    {if isset($error['title'])}<span class='val-error' >{$error['title']} </span>{/if}

                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="description">{lang('site_description')}<font color="#ff0000">*</font> </label>
                                <div class="col-sm-9">
                                    <textarea class="ckeditor form-control"  id="description"  name="description"  tabindex="3" >{$maintenance_mode['description']}&nbsp;</textarea>
                                </div>
                                <span class="help-block" for="description"></span>
                                {if isset($error['description'])}<span class='val-error' >{$error['description']} </span>{/if}
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="date_available">
                                    {lang('date_available')}<span class="symbol required"></span>
                                </label>
                                <div class="col-sm-9">
                                    <div class="input-group">
                                        <input data-date-format="yyyy-mm-dd" autocomplete="off" data-date-viewmode="years" class="form-control date-picker" name="date_available" id="date_available" type="text" tabindex="4" size="20" maxlength="10"  value="{$maintenance_mode['date_of_availability'] }" >
                                        <span class="input-group-addon"> <i class="fa fa-calendar"></i> </span>
                                        {if isset($error['date_available'])}<span class='val-error' >{$error['date_available']} </span>{/if}
                                    </div>
                                </div>
                            </div>
                           {$tabindexvalue = 4}
                        </div>
                        <div id="site_data2">
                            <div class="form-group">
                                <label class="col-sm-2 control-label" for="title">{lang('block_options')}</label>
                                <div class="col-sm-9">
                                    <input  tabindex="{$tabindexvalue+1}" type="checkbox" name="block_login" value="1" {if $maintenance_mode['block_login']}checked{/if}>{lang('block_user_login')}<br/>
                                    <input  tabindex="{$tabindexvalue+2}" type="checkbox" name="block_register" value="1" {if $maintenance_mode['block_register']}checked{/if}>{lang('block_user_registration')}<br/>
                                    <input  tabindex="{$tabindexvalue+3}" type="checkbox" name="block_ecommerce" value="1" {if $maintenance_mode['block_ecommerce']}checked{/if}>{lang('block_ecommerce_purchase')}
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-2 col-sm-offset-2">
                                <button class="btn btn-bricky" tabindex="{$tabindexvalue+4}" name="site_submit" type="submit" value="{lang('submit')}"> {lang('submit')} </button>
                            </div>
                        </div>
                        {form_close()}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" name=""}
<script src="{$PUBLIC_URL}/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>
<script src="{$PUBLIC_URL}/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript" ></script>
<script src="{$PUBLIC_URL}/javascript/date_time_picker.js" type="text/javascript" ></script>
<script src="{$PUBLIC_URL}/javascript/site_maintenance.js" type="text/javascript" ></script>]
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl"  name=""}