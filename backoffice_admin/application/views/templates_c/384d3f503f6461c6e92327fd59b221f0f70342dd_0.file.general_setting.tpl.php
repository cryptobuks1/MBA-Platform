<?php
/* Smarty version 3.1.30, created on 2020-08-05 10:02:57
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/general_setting.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f29f731636741_22603880',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '384d3f503f6461c6e92327fd59b221f0f70342dd' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/general_setting.tpl',
      1 => 1582706901,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/configuration/system_setting_common.tpl' => 1,
    'file:common/notes.tpl' => 1,
  ),
),false)) {
function content_5f29f731636741_22603880 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_19986311905f29f731633de5_28144770', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_21230546415f29f731635508_84878992', 'style');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15228667305f29f7316361f8_26046341', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_19986311905f29f731633de5_28144770 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="span_js_messages" style="display: none;">
    <span id="validate_msg13"><?php echo lang('digit_only');?>
</span>
    <span id="validate_msg20"><?php echo lang('service_charge_required');?>
</span>
    <span id="validate_msg21"><?php echo lang('service_charge_must_between_0_to_100');?>
</span>
    <span id="validate_msg22"><?php echo lang('tds_required');?>
</span>
    <span id="validate_msg23"><?php echo lang('tds_must_between_0_to_100');?>
</span>
    <span id="validate_msg24"><?php echo lang('sum_of_tds_and_service_charge_should_be_less_equal_to_100');?>
</span>
    <span id="validate_msg25"><?php echo lang('commission_must_be_less_than_100');?>
</span>
    <span id="validate_msg26"><?php echo lang('field_is_required');?>
</span>
    <span id="validate_msg27"><?php echo lang('field_must_be_between_0_100');?>
</span>
    <span id="validate_msg30"><?php echo lang('digit_greater_than_0');?>
</span>
    <span id="registration_amount_required"><?php echo lang('registration_amount_required');?>
</span>
    <span id="trans_fee_required"><?php echo lang('trans_fee_required');?>
</span>
    <span id="you_must_enter"><?php echo lang('you_must_enter');?>
</span>
    <span id="purchase_income_perc_required"><?php echo strtolower(lang('purchase_wallet_commission'));?>
</span>
    <span id="greater_zero"><?php echo lang('subs_count_greater_zero');?>
</span>
    <span id="sus_fee_greater"><?php echo lang('sus_fee_greater');?>
</span>
    <span id="field_req"><?php echo lang('field_req');?>
</span>
    <span id="upgrade_fee_req"><?php echo lang('upgrade_fee_req');?>
</span>
    <span id="upgrade_fee_min"><?php echo lang('upgrade_fee_min');?>
</span>
</div>

<?php $_smarty_tpl->_subTemplateRender("file:admin/configuration/system_setting_common.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="panel panel-default">
    <div class="panel-body">
    <legend><span class="fieldset-legend"><?php echo lang('general_settings');?>
</span></legend>
        <div class="table-responsive">

            <?php echo form_open('','role="form" class="" name="form_general_setting" id="form_general_setting"');?>


            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['opencart_status'] == "no") {?>
                <div class="form-group">
                    <label class="required"><?php echo lang('registration_amount');?>
</label>
                    <div class="input-group <?php echo $_smarty_tpl->tpl_vars['input_group_hide']->value;?>
">
                        <?php echo $_smarty_tpl->tpl_vars['left_symbol']->value;?>

                        <input class="form-control" type="text" name="reg_amount" id="reg_amount" value="<?php echo round($_smarty_tpl->tpl_vars['obj_arr']->value["reg_amount"]*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
" maxlength="5">
                        <?php echo $_smarty_tpl->tpl_vars['right_symbol']->value;?>

                    </div>
                    <?php echo form_error('reg_amount');?>

                </div>
            <?php }?>
            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['referal_status'] == "yes" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['product_status'] == "no" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['rank_status'] == "no") {?>
                <div class="form-group">
                    <label class="required"><?php echo lang('referral_income');?>
</label>
                    <div class="input-group <?php echo $_smarty_tpl->tpl_vars['input_group_hide']->value;?>
">
                        <?php echo $_smarty_tpl->tpl_vars['left_symbol']->value;?>

                        <input class="form-control" type="text" name="referal_amount" id="referal_amount" value="<?php echo round($_smarty_tpl->tpl_vars['obj_arr']->value["referal_amount"],$_smarty_tpl->tpl_vars['PRECISION']->value);?>
">
                        <?php echo $_smarty_tpl->tpl_vars['right_symbol']->value;?>

                    </div>
                    <?php echo form_error('referal_amount');?>

                </div>
            <?php }?>
            <div class="form-group">
                <label class="required"><?php echo lang('service_charge');?>
 (%)</label>
                <input class="form-control" type="text" name="service_charge" id="service" value="<?php echo round($_smarty_tpl->tpl_vars['obj_arr']->value["service_charge"],$_smarty_tpl->tpl_vars['PRECISION']->value);?>
">
                <?php echo form_error('service_charge');?>

            </div>
            
            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['purchase_wallet'] == "yes") {?>
            <div class="form-group">
                <label class="required"><?php echo lang('purchase_wallet_commission');?>
 (%)</label>
                <input class="form-control" type="text" name="purchase_income_perc" id="purchase_income_perc" value="<?php echo $_smarty_tpl->tpl_vars['obj_arr']->value["purchase_income_perc"];?>
">
                <?php echo form_error('purchase_income_perc');?>

            </div>
            <?php }?>

            <div class="form-group">
                <label class="required"><?php echo lang('transaction_fee');?>
</label>
                <div class="input-group <?php echo $_smarty_tpl->tpl_vars['input_group_hide']->value;?>
">
                    <?php echo $_smarty_tpl->tpl_vars['left_symbol']->value;?>

                    <input class="form-control" type="text" name="trans_fee"  id="trans_fee" value="<?php echo round($_smarty_tpl->tpl_vars['obj_arr']->value["trans_fee"]*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
" autocomplete="off" maxlength="5">
                    <?php echo $_smarty_tpl->tpl_vars['right_symbol']->value;?>

                </div>
                <?php echo form_error('trans_fee');?>

            </div>

            <div class="form-group">
                <label class="required"> <?php echo lang('tds');?>
 (%)</label>
                <input class="form-control" type="text" name="tds" id="tds" value="<?php echo round($_smarty_tpl->tpl_vars['obj_arr']->value["tds"],$_smarty_tpl->tpl_vars['PRECISION']->value);?>
">
                <?php echo form_error('tds');?>

            </div>
            
            <div class="form-group">
                <label class="required"><?php echo lang('monthly_subscription_fee');?>
</label>
                <div class="input-group <?php echo $_smarty_tpl->tpl_vars['input_group_hide']->value;?>
">
                    <?php echo $_smarty_tpl->tpl_vars['left_symbol']->value;?>

                    <input class="form-control" type="text" name="subs_fee"  id="subs_fee" value="<?php echo round($_smarty_tpl->tpl_vars['obj_arr']->value["monthly_subs_fee"]*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
" autocomplete="off" maxlength="5">
                    <?php echo $_smarty_tpl->tpl_vars['right_symbol']->value;?>

                </div>
                <?php echo form_error('subs_fee');?>

            </div>
            
            <div class="form-group">
                <label class="required"><?php echo lang('upgrade_fee');?>
</label>
                <div class="input-group <?php echo $_smarty_tpl->tpl_vars['input_group_hide']->value;?>
">
                    <?php echo $_smarty_tpl->tpl_vars['left_symbol']->value;?>

                    <input class="form-control" type="text" name="upgrade_fee"  id="upgrade_fee" value="<?php echo round($_smarty_tpl->tpl_vars['obj_arr']->value["upgrade_amount"]*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
" autocomplete="off">
                    <?php echo $_smarty_tpl->tpl_vars['right_symbol']->value;?>

                </div>
                <?php echo form_error('upgrade_fee');?>

            </div>
            
            
            <div class="form-group">
                <label class="required"> <?php echo lang('subs_referral_count');?>
 </label>
                <input class="form-control" type="text" name="subs_referal_count" id="subs_referal_count" value="<?php echo $_smarty_tpl->tpl_vars['obj_arr']->value["subs_referal_count"];?>
">
                <?php echo form_error('subs_referal_count');?>

            </div>

            <div class="form-group">
                <label class="required"><?php echo lang('auto_logout_after');?>
</label>
                <select type="text" class="form-control m-b" name="logout_time" id="logout_time">
                    <option <?php if ($_smarty_tpl->tpl_vars['prev_time']->value == "180") {?> selected <?php }?> value="180"><?php echo 3;?>
 <?php echo lang('n_minutes_of_inactivity');?>
</option>
                    <option <?php if ($_smarty_tpl->tpl_vars['prev_time']->value == "240") {?> selected <?php }?> value="240"><?php echo 4;?>
 <?php echo lang('n_minutes_of_inactivity');?>
</option>
                    <option <?php if ($_smarty_tpl->tpl_vars['prev_time']->value == "300") {?> selected <?php }?> value="300"><?php echo 5;?>
 <?php echo lang('n_minutes_of_inactivity');?>
</option>
                    <option <?php if ($_smarty_tpl->tpl_vars['prev_time']->value == "600") {?> selected <?php }?> value="600"><?php echo 10;?>
 <?php echo lang('n_minutes_of_inactivity');?>
</option>
                    <option <?php if ($_smarty_tpl->tpl_vars['prev_time']->value == "900") {?> selected <?php }?> value="900"><?php echo 15;?>
 <?php echo lang('n_minutes_of_inactivity');?>
</option>
                    <option <?php if ($_smarty_tpl->tpl_vars['prev_time']->value == "1200") {?> selected <?php }?> value="1200"><?php echo 20;?>
 <?php echo lang('n_minutes_of_inactivity');?>
</option>
                    <option <?php if ($_smarty_tpl->tpl_vars['prev_time']->value == "1500") {?> selected <?php }?> value="1500"><?php echo 25;?>
 <?php echo lang('n_minutes_of_inactivity');?>
</option>
                    <option <?php if ($_smarty_tpl->tpl_vars['prev_time']->value == "1800") {?> selected <?php }?> value="1800"><?php echo 30;?>
 <?php echo lang('n_minutes_of_inactivity');?>
</option>
                </select>
                <?php echo form_error('logout_time');?>

            </div>
            <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['compression_status'] == "yes") {?>
                <div class="form-group">
                    <div class="checkbox">
                    <label class="i-checks">
                        <input type="checkbox" name="compression_commission" <?php if ($_smarty_tpl->tpl_vars['signup_config']->value['general_signup_config']['compression_commission'] == 'yes') {?> checked <?php }?>><i></i> <?php echo lang('enable_dynamic_compression');?>

                    </label>
                    </div>
                </div>
            <?php }?>

            <div class="form-group">
                <div class="checkbox">
                  <label class="i-checks">
                    <input type="checkbox" name="skip_blocked_users_commission" <?php if ($_smarty_tpl->tpl_vars['obj_arr']->value['skip_blocked_users_commission'] == 'yes') {?> checked <?php }?>><i></i> <?php echo lang('skip_blocked_users_commission');?>

                  </label>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-sm btn-primary" type="submit" value="<?php echo lang('update');?>
" name="setting" id="setting"><?php echo lang('update');?>
</button>
            </div>
            <?php $_smarty_tpl->_subTemplateRender("file:common/notes.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('notes'=>lang('note_tax_transaction_fee')), 0, false);
?>


            <?php echo form_close();?>


        </div>
    </div>
</div>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'style'} */
class Block_21230546415f29f731635508_84878992 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

     <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

<?php
}
}
/* {/block 'style'} */
/* {block 'script'} */
class Block_15228667305f29f7316361f8_26046341 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/general_settings.js"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
