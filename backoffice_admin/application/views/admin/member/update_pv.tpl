{extends file=$BASE_TEMPLATE}
{block name=$CONTENT_BLOCK}
    
<div id="span_js_messages" style="display:none;">
    <span id="error_msg">{lang('you_must_enter_pv_value')}</span>
    <span id="error_msg1">{lang('digits_only')}</span>
    <span id="error_msg2">{lang('please_enter_no_more_than_5_digits')}</span>
    <span id="error_msg3">{lang('pv_should_be_greater_than_zero')}</span>
</div>

    <input type="hidden" id="controller_name" value="{$CURRENT_CTRL}">
    <input type="hidden" id="search_member_error" value="{lang('search_member_error')}"/>
    <input type="hidden" id="search_member_error2" value="{lang('invalid_user_name')}"/>
        <div class="panel panel-default">
            <div class="panel-body">
                {form_open('','role="form"  method="post"  name="search_member" id="search_member"')}
                    <div class="col-sm-3 padding_both">
                        <div class="form-group">
                            <label class="required" for="user_name">{lang('user_name')}</label>
                                <input type="text" class="form-control user_autolist" name="user_name" id="user_name" autocomplete="Off">
                                <span id="username_box" style="display:none;"></span>
                                {form_error('user_name')}
                        </div>
                    </div>
                    <div class="col-sm-2 padding_both_small">
                        <div class="form-group mark_paid">
                            <button type="submit" class="btn btn-sm btn-primary" name="user_name_submit" id="user_name_submit" value="{lang('view_username')}">
                                {lang('search')}
                            </button>
                        </div>
                    </div>       
                {form_close()}
            </div> 
        </div>
    {if $user_name_submit}
    {form_open('admin/update_pv_submit','role="form"  method="post"  name="update_pv" id="update_pv"')}
    <input type="hidden" name="user_name" id="user_name" value="{$user_name}">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="clearfix"> 
                        <div class="clear">
                            <small class="text-muted">{$user_name}{lang("'s")} {lang('details')}</small> 
                        </div>
                    </div>
                </div>
                <div class="list-group no-radius alt">
                    <div class="list-group-item" href="">{lang('Rank')}: <span class="label bg-primary m-l-sm ">{$rank_details['rank_name']}</span></div>
                    <div class="list-group-item" href="">{lang('personal_pv')}: <span class="label bg-primary m-l-sm ">{$personal_pv}</span></div>
                    <div class="list-group-item" href="">{lang('group_pv')}: <span class="label bg-primary m-l-sm ">{$group_pv}</span></div>
                    <div class="list-group-item" href="">{lang('enter_pv')} <input class="form-control"  type="text" name ="new_pv" id ="new_pv" autocomplete="Off"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group">
       <button class="btn btn-primary" name="add_pv" id="add_pv"  type="submit" value="{lang('add_pv')}">{lang('add_pv')}</button>
       <button class="btn btn-primary" name="deduct_pv" id="deduct_pv" type="submit" value="{lang('deduct_pv')}" > {lang('deduct_pv')}</button>
    </div>
    {form_close()}
    {/if}
{/block}
{block name='script'}
    <script src="{$PUBLIC_URL}/javascript/main.js"></script>
    <script src="{$PUBLIC_URL}/javascript/validate_pv_update.js"></script>
    <script>
        $(function(){
            ValidateSearchMember.init();
        });
    </script>
{/block}