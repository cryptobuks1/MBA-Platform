{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div class="panel panel-default table-responsive">
        {form_open('', 'name="language_settings_form" id="module_status_form" class="" method="post"')}
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead>
                <tr class="th" align="center">
                    <th>{lang('sl_no')}</th>
                    <th>{lang('language')}</th>
                    <th>{lang('action')}</th>
                    <th>{lang('default_language')}</th>
                </tr>
            </thead>
            <tbody>
                {foreach from=$language_array item=v}
                    <tr>
                        <td>{counter}</td> 
                        <td class="flag_width">
                            <img src="{$PUBLIC_URL}images/flags/{$v.lang_code}.png"/> 
                            {$v.lang_name}
                        </td>
                        <td class="text-left text-left-one"><label class="i-switch i-switch_btn">
                            <input type="checkbox" type="checkbox" name="module_status" id="set_eng_status"  value="yes" {if $v.status=="no"} onChange="change_language_status('{$v.lang_id}', 'yes')" {else} checked onChange="change_language_status('{$v.lang_id}', 'no')"{/if} class="switch-input menu_status">
                            <i></i> </label></td>
                   
 
                        <td>
                            <div class="visible-md visible-lg hidden-sm hidden-xs">
                                <!--Default Language start-->  
                                {if $v.status=="yes"}
                                    {if $v.default_id}
                                        <a href="javascript:void();" class="btn-link h4 text-primary" data-placement="top" title="Default" style="cursor: default;">
                                            <i class="glyphicon glyphicon-ok-circle"></i>
                                        </a>
                                    {else}
                                        <a href="javascript:set_default_language({$v.lang_id})" class="btn-link h4 text-primary" data-placement="top" title="Set {$v.lang_name} as default">
                                            <i class="glyphicon glyphicon-remove-circle"></i>
                                        </a>
                                        <span id="{$v.lang_id}_message"></span>
                                    {/if}
                                {else}
                                    <a href="javascript:void();" class="btn-link h4 text-primary" data-placement="top" title="Not Available" style="cursor: default;" >
                                        <i class="glyphicon glyphicon-ban-circle"></i>
                                    </a>
                                {/if}                                            
                            </div>
                        </td>
                    </tr>
                {/foreach}
            </tbody>   
        </table>
    </div>
{/block}