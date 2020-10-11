{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}

<link rel="stylesheet" type="text/css" href="{$PUBLIC_URL}chart_new/adminlte_one.css">
<style type="text/css">
    form:not(.smart-wizard) {
        display: inline-block;
    }

    form {
         display: inline;
        }
        .panel-body .col-sm-3 {
    min-height: 0px;
}
.table tr>td .progress {
    width: 90%;
    margin: 0 10px;
}
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{if $MODULE_STATUS['hyip_status'] == 'yes'  && $MLM_PLAN == 'Unilevel'}{lang('total_deposit')}{else}{lang('Hyip')}{/if}
            <div  class="panel-tools">
                <a href="{BASE_URL}/user/home/index" class="btn btn-sm btn-primary" tabindex="4"><i class="fa fa-external-link"></i> {lang('back')}</a>  
            </div>
            </div> 
            <div class="panel-body">
                <span  style="font-size: initial;float:right;margin-right: 10px;">{lang('total')} {$DEFAULT_SYMBOL_LEFT}{number_format($total_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT} </span>{if $page_id}<br>{else}<br><br>{/if}
                <div class="row" style="margin-top: 15px;">
                    <div class="col-sm-12">
                        <table class="table table-striped table-hover table-full-width table-bordered" id="">
                            <thead>
                                <tr>
                                    <th>{lang('sl_no')}</th>
                                    <th>{lang('package')}</th> 
                                    <th>{lang('date_of_submission')}</th> 
                                    <th>{lang('Hyip')}</th>  
                                </tr>
                            </thead>
                            {if $details_count>0}
                            <tbody>
                           {assign var=color value=['progress-bar-aqua','progress-bar-red','progress-bar-green','progress-bar-yellow']}
                                {$i = 0}
                                {foreach from=$roi_details item=v}
                                    {assign var="package" value="{$v.package}"}
                                    <tr>
                                        <td>{$i + $page_id + 1}</td>      
                                        <td>{$v.package}</td>
                                        <td>{date('Y/m/d', strtotime($v.date_of_submission))}</td>
                                        <td>{$DEFAULT_SYMBOL_LEFT}{number_format($v.amount_payable*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                    </tr>
                                    {$i = $i + 1}
                                {/foreach}
                                <tr>
                                   <td colspan="3" style="font-size: initial; text-align:right" class="" ><span style="margin-right: 10px;">{lang('available_amount')}</span></td>
                                   <td style="font-size: initial;">{$DEFAULT_SYMBOL_LEFT}{number_format($v.tot_amount*$DEFAULT_CURRENCY_VALUE,$PRECISION)}{$DEFAULT_SYMBOL_RIGHT}</td>
                                </tr>
                            </tbody>
                            {else}
                            <tbody>
                                   <tr id="tr-empty"><td align="center" colspan="4"><h4 align="center">{lang('no_data_found')}</h4></td></tr>
                            </tbody>
                            {/if}
                        </table> 
                        {$result_per_page} 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{include file="user/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}   

