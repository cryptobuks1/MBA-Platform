{extends file=$BASE_TEMPLATE}
{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/validate_rank_config.js" type="text/javascript" ></script>
{/block}
{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="error_msg3">{lang('you_must_enter_rank_achivers_bonus')}</span>
    <span id="error_msg5">{lang('digits_only')}</span>
    <span id="error_msg6">{lang('please_enter_max_ref')}</span>
    <span id="error_msg7">{sprintf(lang('field_must_be_greater_than_equal_0'), ucfirst(strtolower(lang('rank_achieved_bonus'))))}</span>
</div>

<div class="button_back">
    <a href="{BASE_URL}/admin/compensation_settings" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i> {lang('back')}</a>
</div>
<div class="panel panel-default">
    <div class="panel-body">
    {form_open('','role="form" class="" name="form_setting" id="form_setting"')}
    {include file="layout/error_box.tpl"}
        {foreach name = foo from=$rank_details item=v} {assign var="rank_id" value="{$v.rank_id}"}
        {* <legend><span class="fieldset-legend">{$v.rank_name}</span> *}
        </legend>
        <div class="form-group">
            <label class="required">{lang('rank_achieved_bonus')} - {$v.rank_name}</label>
            <div class="input-group">
                {$left_symbol}
                <input type="text" maxlength="5" class="level_percentage form-control" name="rank{$rank_id}" id="rank{$rank_id}" min="0" value="{number_format({$v.rank_bonus}*$DEFAULT_CURRENCY_VALUE,2)}">
                {$right_symbol}
            </div>
            {form_error("rank{$rank_id}")}
        </div>
        {* {if !$smarty.foreach.foo.last}  <div class="new_line"></div> {/if} *}
        {/foreach}
        <div class="form-group m-t-t-t">
            <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="rank_setting" id="rank_setting">{lang('update')}</button>
        </div>
    </div>
    {form_close()}
</div>
{/block}