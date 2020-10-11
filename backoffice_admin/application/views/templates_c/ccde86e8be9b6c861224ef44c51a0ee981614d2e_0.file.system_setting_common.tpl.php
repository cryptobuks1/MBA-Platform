<?php
/* Smarty version 3.1.30, created on 2020-09-16 22:22:14
  from "/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/admin/configuration/system_setting_common.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6203760c6d41_67506873',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ccde86e8be9b6c861224ef44c51a0ee981614d2e' => 
    array (
      0 => '/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/admin/configuration/system_setting_common.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6203760c6d41_67506873 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="wrapper_index">
<div class="region  panel setting_margin  setting_margin_top">
    <div id="block-block-12" class="block block-block contextual-links-region clearfix">
        <div class=" features-quick-access">
            <div class="hbox text-center b-light text-sm bg-white">
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/general_setting" class="col padder-v text-muted <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'configuration/general_setting') {?> setting-selected <?php }?>">
                    <i class="fa fa-desktop block m-b-xs fa-2x"></i>
                    <span><?php echo lang('general');?>
</span>
                </a>
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/compensation_settings" class="col padder-v text-muted <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'configuration/compensation_settings') {?> setting-selected <?php }?>">
                    <i class="fa fa-calculator block m-b-xs fa-2x"></i>
                    <span><?php echo lang('compensation');?>
</span>
                </a>
                <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Board' || $_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Matrix') {?>
                    <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/plan_settings" class="col padder-v text-muted <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'configuration/plan_settings') {?> setting-selected <?php }?>">
                        <i class="fa fa-cogs block m-b-xs fa-2x"></i>
                        <span>
                            <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Matrix') {?>
                                <?php echo lang('matrix');?>

                            <?php } elseif ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Board' && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['table_status'] == 'yes') {?>
                                <?php echo lang('table');?>

                            <?php } else { ?>
                                <?php echo lang('board');?>

                            <?php }?>
                        </span>
                    </a>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Stair_Step') {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/stairstep_configuration" class="col padder-v text-muted <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'configuration/stairstep_configuration') {?> setting-selected <?php }?>">
                    <i class="fa fa-sticky-note block m-b-xs fa-2x"></i>
                    <span><?php echo lang('stairstep');?>
</span>
                </a>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Donation') {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/donation_configuration" class="col padder-v text-muted <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'configuration/donation_configuration') {?> setting-selected <?php }?>">
                    <i class="fa fa-gift block m-b-xs fa-2x"></i>
                    <span><?php echo lang('donation');?>
</span>
                </a>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['rank_status'] == 'yes') {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/rank_configuration" class="col padder-v text-muted <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'configuration/rank_configuration') {?> setting-selected <?php }?>">
                    <i class="fa fa-trophy block m-b-xs fa-2x"></i>
                    <span><?php echo lang('rank');?>
</span>
                </a>
                <?php }?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/payout_setting" class="col padder-v text-muted <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'configuration/payout_setting') {?> setting-selected <?php }?>">
                    <i class="fa fa-history block m-b-xs fa-2x"></i>
                    <span><?php echo lang('payout');?>
</span>
                </a>
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/payment_view" class="col padder-v text-muted <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'configuration/payment_view') {?> setting-selected <?php }?>">
                    <i class="fa fa-credit-card block m-b-xs fa-2x"></i>
                    <span><?php echo lang('payment');?>
</span>
                </a>
                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['pin_status'] == 'yes') {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/pin_config" class="col padder-v text-muted <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'configuration/pin_config') {?> setting-selected <?php }?>">
                    <i class="fa fa-tags block m-b-xs fa-2x"></i>
                    <span><?php echo lang('epin');?>
</span>
                </a>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['signup_config'] == 'yes') {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/signup_settings" class="col padder-v text-muted <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'configuration/signup_settings') {?> setting-selected <?php }?>">
                    <i class="fa fa-user-plus block m-b-xs fa-2x"></i>
                    <span><?php echo lang('signup');?>
</span>
                </a>
                <?php }?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/mail_content" class="col padder-v text-muted <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'configuration/mail_content') {?> setting-selected <?php }?>">
                    <i class="fa fa-envelope block m-b-xs fa-2x"></i>
                    <span><?php echo lang('mail');?>
</span>
                </a>
                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['sms_status'] == 'yes') {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/sms_settings" class="col padder-v text-muted <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'configuration/sms_settings') {?> setting-selected <?php }?>">
                    <i class="fa fa-comments block m-b-xs fa-2x"></i>
                    <span><?php echo lang('sms');?>
</span>
                </a>
                <?php }?>
                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['multy_currency_status'] == 'yes') {?>
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/currency/currency_management" class="col padder-v text-muted <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'currency/currency_management') {?> setting-selected <?php }?>">
                    <i class="fa fa-money block m-b-xs fa-2x"></i>
                    <span><?php echo lang('currency');?>
</span>
                </a>
                <?php }?>
                
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/tooltip_settings" class="col padder-v text-muted <?php if ($_smarty_tpl->tpl_vars['CURRENT_URL']->value == 'configuration/tooltip_settings') {?> setting-selected <?php }?>">
                    <i class="fa fa-arrows block m-b-xs fa-2x"></i>
                    <span><?php echo lang('tooltip');?>
</span>
                </a>
                
            </div>
        </div>
    </div>
</div>
</div>

<style>
a {
    word-break: normal;
}
</style>
<?php }
}
