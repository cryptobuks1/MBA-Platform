{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg8">{lang('You_must_enter_user_name')}</span>
</div>

        <div class="panel panel-default">
            <div class="panel-body">
                {form_open('','role="form" class="" id="reset_button" name="reset_button" method="post"')}
                    {include file="layout/error_box.tpl"}
                        <div class="col-sm-3 padding_both">
                            <div class="form-group">
                                <label class="control-label required" for="user_name">{lang('user_name')}</label>
                                <input class="form-control user_autolist" type="text" id="user_name" name="user_name" value="" autocomplete="Off" >
                                {form_error('user_name')}
                            </div>
                        </div>
                        
                        <div class="col-sm-3 padding_both_small">
                            <div class="form-group mark_paid">
                                <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}admin/">                                       
                                <button class="btn btn-sm btn-primary" type="submit" name="reset_button"  id="reset_button" value="{lang('change_password')}">{lang('Reset')}</button>
                                <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                            </div>
                        </div>
                {form_close()}
            </div>
        </div>

{/block}

{block name=script}
  {$smarty.block.parent}
    <script>
        jQuery(document).ready(function() {
            ValidateUser.init();
        });
    </script>
{/block}