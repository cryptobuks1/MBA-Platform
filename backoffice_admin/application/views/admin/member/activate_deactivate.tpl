{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display: none;">
    <span id="error_msg1">{lang('you_must_enter_username')}</span>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('activate_deactivate')}
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
                {form_open('', 'role="form" class="" name="searchform" id="searchform" method="post"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name">{lang('select_user_name')}<span class="symbol required"></span></label>
                        <div class="col-sm-3">
                            <input class="form-control" type="text" id="user_name" name="user_name"  onKeyUp="ajax_showOptions(this, 'getCountriesByLetters', 'no', event)" autocomplete="Off" tabindex="1">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">

                            <button class="btn btn-bricky" type="submit" id="select" value="select" name="select" tabindex="2">
                                {lang('select')}
                            </button>
                        </div>
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>
{if $flag == "true"}
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>  {lang('member_details')} 
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
                    <table class="table table-striped table-bordered table-hover table-full-width" id=""> 
                        <thead>
                            <tr class="th">
                                <th >{lang('user_name')}</th>
                                <th  >{lang('name')}</th>
                                <th class="hidden-xs">{lang('sponser_name')}</th>
                                <th >{lang('mobile_no')}</th>
                                <th class="hidden-xs" >{lang('address')}</th>                            
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{$user_details['user_name']}</td>
                                <td>{$user_details['name']}</td>
                                <td>{$user_details['sponser_name']}</td>
                                <td>{$user_details['mobile_no']}</td>
                                <td>{$user_details['address']}</td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">
                            {if $active == "yes"}
                                {form_open('admin/member/deactivate_user', 'method="post"')}
                                    <button class="btn btn-bricky"  type="submit" name="user_id" id="user_id" value="{$user_id}" tabindex="3" > {lang('deactivate')} </button>
                                {form_close()}
                            {else}
                                {form_open('admin/member/activate_user', 'method="post"')}
                                    <button class="btn btn-bricky"  type="submit" name="user_id" id="user_id" value="{$user_id}" tabindex="3" > {lang('activate')} </button>
                                {form_close()}
                            {/if}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""} 
<script>
    jQuery(document).ready(function () {
        ValidateUser.init();
    });
</script>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}