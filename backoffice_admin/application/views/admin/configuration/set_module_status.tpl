{extends file=$BASE_TEMPLATE}

{block name=style}
    {$smarty.block.parent}
    <style>
        .table>tbody>tr>th, .table>tfoot>tr>th, .table>tbody>tr>td, .table>tfoot>tr>td {
            text-align: left;
        }
        td {
            border-top: 1px solid #fff !important;
            border-bottom: 1px solid #fff;
        }
    </style>
{/block}

{block name=script}
    {$smarty.block.parent}
    <script>
        function change_module_status(path_temp, path_root, module_name, module_status)
        {
            var set_module_status = path_root + "configuration/change_module_status";
            {* var msg = $("#load_msg").html();
            $("#" + module_name).removeClass();
            $("#" + module_name).addClass('messagebox');
            $("#" + module_name).html('<img align="absmiddle" src="' + path_temp + 'images/loader.gif" />' + msg).show().fadeTo(1900, 1); *}
            $.post(set_module_status, { module_name: module_name, module_status: module_status }, function (data)
            {
                location.reload();
            });
        }
    </script>
{/block}

{block name=$CONTENT_BLOCK}
    <style type="">
        .table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
            text-align: left!important;
        }
        .table-striped > tbody > tr:nth-child(2n) > td,.table-striped > tbody > tr:nth-child(2n) > th{
            text-align: left!important;
        }
        tbody {
            text-align: left;
        }
    </style>
    <div id="span_js_messages" style="display:none;">
        <span id="load_msg">{lang('loading')}</span>
    </div> 
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    {form_open('','name="module_status_form" id="module_status_form"')}    
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                    <div class="table-responsive">
                    <table class="table" id="">
                        <thead>
                            <tr class="no_bg_clr">
                                <th>{lang('Module Name')}</th>
                                <th> {lang('Status')}</th>
                                <th> {lang('configuration')}</th>
                            </tr>
                        </thead>
                        <tbody>
                            {if $MODULE_STATUS['pin_status_demo']=='yes'}
                                <tr>
                                    <td>{lang('epin')} </td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_pin_status" value="yes" {if $MODULE_STATUS['pin_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'pin_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'pin_status', 'no')" {/if} >                             
                                            <i></i>
                                        </label>
                                        <span id="pin_status" style="display:none;"></span>
                                    </td>
                                    <td>
                                        {if $MODULE_STATUS['pin_status']=='yes'}
                                            <a class="btn btn-sm btn-icon btn-rounded btn-default" href="{$PATH_TO_ROOT_DOMAIN}admin/pin_config"><i class="fa fa-cog"></i></a>
                                        {/if}
                                    </td>
                                </tr>
                            {/if}
                            {if $MODULE_STATUS['opencart_status']=='no'}
                                <tr>
                                    <td>{lang('package')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_product_status" value="yes" {if $MODULE_STATUS['product_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'product_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'product_status', 'no')" {/if}>    
                                            <i></i>
                                        </label>
                                        <span id="product_status" style="display:none;"></span>
                                    </td>
                                    <td>
                                        {if $MODULE_STATUS['product_status']=='yes'}
                                            <a class="btn btn-sm btn-icon btn-rounded btn-default" href="{$PATH_TO_ROOT_DOMAIN}admin/membership_package"><i class="fa fa-cog"></i></a>
                                        {/if}
                                    </td>
                                </tr>
                            {/if}
                            {if $MODULE_STATUS['opencart_status_demo']=="yes"}
                                <tr>
                                    <td>{lang('store')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_opencart_status" value="yes" {if $MODULE_STATUS['opencart_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'opencart_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'opencart_status', 'no')" {/if} >    
                                            <i></i>                         
                                        </label>
                                        <span id="opencart_status" style="display:none;"></span>
                                    </td>
                                </tr>
                            {/if}
                            {if $MLM_PLAN != 'Unilevel'}
                                <tr>
                                    <td>{lang('sponsor_tree')}</td> 
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_sponsor_tree_status" value="yes" {if $MODULE_STATUS['sponsor_tree_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'sponsor_tree_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'sponsor_tree_status', 'no')" {/if} >  
                                            <i></i>                           
                                        </label>
                                        <span id="sponsor_tree_status" style="display:none;"></span>
                                    </td>
                                    <td>
                                        {if $MODULE_STATUS['sponsor_tree_status']=='yes'}
                                            <a class="btn btn-sm btn-icon btn-rounded btn-default" href="{$PATH_TO_ROOT_DOMAIN}admin/tree/sponsor_tree"><i class="fa fa-cog"></i></a>
                                        {/if}
                                    </td>
                                </tr>
                            {/if}
                            {if $MLM_PLAN != 'Unilevel' && $MLM_PLAN != 'Matrix' && $MLM_PLAN != 'Donation'}
                                <tr>
                                    <td>{lang('unilevel_commission')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_sponsor_commission_status" value="yes" {if $MODULE_STATUS['sponsor_commission_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'sponsor_commission_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'sponsor_commission_status', 'no')" {/if} >  
                                            <i></i>                           
                                        </label>
                                        <span id="sponsor_commission_status" style="display:none;"></span>
                                    </td>
                                    <td>
                                        {if $MODULE_STATUS['sponsor_commission_status']=='yes'}
                                            <a class="btn btn-sm btn-icon btn-rounded btn-default" href="{$PATH_TO_ROOT_DOMAIN}admin/configuration/configuration_view/level"><i class="fa fa-cog"></i></a>  
                                        {/if}
                                    </td>
                                </tr>
                            {/if}
                            <tr>
                                <td>{lang('rank')}</td>
                                <td>   
                                    <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                        <input type="checkbox" name="set_module_status" id="set_rank_status" value="yes" {if $MODULE_STATUS['rank_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'rank_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'rank_status', 'no')" {/if} >     
                                        <i></i>                        
                                    </label>
                                    <span id="rank_status" style="display:none;"></span>
                                </td>
                                <td>
                                    {if $MODULE_STATUS['rank_status']=='yes'}
                                        <a class="btn btn-sm btn-icon btn-rounded btn-default" href="{$PATH_TO_ROOT_DOMAIN}admin/rank_configuration"><i class="fa fa-cog"></i></a>
                                    {/if}
                                </td>
                            </tr>
                            {if $MODULE_STATUS['lang_status_demo']=='yes'}
                                <tr>
                                    <td>{lang('multi_language')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_lang_status" value="yes" {if $MODULE_STATUS['lang_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'lang_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'lang_status', 'no')" {/if} >    
                                            <i></i>                         
                                        </label>
                                        <span id="lang_status" style="display:none;"></span>
                                    </td>
                                    <td>
                                        {if $MODULE_STATUS['lang_status']=='yes'}
                                            <a class="btn btn-sm btn-icon btn-rounded btn-default" href="{$PATH_TO_ROOT_DOMAIN}admin/language_settings"><i class="fa fa-cog"></i></a>  
                                        {/if}
                                    </td>
                                </tr>
                            {/if}
                            {if $MODULE_STATUS['multy_currency_status_demo']=='yes'}
                                <tr>
                                    <td>{lang('MultiCurrency')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_sponsor_commission_status" value="yes" {if $MODULE_STATUS['multy_currency_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'multy_currency_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'multy_currency_status', 'no')" {/if} >                             
                                            <i></i>
                                        </label>
                                        <span id="multy_currency_status" style="display:none;"></span>
                                    </td>
                                    <td>
                                        {if $MODULE_STATUS['multy_currency_status']=='yes'}
                                            <a class="btn btn-sm btn-icon btn-rounded btn-default" href="{$PATH_TO_ROOT_DOMAIN}admin/currency_management"><i class="fa fa-cog"></i></a>  
                                        {/if}
                                    </td>
                                </tr>
                            {/if}
                            {if $MODULE_STATUS['lead_capture_status_demo']=='yes'}
                                <tr>
                                    <td>{lang('Lead_Capture_Status')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_footer_demo_status" value="yes" {if $MODULE_STATUS['lead_capture_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'lead_capture_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'lead_capture_status', 'no')" {/if} >                             
                                            <i></i>
                                        </label>
                                        <span id="lead_capture_status" style="display:none;"></span>
                                    </td>
                                </tr>
                            {/if}
                            {if $MODULE_STATUS['ticket_system_status_demo']=='yes'}
                                <tr>
                                    <td>{lang('Ticket_System_Status')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_footer_demo_status" value="yes" {if $MODULE_STATUS['ticket_system_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'ticket_system_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'ticket_system_status', 'no')" {/if} >                             
                                            <i></i>
                                        </label>
                                        <span id="ticket_system_status" style="display:none;"></span>
                                    </td>
                                </tr>
                            {/if}
                            {if $MODULE_STATUS['autoresponder_status_demo']=='yes'}
                                <tr>
                                    <td>{lang('AutoResponder_Status')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_sponsor_commission_status" value="yes" {if $MODULE_STATUS['autoresponder_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'autoresponder_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'autoresponder_status', 'no')" {/if} >                             
                                            <i></i>
                                        </label>
                                        <span id="autoresponder_status" style="display:none;"></span>
                                    </td>
                                    <td>
                                        {if $MODULE_STATUS['autoresponder_status']=='yes'}
                                            <a class="btn btn-sm btn-icon btn-rounded btn-default" href="{$PATH_TO_ROOT_DOMAIN}admin/auto_responder_settings"><i class="fa fa-cog"></i></a>
                                        {/if}
                                    </td>
                                </tr>
                            {/if}
                            {if $MODULE_STATUS['replicated_site_status_demo']=='yes'}
                                <tr>
                                    <td>{lang('Replicated_Site_Status')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_replicated_site_status" value="yes" {if $MODULE_STATUS['replicated_site_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'replicated_site_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'replicated_site_status', 'no')" {/if} >                         
                                            <i></i>    
                                        </label>
                                        <span id="replicated_site_status" style="display:none;"></span>
                                    </td>
                                </tr>
                            {/if}
                            {if $MODULE_STATUS['employee_status_demo']=='yes'}
                                <tr>
                                    <td>{lang('privileged_user')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_employee_status" value="yes" {if $MODULE_STATUS['employee_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'employee_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'employee_status', 'no')" {/if} >     
                                            <i></i>                        
                                        </label>
                                        <span id="employee_status" style="display:none;"></span>
                                    </td>
                                    <td>
                                        {if $MODULE_STATUS['employee_status']=='yes'}
                                            <a class="btn btn-sm btn-icon btn-rounded btn-default" href="{$PATH_TO_ROOT_DOMAIN}admin/employee_register"><i class="fa fa-cog"></i></a>
                                        {/if}
                                    </td>
                                </tr>
                            {/if}
                            {if $MODULE_STATUS['sms_status_demo']=='yes'}
                                <tr>
                                    <td>{lang('sms')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_sms_status" value="yes" {if $MODULE_STATUS['sms_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'sms_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'sms_status', 'no')" {/if} >                             
                                            <i></i>
                                        </label>
                                        <span id="sms_status" style="display:none;"></span>
                                    </td>
                                    <td>
                                        {if $MODULE_STATUS['sms_status']=='yes'}
                                            <a class="btn btn-sm btn-icon btn-rounded btn-default" href="{$PATH_TO_ROOT_DOMAIN}admin/sms_settings"><i class="fa fa-cog"></i></a>
                                        {/if}
                                    </td>
                                </tr>
                            {/if}
                            <tr>
                                <td>{lang('upload_document')}</td>
                                <td>   
                                    <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                        <input type="checkbox" name="set_module_status" id="set_upload_status" value="yes" {if $MODULE_STATUS['upload_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'upload_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'upload_status', 'no')" {/if} >                             
                                        <i></i>
                                    </label>
                                    <span id="upload_status" style="display:none;"></span>
                                </td>
                                <td>
                                    {if $MODULE_STATUS['upload_status']=='yes'}
                                        <a class="btn btn-sm btn-icon btn-rounded btn-default" href="{$PATH_TO_ROOT_DOMAIN}admin/upload_materials"><i class="fa fa-cog"></i></a>
                                    {/if}
                                </td>
                            </tr>
                            <tr>
                                <td>{lang('live_chat')}</td>
                                <td>   
                                    <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                        <input type="checkbox" name="set_module_status" id="set_live_chat_status" value="yes" {if $MODULE_STATUS['live_chat_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'live_chat_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'live_chat_status', 'no')" {/if} >                             
                                        <i></i>
                                    </label>
                                    <span id="live_chat_status" style="display:none;"></span>
                                </td>
                            </tr>
                            {* <tr>
                                <td>{lang('footer_demo_status')}</td>
                                <td>   
                                    <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                        <input type="checkbox" name="set_module_status" id="set_footer_demo_status" value="yes" {if $MODULE_STATUS['footer_demo_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'footer_demo_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'footer_demo_status', 'no')" {/if} >                             
                                        <i></i>
                                    </label>
                                    <span id="footer_demo_status" style="display:none;"></span>
                                </td>
                            </tr> *}
                            {if DEMO_STATUS == 'yes'}
                                <tr>
                                    <td>{lang('help')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_help_status" value="yes" {if $MODULE_STATUS['help_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'help_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'help_status', 'no')" {/if} >                             
                                            <i></i>
                                        </label>
                                        <span id="help_status" style="display:none;"></span>
                                    </td>
                                </tr>
                            {/if}
                            {if $MODULE_STATUS['opencart_status']=='no' && $MODULE_STATUS['product_status']=='yes'}
                                <tr>
                                    <td>{lang('repurchase_status')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_repurchase_status" value="yes" {if $MODULE_STATUS['repurchase_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'repurchase_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'repurchase_status', 'no')" {/if} >      
                                            <i></i>                       
                                        </label>
                                        <span id="repurchase_status" style="display:none;"></span>
                                    </td>
                                </tr>
                            {/if}
                            {if $MODULE_STATUS['opencart_status']=='no' && $MODULE_STATUS['product_status']=='yes'}
                                <tr>
                                    <td>{lang('product_validity')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_product_validity" value="yes" {if $MODULE_STATUS['product_validity']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'product_validity', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'product_validity', 'no')" {/if} >   
                                            <i></i>                          
                                        </label>
                                        <span id="product_validity" style="display:none;"></span>
                                    </td>
                                </tr>
                            {/if}
                            {if $MODULE_STATUS['opencart_status']=='no' && $MODULE_STATUS['product_status']=='yes' && $MODULE_STATUS['package_upgrade_demo']=='yes'}
                                <tr>
                                    <td>{lang('package_upgrade')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_package_upgrade" value="yes" {if $MODULE_STATUS['package_upgrade']=="no"} onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'package_upgrade', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'package_upgrade', 'no')" {/if} >
                                            <i></i>
                                        </label>
                                        <span id="package_upgrade" style="display:none;"></span>
                                    </td>
                                </tr>
                            {/if}
                            {if $MODULE_STATUS['opencart_status']=='no' && $MODULE_STATUS['product_status']=='yes' && $MODULE_STATUS['hyip_status']!="yes"}
                                <tr>
                                    <td>{lang('Hyip')}</td>
                                    <td>   
                                        <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox" name="set_module_status" id="set_maintenance_status" value="yes" {if $MODULE_STATUS['roi_status']=="no"} onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'roi_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'roi_status', 'no')" {/if} >
                                            <i></i>
                                        </label>
                                        <span id="maintenance_status" style="display:none;"></span>
                                    </td>
                                </tr>
                            {/if}
                            {* <tr>
                                <td>Basic Rank Only</td>
                                <td>   
                                    <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                        <input type="checkbox" name="set_module_status" id="set_maintenance_status" value="yes" {if $MODULE_STATUS['basic_demo_status']=="no"} onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'basic_demo_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'basic_demo_status', 'no')" {/if} >
                                        <i></i>
                                    </label>
                                    <span id="maintenance_status" style="display:none;"></span>
                                </td>
                            </tr> *}
                            <tr>
                                <td>{lang('xup_commission')}</td>
                                <td>   
                                    <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                        <input type="checkbox" name="set_module_status" id="set_xup_module" value="yes" {if $MODULE_STATUS['xup_status']=="no"} onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'xup_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'xup_status', 'no')" {/if} >
                                        <i></i>
                                    </label>
                                    <span id="xup_status" style="display:none;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>{lang('GDPR')}</td>
                                <td>   
                                    <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                        <input type="checkbox" name="set_module_status" id="set_gdpr" value="yes" {if $MODULE_STATUS['gdpr']=="no"} onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'gdpr', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'gdpr', 'no')" {/if} >
                                        <i></i>
                                    </label>
                                    <span id="gdpr" style="display:none;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>{lang('kyc')}</td>
                                <td>   
                                    <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                        <input type="checkbox" name="set_module_status" id="set_kyc_status" value="yes" {if $MODULE_STATUS['kyc_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'kyc_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'kyc_status', 'no')" {/if} >  
                                        <i></i>                           
                                    </label>
                                    <span id="kyc_status" style="display:none;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>{lang('mail_gun')}</td>
                                <td>   
                                    <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                        <input type="checkbox" name="set_module_status" id="set_mail_gun" value="yes" {if $MODULE_STATUS['mail_gun_status']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'mail_gun_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'mail_gun_status', 'no')" {/if} >                             
                                        <i></i>
                                    </label>
                                    <span id="mail_gun_status" style="display:none;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>{lang('signup_config')}</td>
                                <td>   
                                    <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                        <input type="checkbox" name="set_module_status" id="set_signup_config" value="yes" {if $MODULE_STATUS['signup_config']=="no"}   onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'signup_config', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'signup_config', 'no')" {/if} >                             
                                        <i></i>
                                    </label>
                                    <span id="signup_config" style="display:none;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>{lang('autoship')}</td>
                                <td>   
                                    <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                        <input type="checkbox" name="set_module_status" id="set_maintenance_status" value="yes" {if $MODULE_STATUS['auto_ship_status']=="no"} onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'auto_ship_status', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'auto_ship_status', 'no')" {/if}  {if $MODULE_STATUS['product_validity']=="no"} disabled="true"{/if}>
                                        <i></i>
                                    </label>
                                    <span id="maintenance_status" style="display:none;"></span>
                                </td>
                            </tr>
                            <tr>
                                <td>{lang('purchase_wallet')}</td>
                                <td>   
                                    <label class="bg-primary i-switch make-switch" data-on="success" data-off="warning">
                                        <input type="checkbox" name="set_module_status" id="set_purchase_wallet" value="yes" {if $MODULE_STATUS['purchase_wallet']=="no"} onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'purchase_wallet', 'yes')" {else} checked onChange="change_module_status('{$PUBLIC_URL}', '{$PATH_TO_ROOT_DOMAIN}admin/', 'purchase_wallet', 'no')" {/if}>
                                        <i></i>
                                    </label>
                                    <span id="purchase_wallet" style="display:none;"></span>
                                </td>
                            </tr>
                        </tbody>    
                    </table>
                    </div>
                    {form_close()}
                </div>
            </div>
        </div>
    </div>
{/block}