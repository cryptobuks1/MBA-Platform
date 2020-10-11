{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

<div id="span_js_messages" style="display:none;">
    <span id="confirm_msg_edit">{lang('are_you_sure_you_want_to_updt_There_is_NO_undo')}</span>
</div>

{include file="admin/configuration/system_setting_common.tpl"}

<div class="m-b">
{include file="common/notes.tpl" notes=lang('note_logout_setting')}
</div>

<div class="panel panel-default">
    <div class="panel-body">
    <legend>
    <span class="fieldset-legend">
        {lang('logout')}
    </span>
</legend>
        {form_open('', 'role="form" class="" method="post" name="upload_materials" id="upload_materials1"')}
            {include file="layout/error_box.tpl"}
            <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required">{lang('select_logout_time')}</label>
                <div class="">
                    <select type="text" class="form-control m-b" name="logout_time" id="logout_time">
                        <option {if $prev_time eq "180"} selected {/if} value="180">{180}</option>
                        <option {if $prev_time eq "240"} selected {/if} value="240">{240}</option>
                        <option {if $prev_time eq "300"} selected {/if} value="300">{300}</option>
                        <option {if $prev_time eq "600"} selected {/if} value="600">{600}</option>
                        <option {if $prev_time eq "900"} selected {/if} value="900">{900}</option>
                        <option {if $prev_time eq "1200"} selected {/if} value="1200">{1200}</option>
                        <option {if $prev_time eq "1500"} selected {/if} value="1500">{1500}</option>
                        <option {if $prev_time eq "1800"} selected {/if} value="1800">{1800}</option>
                    </select>
                </div>
                <p class="">{lang('time_in_seconds')} </p>
            </div>
            </div>
            <div class="col-sm-3 padding_both_small">
            <div class="form-group mark_paid">
            <button class="btn btn-sm btn-primary" name="submit" type="submit" value="submit">{lang('update')}</button>
            
            {form_error('logout_time')}
        {form_close()}
        </div>
        </div>
    </div>
</div>

 

{/block}