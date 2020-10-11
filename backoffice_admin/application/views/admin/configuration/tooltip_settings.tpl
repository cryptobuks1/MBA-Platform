{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

{include file="admin/configuration/system_setting_common.tpl"}


{form_open('', 'role="form" class="" method="post" name="tooltip_settings" id="tooltip_settings"')}
    <div class="panel panel-default table-responsive">
    <div class="panel-body">
    <legend>
    <span class="fieldset-legend">
        {lang('tooltip_settings')}
    </span>
</legend>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>{lang('sl_no')}</th>
                    <th>{lang('label')}</th>
                    <th width="20%">{lang('check/uncheck')}</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$tooltip item=v}
                    <tr>
                        <td>{counter}</td>
                        <td>{lang($v.label)}</td>
                        <td class="payment_width_td">
                            <div class="checkbox">
                                <label class="i-checks i-checks-sm">
                                    <input type="checkbox" name="{$v.id}" id="inlineCheckbox1-{$v.id}" {if $v.status=='yes'} checked {/if} value="{$v.id}" id="{$v.id}"><i></i>
                                </label>
                            </div>
                        </td>
                    </tr>
                {/foreach}
            </tbody>
        </table>
         <button class="btn btn-sm btn-primary" name="update" type="submit" value="update">{lang('update')}</button>
        </dvi>
    </div>
     
{form_close()}

{/block}
