{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display: none;">
    <span id="error_msg">{lang('please_select_at_least_one_checkbox')}</span>
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
    <span id="show_msg1">{lang('are_you_sure_you_want_to_Delete_There_is_NO_undo')}</span>
    <span id="show_msg2">{lang('digits_only')}</span>
    <span id="err_msg1">{lang('main_password_required')}</span>
    <span id="err_msg2">{lang('second_password_required')}</span>
    <span id="err_msg3">{lang('wallet_id_required')}</span>
    <span id="err_msg4">{lang('passphrase_required')}</span>
    <span id="err_msg5">{lang('wallet_name_required')}</span>
    <span id="err_msg6">{lang('wallet_password_required')}</span>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">                           
            <div class="panel-body">
                {if count($requests)>0}   
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-full-width table-bordered" id="">
                        <thead class="table-bordered">
                            <tr class="th"> 
                                <th>{lang('sl_no')}</th>
                                <th>{lang('user_name')}</th>
                                <th>{lang('date_of_request')}</th>
                                <th>{lang('action')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {assign var="i" value=0}
                            {assign var="class" value=""}
                            {foreach from=$requests item="v"}
                                {if $i%2==0}
                                    {$class='tr1'}
                                {else}
                                    {$class='tr2'}
                                {/if} 
                                {form_open('', 'name="ewallet_form_det" method="post"')}
                            <input type='hidden' name='user_id' value = '{$v.user_id}'>
                            <input type='hidden' name='id' value = '{$v.id}'>                                        
                            <tr class="{$class}">
                                <td>{counter}</td>
                                <td>{$v.user_name}</td>
                                <td>{$v.request_date}</td>
                                <td style="text-align: center;">
                                    <button class="btn-link btn_size has-tooltip text-info" name="forget" id="forget" type="submit" title="{lang('forget')}"><i class="icon-check"></i></button>
                                    <button class="btn-link btn_size has-tooltip text-info" name="reject" id="reject" type="submit" title="{lang('cancel')}"><i class="icon-ban"></i></button>
                                </td>
                            </tr>
                            {form_close()}
                            {$i=$i+1}
                        {/foreach}                
                        </tbody>    
                    </table> 
                    </div>
                    {$result_per_page}  
                {else}
                    <h4 align="center">{lang('no_request_found')}</h4>          
                {/if} 
                {include file="common/notes.tpl" notes=lang('note_forget_user')}
            </div>
        </div>      
    </div>
</div>
{/block}

{block name=script}
	{$smarty.block.parent}	
    <script>
        jQuery(document).ready(function () {
            Main.init();
            TableData.init();
        });
    </script>
{/block}