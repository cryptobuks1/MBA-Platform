{extends file=$BASE_TEMPLATE}

{block name=style}
     {$smarty.block.parent}
{/block}

{block name=script}
     {$smarty.block.parent}
     <script src="{$PUBLIC_URL}javascript/validate_board_bonus.js"></script>
{/block}

{block name=$CONTENT_BLOCK}

    <div id="span_js_messages" style="display: none;">
        <span id="you_must_enter">{lang('you_must_enter')}</span>
        <span id="board1_commission">{lang('board1_commission')|strtolower}</span>
        <span id="table1_commission">{lang('table1_commission')|strtolower}</span>
        <span id="max_5">{lang('please_enter_max_ref')}</span>
    </div>

    <div class="button_back">
        <a href="{BASE_URL}/admin/compensation_settings" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i> {lang('back')}</a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <legend>
                <span class="fieldset-legend">
                    {if $MODULE_STATUS['table_status'] eq 'no'}                
                        {lang('board_commission')}
                    {else}
                        {lang('table_commission')}
                    {/if}
                </span>
            </legend>
            {form_open('','role="form" class="" name="form_setting" id="form_setting"')}
                {include file="layout/error_box.tpl"}

                <input type="hidden" id="board_count" name="board_count" value="{$board_count}">

                {assign var="display_status" value="block"}
                {assign var="i" value="0"}
                {foreach from=$board_bonus_config item=v}
                    <div class="form-group" style="display: {$display_status};">
                        <label class="required">
                            {if $MODULE_STATUS['table_status'] eq 'no'}
                                {sprintf(lang('board1_commission'), $i + 1)}
                            {else}
                                {sprintf(lang('table1_commission'), $i + 1)}
                            {/if}
                        </label>
                        <div class="input-group {$input_group_hide}">
                            {$left_symbol}
                            <input class="form-control {if $MODULE_STATUS['table_status'] eq 'no'}board_comm{else}table_comm{/if}" type="text" name="board{$i}_commission" id="board{$i}_commission" value="{$board_bonus_config[$i]["board_commission"]}" data-level='{$i+1}'>
                            {$right_symbol}
                        </div>
                        {form_error("board{$i}_commission")}
                    </div>
                    {if $board_bonus_config[$i]["re_entry_to_next_status"] eq 'no'}
                        {$display_status = 'none'}
                    {/if}
                    {$i = $i + 1} 
                {/foreach}
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" type="submit" value="{lang('update')}" name="board_commission" id="board_commission">{lang('update')}</button>
                </div>
            {form_close()}
        </div>
    </div>

{/block}