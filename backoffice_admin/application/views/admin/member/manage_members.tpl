{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
<div id="span_js_messages" style="display: none;">
    <span id="errmsg">{lang('you_must_enter_username')}</span>
</div>
    <div class="panel panel-default">
    <div class="panel-body">
       
        {form_open('admin/member/manage_members','role="form" class="" method="post" name="manage_members" id="manage_members"')} {include file="layout/error_box.tpl"}
        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required" for="week_date1">{lang('user_name')}</label> 
                <input class="form-control user_autolist" maxlength="25" name="user_name" id="user_name" type="text" value="" >                {form_error('user_name')}
            </div>   
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group credit_debit_button">   
                    <button class="btn btn-primary" name="manage_members" type="submit" value="{lang('submit')}"> {lang('submit')}</button>
            </div>
        </div>
        {form_close()}
      
    </div>
    </div>
      
       <div class="panel panel-default">
    <div class="panel-body">
    <input type="hidden" id="details" value='{json_encode($user_detail_arr)}'>
{if count($user_detail_arr)} 
    <div class="">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr class="th">
                    <th>{lang('sl_no')}</th>
                    <th>{lang('member')}</th>
                    <th>{lang('parent')}</th>
                    <th>{lang('sponser_name')}</th>
                    <th>{lang('rank')}</th>
                    <th>{lang('registered_on')}</th>
                    <th>{lang('view_profile')}</th>
                </tr>
            </thead>
            <tbody>
                {assign var="i" value=1}
               {foreach from = $user_detail_arr key = k item = v}
                    <tr>
                        <td>{$page + $i}</td>
                        <td>{$v['username']}
                        {if ($v['status']) == 'yes'}
                        <b  class="badge label-primary-1">{lang('active')}</b>   
                        {else}
                        <b  class="badge label-primary-2">{lang('inactive')}</b>    
                        {/if}    
                        </td>
                        {if !empty($v['Parent'])}
                         <td>{$v['Parent']}</td>
                        {else}
                         <td>NA</td>   
                        {/if}
                        {if !empty($v['sponsor'])}
                        <td>{$v['sponsor']}</td>
                        {else}
                         <td>NA</td>   
                        {/if}
                        {if !empty($v['rank'])}
                        <td><span class="rank_color_code">{$v['rank']}</span></td>
                        {else}
                        <td><span class="rank_color_code">{lang('na')}</span></td>
                        {/if}
                        <td>{$v['joining_date']}</td>
                        <td><a href="{$PATH_TO_ROOT_DOMAIN}admin/profile/profile_view/{$v['encrypt_id']}" title="View" class="btn-link  text-primary">
                        <i class="glyphicon glyphicon-camera"></i> </a>
                        </td>
                    </tr>
                    {$i = $i + 1}
                {/foreach}
            </tbody>
        </table>
       <br>{$result_per_page}    
       
        </div>
           {else}
           <h4 class="text-center">{lang('no_data')}</h4>
           {/if}                                      
    </div>
</div>   
{/block}
{block name=script}
    <script>
        jQuery(document).ready(function () {
            ValidateManageMembers.init();
        });
    </script>
{/block}    
    