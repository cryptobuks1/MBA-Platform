{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

<div id="span_js_messages" style="display: none;"> 
    <span id="validate_msg1">{lang('you_must_enter_user_name_length')}</span>
    <span id="validate_msg2">{lang('user_name_length_should_be')}</span>
    <span id="validate_msg3">{lang('you_must_enter_user_name_prefix')}</span>
    <span id="validate_msg4">{lang('invalid_user_name_prefix')}</span>  
    <span id="user_name_config">{$username_config['prefix']}</span>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            {$j = 0}
            {foreach $board_config as $values}
                <div class="panel-heading">
                    <i class="fa fa-external-link-square"></i>{$values['board_name']}
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

                    {form_open('', 'role="form" class="" method="post"  name="board_config_form" id="board_config_form_{$j}"')}
                        <div class="col-md-12">
                            <div class="errorHandler alert alert-danger no-display">
                                <i class="fa fa-times-sign"></i> {lang('errors_check')}
                            </div>
                        </div>

                        <input type="hidden" id="path_root" name="path_root" value="{$PATH_TO_ROOT_DOMAIN}">
                        <input type="hidden" id="board_id" name="board_id" value="{$values['board_id']}">

                        <table>

                            <tr id="user_type_div">

                                <td width="200">{lang('board_view_depth')}:</td>
                                <td><input tabindex="2" type="text" name ="depth{$j}" id ="depth" value="{$values['board_depth']}" title="{lang('user_length_title')}"><span id="errmsg1"></span></td>
                            </tr>
                            <tr id="user_type_div" >

                                <td width="200">{lang('board_view_width')}:</td>
                                <td><input tabindex="2" type="text" name ="width{$j}" id ="width" value="{$values['board_width']}" title="{lang('user_length_title')}"><span id="errmsg1"></span></td>
                            </tr>
                            <tr id="user_type_div" >
                                <td width="200">{lang('board_view_amount')}:</td>
                                <td><input tabindex="2" type="text" name ="amount{$j}" id ="amount" value="{$values['amount']}" title="{lang('user_length_title')}"><span id="errmsg1"></span></td>
                            </tr>

                            <tr id="prefix_div"  style="display:none;"> </tr>

                            <tr>
                            <tr>
                                <td></td>
                                <td>

                                    <button class="btn btn-bricky" tabindex="4"   type="submit" value="{lang('update')}" name="update{$j}" id="update" > {lang('update')}</button>

                                </td></tr>
                            </tr>
                        </table>
                    {form_close()}
                </div>
                {$j = $j+1}          
            {/foreach}
        </div>
    </div>
</div>
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}  
