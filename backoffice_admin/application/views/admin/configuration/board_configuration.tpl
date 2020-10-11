{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
<div id="span_js_messages" style="display:none;">

    <span id="error_msg1">{lang('digits_only')}</span>
   
</div> 
{if $edit_id}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
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
                {lang('board_settings')}
            </div>
            <div class="panel-body">
                {form_open('', 'role="form" class="" method="post"  name="board_form" id="board_form"')}
                    <div class="col-md-12">
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> {lang('errors_check')}
                        </div>
                    </div>                       
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="board_width">{lang('board_width')}<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input  type="text"  name="board_width" id="board_width"  value="{$board_width}" tabindex="1"><span id="errmsg1"></span> {form_error('board_width')}
                            

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="board_depth">{lang('board_depth')}<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input  type="text"   name="board_depth" id="board_depth"  autocomplete="Off" tabindex="2" value="{$board_depth}" ><span id="errmsg2"></span> {form_error('board_depth')}

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="board_name">{lang('board_name')}<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input  type="text"   name="board_name" id="board_name"  autocomplete="Off" tabindex="3" value="{$board_name}" >{form_error('board_name')}

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="board_commission">{lang('board_commission')}<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input  type="text"   name="board_commission" id="board_commission"  autocomplete="Off" tabindex="4" value="{$board_commission}" ><span id="errmsg3"></span>{form_error('board_commission')}

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="sponser_follow_status">{lang('sponser_follow_status')}<span class="symbol required"></span></label>
                        <div class="col-sm-6">

                            <input  type="radio"   name="sponser_follow_status" id="sponser_follow_status_yes"  autocomplete="Off" tabindex="5"{if $sponser_follow_status =='yes'} checked=''{/if} value="yes"><label for="sponser_follow_status"> {lang('yes')} &nbsp;</label>
                            <input  type="radio"   name="sponser_follow_status" id="sponser_follow_status_no"  autocomplete="Off" tabindex="6"{if $sponser_follow_status =='no'}checked=''{/if}value="no" ><label for="sponser_follow_status"> {lang('no')} </label> {form_error('sponser_follow_status')}                                        
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="re_entry_status">{lang('re_entry_status')}<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input  type="radio"   name="re_entry_status" id="re_entry_status_yes"  autocomplete="Off" tabindex="7" {if $re_entry_status =='yes'} checked=''{/if} value="yes" ><label for="re_entry_status"> {lang('yes')} &nbsp;</label>
                            <input  type="radio"   name="re_entry_status" id="re_entry_status_no"  autocomplete="Off" tabindex="8"  {if $re_entry_status =='no'} checked=''{/if} value="no"><label for="re_entry_status"> {lang('no')} </label>{form_error('re_entry_status')}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="re_entry_to_next_status">{lang('re_entry_to_next_status')}<span class="symbol required"></span></label>
                        <div class="col-sm-6">
                            <input  type="radio"   name="re_entry_to_next_status" id="re_entry_status_yes" {if $re_entry_to_next_status =='yes'} checked=''{/if}tabindex="9" value="yes" ><label for="re_entry_to_next_status"> {lang('yes')} &nbsp;</label>
                            <input  type="radio"   name="re_entry_to_next_status" id="re_entry_status_no"  {if $re_entry_to_next_status =='no'} checked=''{/if}tabindex="10" value="no" ><label for="re_entry_to_next_status"> {lang('no')} </label>{form_error('re_entry_to_next_status')}
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-2 col-sm-offset-2">

                            <button class="btn btn-bricky" tabindex="3" name="board_update" type="submit" value="Update" font-weight:bold;">{lang('update')}</button>
                        </div>
                        <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                    </div>
                {form_close()}
            </div>
        </div>
    </div>
</div>
  {/if}
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('board_details')}
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

                {assign var=i value="0"}

                {assign var=class value=""}

                <table class="table table-striped table-bordered table-hover table-full-width" id="">
                    <thead>
                        <tr class="th" align="center">
                            <th>{lang('board_id')}</th>                        
                            <th>{lang('board_width')}</th>
                            <th>{lang('board_depth')}</th>
                            <th>{lang('board_name')}</th>
                            <th>{lang('board_commission')}</th>
                            <th>{lang('sponser_follow_status')}</th>
                            <th>{lang('re_entry_status')}</th>
                            <th>{lang('re_entry_to_next_status')}</th>
                            <th>{lang('edit')}</th>
                        </tr>
                    </thead>
                    {if $count>0}
                        <tbody>
                            {assign var="path" value="{$BASE_URL}admin/"}
                            {foreach from=$board_details item=v}
                                {assign var="board_id" value="{$v.board_id}"}

                                {if $i%2 == 0}
                                    {$class="tr2"}
                                {else}
                                    {$class="tr1"}
                                {/if}		
                                {$i = $i+1}

                                <tr class="{$class}" align="center" >                                  
                                    <td>{$v.board_id}</td>
                                    <td>{$v.board_width}</td>
                                    <td>{$v.board_depth}</td>
                                    <td>{$v.board_name}</td>
                                    <td>{$v.board_commission}</td>
                                    <td>{$v.sponser_follow_status}</td>
                                    <td>{$v.re_entry_status}</td>
                                    <td>{$v.re_entry_to_next_status}</td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs">
                                            <a href="javascript:edit_board({$v.board_id},'{$path}')" class="btn btn-teal tooltips" data-placement="top" data-original-title="Edit {$v.board_id}"><i class="fa fa-edit"></i></a>  
                                        </div>

                                        <div class="visible-xs visible-sm hidden-md hidden-lg">
                                            <div class="btn-group">
                                                <a class="btn btn-primary dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
                                                    <i class="fa fa-cog"></i> <span class="caret"></span>
                                                </a>
                                                <ul role="menu" class="dropdown-menu pull-right">

                                                    <li role="presentation">
                                                        <a role="menuitem" tabindex="1" href="javascript:edit_board({$v.board_id},'{$path}')">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>

                                    </td>
                                {/foreach}                
                        </tbody>
                    {else}
                        <tbody>
                            <tr><td colspan="8" align="center"><h4 align="center"> {lang('No_Board_Details_Found')}</h4></td></tr>
                        </tbody>                            
                    {/if}  
                </table>

            </div>
        </div>
    </div>
</div>     



{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}