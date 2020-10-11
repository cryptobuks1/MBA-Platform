{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display: none;">
    <span id="error_msg">{lang('you_must_enter_keyword_to_search')}</span>                  
    <span id="error_msg1">{lang('You_must_enter_user_name')}</span>        
    <span id="error_msg2">{lang('you_must_enter_your_password')}</span>        
    <span id="error_msg3">{lang('You_must_enter_your_Password_again')}</span>        
    <span id="error_msg4">{lang('You_must_enter_your_email')}</span>                  
    <span id="error_msg5">{lang('You_must_enter_your_mobile_no')}</span>
    <span id="error_msg6">{lang('mail_id_format')}</span>
    <span id="error_msg7">{lang('You_must_enter_first_name')}</span>
    <span id="error_msg8">{lang('You_must_enter_last_name')}</span>
    <span id="error_msg12">{lang('Invalid_Username')}</span>
    <span id="error_msg13">{lang('checking_username_availability')}</span>
    <span id="error_msg14">{lang('username_validated')}</span>
    <span id="error_msg15">{lang('username_already_exists')}</span>
    <span id="confirm_msg">{lang('sure_you_want_to_delete_this_feedback_there_is_no_undo')}</span>
    <span id="error_msg16">{lang('please_enter_atleast_6_characters')}</span>
    <span id="error_msg17">{lang('digits_only')}</span>
    <span id="error_msg18">{lang('alphabets_only')}</span>
    <span id="error_msg19">{lang('special_characters_are_not_allowed')}</span>
    <span id="error_msg20">{lang('please_select_a_date')}</span>
    <span id="error_msg21">{lang('please_enter_atleast_5_digits')}</span>
    <span id="error_msg22">{lang('only_alpha_space')}</span>
    <span id="error_msg23">{lang('atleast_3_char')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>

        <div class="panel panel-default">
            <div class="panel-body">
                {form_open('','role="form" class="" method="post" name="search_mem" id="search_mem"')}
                    {include file="layout/error_box.tpl"}
                        <div class="form-group">
                            <label for="keyword">{lang('keyword')} </label>
                            <input type="text" class="form-control" placeholder="{lang('Username_or_Name')}.." name="keyword" id="keyword" autocomplete="off">
                            {form_error('keyword')}
                        </div>
                        <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">
                        <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                        
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit" name="search_employee" id="search_employee" value="{lang('search_employee')}"> 
                                {lang('search')} 
                            </button>
                            <button class="btn btn-primary" name="view_all" id="view_all" value="{lang('view_all')}"> 
                                {lang('view_all')} 
                            </button>
                        </div>   
                {form_close()}
            </div>
        </div>
            
    <cdash-inner>
        <legend style="display:{$visible};">
            <span class="fieldset-legend">{lang('edit_employee')}</span>
        </legend>
        <div class="panel panel-default" style="display:{$visible};">
            <div class="panel-body">
                {form_open_multipart('', 'role="form" class="smart-wizard" method="post" id="edit_form" name="edit_form"  style="display: {$visibility}"')}
                    {include file="layout/error_box.tpl"} 
                    {foreach from=$editdetails item=v}
                        <div class="form-group">
                            <label class="control-label required" for="full_name">{lang('first_name')}</label>
                                <input  type="text" class="form-control" name="first_name" id="first_name" autocomplete="Off" value="{$v.user_detail_name}" minlength="3" tabindex="1">
                                <span id="username_box" style="display:none;"></span>
                                <span class='val-error' id="err_first_name">{form_error('first_name')}</span>
                        </div>

                        <div class="form-group">
                            <label class="control-label required" for="full_name">{lang('last_name')}</label>
                                <input  type="text" class="form-control" name="last_name" id="last_name" autocomplete="Off" value="{$v.user_detail_second_name}" minlength="3" tabindex="2">
                                <span id="username_box" style="display:none;"></span>
                                <span class='val-error' id="err_last_name">{form_error('last_name')}</span>
                        </div>

                        <div class="form-group">
                            <label class="control-label required" for="mobile">{lang('mob_no_10_digit')}</label>
                                <input name="mobile" class="form-control" id="mobile" type="text" maxlength="10" autocomplete="Off" tabindex="3" value="{$v.user_detail_mobile}">
                                <span id="username_box" style="display:none;"></span>
                                <span id="errmsg3"></span>
                                <span class='val-error' id="err_mobile">{form_error('mobile')}</span>
                        </div>

                        <div class="form-group">
                            <label class="control-label required" for="email">{lang('email')}</label>
                                <input name="email" class="form-control" id="email" type="text"  autocomplete="Off" value="{$v.user_detail_email}" tabindex="4">
                                <span id="username_box" style="display:none;"></span>
                                <span class='val-error' >{form_error('email')}</span>
                        </div>
                    {/foreach}
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" value="Update" name="update" id="update" tabindex="5">{lang('update')}</button>
                        </div>
                {form_close()}
            </div>
            </div>
    </cdash-inner>   
                
    {if $flag}
            <div class="panel panel-default ng-scope">
             <div class="panel-body">
             <div class="table-responsive">
                <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <thead>
                        <tr class="th">
                            <th>{lang('slno')}</th>
                            <th>{lang('user_name')}</th>
                            <th>{lang('first_name')}</th>
                            <th>{lang('last_name')}</th>
                            <th>{lang('mobile_no')}</th>
                            <th>{lang('email')}</th>
                            <th>{lang('action')}</th>                                
                        </tr>
                    </thead>
                    {if $count>0}
                        {assign var="i" value=0}
                        {assign var="path" value="{$BASE_URL}admin/"}
                        {assign var="class" value=""}
                        <tbody>
                            {foreach from=$emp_detail item=v}
                                {assign var="id" value="{$v.user_id}"}
                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if}
                                <tr>
                                    <td>{$v.page_no}</td>
                                    <td>{$v.user_name}</td>
                                    <td>{$v.user_detail_name}</td>
                                    <td>{$v.user_detail_second_name}</td>
                                    <td>{$v.user_detail_mobile}</td>
                                    <td>{$v.user_detail_email}</td>
                                    <td>
                                        
                                            <a href="#" onclick="search_edit_employee({$id}, '{$path}')" class="has-tooltip btn-link btn_size text-primary" data-placement="top" data-original-title="{lang('edit')}"><i class="glyphicon glyphicon-edit"></i></a>
                                            
                                        
                                            <a href="javascript:search_delete_employee({$id},'{$path}')" class="has-tooltip btn-link btn_size text-danger" data-placement="top" data-original-title="{lang('edit')}"><i class="fa fa-trash-o"></i></a>
                                            
                                    </td>
                                </tr>
                                {$i=$i+1}
                            {/foreach}
                        </tbody>
                    {else}
                        <tbody>
                            <tr><td colspan="8" align="center"><h4 align="center"> {lang('No_User_Found')}</h4></td></tr>
                        </tbody>
                    {/if}
                </table>
                 {$result_per_page}
                </div>
                </div>
               
            </div>
    {/if}

{/block}