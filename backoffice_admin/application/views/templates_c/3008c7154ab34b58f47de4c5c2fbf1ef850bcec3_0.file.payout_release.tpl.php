<?php
/* Smarty version 3.1.30, created on 2020-08-05 23:04:19
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/payout/payout_release.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2aae53b74275_62603386',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3008c7154ab34b58f47de4c5c2fbf1ef850bcec3' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/payout/payout_release.tpl',
      1 => 1596632557,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/otp_modal.tpl' => 1,
  ),
),false)) {
function content_5f2aae53b74275_62603386 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_204341075f2aae53b72981_49806724', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_204341075f2aae53b72981_49806724 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<main>
    <div id="span_js_messages" style="display: none;">
        <span id="error_msg"><?php echo lang('please_select_at_least_one_checkbox');?>
</span>
        <span id="row_msg"><?php echo lang('rows');?>
</span>
        <span id="show_msg"><?php echo lang('shows');?>
</span>
        <span id="show_msg1"><?php echo lang('are_you_sure_you_want_to_Delete_There_is_NO_undo');?>
</span>
        <span id="show_msg2"><?php echo lang('digits_only');?>
</span>
        <span id="err_msg1"><?php echo lang('main_password_required');?>
</span>
        <span id="err_msg2"><?php echo lang('second_password_required');?>
</span>
        <span id="err_msg3"><?php echo lang('wallet_id_required');?>
</span>
        <span id="err_msg4"><?php echo lang('passphrase_required');?>
</span>
        <span id="err_msg5"><?php echo lang('wallet_name_required');?>
</span>
        <span id="err_msg6"><?php echo lang('wallet_password_required');?>
</span>
        <span id="otp_err1"><?php echo lang('you_must_enter_otp');?>
 </span>
        <span id="otp_err2"><?php echo lang('otp_is_numeric');?>
 </span>
    </div>
    <div class="tabsy">
        <input type="hidden" id="checkAll" type="submit" value="Check All"> <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['payout_release_status'] == "both") {?>
        <input type="radio" id="tab1" name="tab" <?php if ($_smarty_tpl->tpl_vars['tab1']->value) {?>checked<?php }?>>
        <label class="tabButton" for="tab1"><?php echo lang('from_e_wallet');?>
</label>
        <div class="tab">
            <div class="content">
            <div class="m-b pink-gradient">
                <div class="card-body ">
                    <div class="media">
                        <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
                        <div class="media-body">
                            <h6 class="my-0">Shows the list of payout based on user's ewallet balance. Admin can pay the amount by choosing a payout method. </h6>
                        </div>
                    </div>
                </div>
            </div>
                <?php echo form_open('/admin/post_payout_release','name="ewallet_form_det" class="" id="ewallet_form_det" method="post" ');?>
 <?php if ($_smarty_tpl->tpl_vars['count1']->value > 0) {?>
                <input type="hidden" name="current_tab" id="current_tab" value="tab1">
                <input type='hidden' name="table_rows" value="<?php echo $_smarty_tpl->tpl_vars['count1']->value;?>
">
                <input type="hidden" id="payment_method" name="payment_method" value="<?php echo $_smarty_tpl->tpl_vars['payment_type']->value;?>
">
                <div class="panel panel-default table-responsive">
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('sl_no');?>
</th>
                                <th><?php echo lang('user_name');?>
</th>
                                <th><?php echo lang('user_full_name');?>
</th>
                                <th><?php echo lang('balance_amount');?>
</th>
                                <th><?php echo lang('Payout_Amount');?>
</th>
                                <th><?php echo lang('payout_type');?>
</th>
                                <th class="check_all"><?php echo lang('check');?>
/<a class="cursor" type="submit" name="check_all_tab1" value="Check All" id="check_all_tab1"><?php echo lang('check_all');?>
</a></th>
                                <th><?php echo lang('view_user_data');?>
</th>
                            </tr>
                        </thead>
                        <?php $_smarty_tpl->_assignInScope('i', 0);
$_smarty_tpl->_assignInScope('path', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."admin/");
?>
                        <tbody>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['payout_details1']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['start1']->value++;?>

                                    <input type='hidden' name='request_id<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['v']->value['req_id'];?>
'>
                                    <input type='hidden' name='user_name<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
'>
                                    <input type='hidden' name='balance_amount<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['v']->value['balance_amount'];?>
'>
                                    <input type='hidden' name='requested_date<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['v']->value['requested_date'];?>
'>
                                    <input type='hidden' name='payout_amount<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['v']->value['payout_amount'];?>
'>
                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
 </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['full_name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['balance_amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                                <td>
                                    <div class="input_width">
                                        <div class="input-group"> <?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value) {?><span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
</span><?php }?>
                                            <input type="text" class="payout_amount form-control" name="payout<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" id="payout_amount<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" value="<?php echo round($_smarty_tpl->tpl_vars['v']->value['payout_amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
" <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['payout_release_status'] != "ewallet_request") {
}?>/>
                                        </div>
                                    </div>
                                    <span id="errmsg1"></span>
                                </td>
                                <td><?php echo ucfirst($_smarty_tpl->tpl_vars['v']->value['payout_type']);?>
</td>
                                <td>
                                    <div class="checkbox">
                                        <label class="i-checks">
                      <input type="checkbox" name="release_tab1<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" id="release_tab1<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="release release_tab1">
                      <i> </i></label>
                                    </div>
                                </td>
                                <td>
                                    <button type="button" title="View" class="btn-link btn-xs text-info" onclick="view_popup('<?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
', this.parentNode.parentNode.rowIndex, 'admin', '<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
')" data-toggle="modal" data-target="#panel-config"><i class="fa fa-eye"></i></button></td>
                            </tr>
                            <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </tbody>
                    </table><?php echo $_smarty_tpl->tpl_vars['result_per_page1']->value;?>

                </div>
                <div class="payment f-Blockchain" <?php if ($_smarty_tpl->tpl_vars['payment_type']->value != 'Blockchain') {?>style="display:none;" <?php }?>>
                <legend><span class="fieldset-legend"><?php echo lang('account_details');?>
</span></legend>
                     

                    <div class="form-group">
                        <div class="col-sm-4 padding_both">
                            <label class="control-label required" for="main_password"><?php echo lang('main_password');?>
</label>
                            <input class="form-control" type="password" name="main_password" id="main_password" value="" title="">
                            <span id="errmsg3"></span> <?php echo form_error('main_password');?>

                        </div>
                    </div>
                    <div class=" form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="second_password"><?php echo lang('second_password');?>
</label>
                            <input class="form-control" type="password" name="second_password" id="second_password" value="" title="">
                            <span id="errmsg3"></span> <?php echo form_error('second_password');?>

                        </div>
                    </div>

                </div>
                <div class="payment f-Bitgo" <?php if ($_smarty_tpl->tpl_vars['payment_type']->value != 'Bitgo') {?>style="display:none;" <?php }?>>
                   <legend><span class="fieldset-legend"><?php echo lang('account_details');?>
</span></legend>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both">
                            <label class=" control-label required" for="wallet_id"><?php echo lang('wallet_id');?>
</label>
                            <input class="form-control" type="text" name="wallet_id" id="wallet_id" value="" title="">
                            <span id="errmsg3"></span> <?php echo form_error('wallet_id');?>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="passphrase"><?php echo lang('passphrase');?>
</label>
                            <input class="form-control" type="password" name="passphrase" id="passphrase" value="" title="">
                            <span id="errmsg3"></span> <?php echo form_error('passphrase');?>

                        </div>
                    </div>
                </div>
                <div class="payment f-Bitcoin" <?php if ($_smarty_tpl->tpl_vars['payment_type']->value != 'Bitcoin') {?>style="display:none;" <?php }?>>
                    <legend><span class="fieldset-legend"><?php echo lang('account_details');?>
</span></legend>

                    <div class="form-group">
                        <div class="col-sm-4 padding_both">
                            <label class="control-label required" for="wallet_name"><?php echo lang('wallet_name');?>
</label>
                            <input class="form-control" type="text" name="wallet_name" id="wallet_name" value="" title="">
                            <span id="errmsg3"></span> <?php echo form_error('wallet_name');?>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="wallet_password"><?php echo lang('wallet_password');?>
</label>
                            <input class="form-control" type="password" name="wallet_password" id="wallet_password" value="" title="">
                            <span id="errmsg3"></span> <?php echo form_error('wallet_password');?>

                        </div>
                    </div>
                </div>
                <div>
                <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                    <input type="hidden" value='release_payout_tab1' name='release_payout'>
                    <button class="btn btn-sm btn-primary mark_paid" name="release_payout_tab1" id="release_payout_tab1" type="button" value="release_payout"> <?php echo lang('release');?>
 </button>
                </div>
                </div>
                </div>
                <?php } else { ?>
                <h4 align="center"><?php echo lang('no_payout_found');?>
</h4>
                <?php }?> <?php echo form_close();?>

            </div>
            
        </div>
        <input type="radio" id="tab2" name="tab" <?php if ($_smarty_tpl->tpl_vars['tab2']->value) {?>checked<?php }?>>
        <label class="tabButton" for="tab2"><?php echo lang('e_wallet_request');?>
</label>
        <div class="tab">
            <div class="content">
            
            <div class="m-b pink-gradient">
                <div class="card-body ">
                    <div class="media">
                        <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
                        <div class="media-body">
                            <h6 class="my-0">Shows the list of payout requests. Admin can pay the amount by choosing a payout method or reject payout request.</h6>
                        </div>
                    </div>
                </div>
            </div>
                <?php echo form_open('/admin/post_payout_release','name="ewallet_form_det" class="" id="ewallet_form_det2" method="post"');?>
 <?php if ($_smarty_tpl->tpl_vars['count2']->value > 0) {?>
                <input type="hidden" name="current_tab" id="current_tab" value="tab2">
                <input type='hidden' name="table_rows" value="<?php echo $_smarty_tpl->tpl_vars['count2']->value;?>
">
                <input type="hidden" id="payment_method" name="payment_method" value="<?php echo $_smarty_tpl->tpl_vars['payment_type']->value;?>
">
                <div class="panel panel-default table-responsive">
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('sl_no');?>
 </th>
                                <th><?php echo lang('user_name');?>
</th>
                                <th><?php echo lang('user_full_name');?>
</th>
                                <th><?php echo lang('balance_amount');?>
</th>
                                <th><?php echo lang('Payout_Amount');?>
</th>
                                <th><?php echo lang('payout_type');?>
</th>
                                <th class="check_all"><?php echo lang('check');?>
/<a class="cursor" type="submit" name="check_all_tab2" value="Check All" id="check_all_tab2"><?php echo lang('check_all');?>
</a></th>
                                <th><?php echo lang('delete');?>
</th>
                                <th><?php echo lang('view_user_data');?>
</th>
                            </tr>
                        </thead>
                        <?php $_smarty_tpl->_assignInScope('i', 0);
$_smarty_tpl->_assignInScope('path', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."admin/");
?>
                        <tbody>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['payout_details2']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['start2']->value++;?>

                                    <input type='hidden' name='request_id<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['v']->value['req_id'];?>
'>
                                    <input type='hidden' name='user_name<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
'>
                                    <input type='hidden' name='balance_amount<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['v']->value['balance_amount'];?>
'>
                                    <input type='hidden' name='requested_date<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['v']->value['requested_date'];?>
'>
                                    <input type='hidden' name='payout_amount<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['v']->value['payout_amount'];?>
'>
                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['full_name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['balance_amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                                <td>
                                    <div class="input_width">
                                        <div class="input-group"><?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value) {?> <span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
</span> <?php }?>
                                             <input type="text" class="form-control" name="payout<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" id="payout_amount<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" value="<?php echo round($_smarty_tpl->tpl_vars['v']->value['payout_amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
" <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['payout_release_status'] != "ewallet_request") {
}?>/>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo ucfirst($_smarty_tpl->tpl_vars['v']->value['payout_type']);?>
</td>
                                <td>
                                    <div class="checkbox">
                                        <label class="i-checks">
                      <input type="checkbox" name="release_tab2<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" id="release_tab2<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="release_tab2 release" />
                      <i></i> </label>
                                    </div>
                                </td>
                                <td><button type="button" onclick="delete_request('<?php echo $_smarty_tpl->tpl_vars['v']->value['req_id'];?>
','<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['payout_type'];?>
')" class="btn-link text-danger"> <i class="fa fa-trash-o"> </i> </button></td>
                                <td>
                                    <button type="button" title="View" class="btn-link text-info" onclick="view_popup('<?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
', this.parentNode.parentNode.rowIndex, 'admin', '<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
')" data-toggle="modal" data-target="#panel-config"><i class="fa fa-eye"></i></button>

                                </td>
                            </tr>
                            <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </tbody>
                    </table><?php echo $_smarty_tpl->tpl_vars['result_per_page2']->value;?>

                </div>
                <div class="payment2 s-Blockchain" <?php if ($_smarty_tpl->tpl_vars['payment_type']->value != 'Blockchain') {?>style="display:none;" <?php }?>>
                   <legend><span class="fieldset-legend"><?php echo lang('account_details');?>
</span></legend>

                    <div class="form-group">
                        <div class="col-sm-4 padding_both">
                            <label class="control-label required" for="main_password"><?php echo lang('main_password');?>
</label>
                            <input class="form-control" type="password" name="main_password" id="main_password" value="" title="">
                            <span id="errmsg3"></span> <?php echo form_error('main_password_2');?>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="second_password"><?php echo lang('second_password');?>
</label>
                            <input class="form-control" type="password" name="second_password" id="second_password" value="" title="">
                            <span id="errmsg3"></span> <?php echo form_error('second_password_2');?>

                        </div>
                    </div>

                </div>
                <div class="payment2 s-Bitgo" <?php if ($_smarty_tpl->tpl_vars['payment_type']->value != 'Bitgo') {?>style="display:none;" <?php }?>>
                  <legend><span class="fieldset-legend"><?php echo lang('account_details');?>
</span></legend>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both">
                            <label class="control-label required" for="wallet_id"><?php echo lang('wallet_id');?>
</label>
                                <input class="form-control" type="text" name="wallet_id" id="wallet_id" value="" title="">
                                <span id="errmsg3"></span> <?php echo form_error('wallet_id_2');?>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="passphrase"><?php echo lang('passphrase');?>
</label>
                                <input class="form-control" type="password" name="passphrase" id="passphrase" value="" title="">
                                <span id="errmsg3"></span> <?php echo form_error('passphrase_2');?>

                        </div>
                    </div>
                </div>
                <div class="payment2 s-Bitcoin" <?php if ($_smarty_tpl->tpl_vars['payment_type']->value != 'Bitcoin') {?>style="display:none;" <?php }?>>
                   <legend><span class="fieldset-legend"><?php echo lang('account_details');?>
</span></legend>

                    <div class="form-group">
                        <div class="col-sm-4 padding_both">
                            <label class="control-label required" for="wallet_name"><?php echo lang('wallet_name');?>
</label>
                                <input class="form-control" type="text" name="wallet_name" id="wallet_name" value="" title="">
                                <span id="errmsg3"></span> <?php echo form_error('wallet_name_2');?>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="wallet_password"><?php echo lang('wallet_password');?>
</label>
                                <input class="form-control" type="password" name="wallet_password" id="wallet_password" value="" title="">
                                <span id="errmsg3"></span> <?php echo form_error('wallet_password_2');?>

                        </div>
                    </div>
                </div>

                <div class="form-group">
                 <div class="col-sm-4 padding_both_small">
                    <input type="hidden" value='release_payout_tab2' name='release_payout'>
                    <button class="btn btn-sm btn-primary mark_paid" name="release_payout_tab2" id="release_payout_tab2" type="button" value="release_payout"> <?php echo lang('release');?>
 </button>
                </div>
                </div>
                <?php } else { ?>
                <h4 align="center"><?php echo lang('no_payout_found');?>
</h4>
                <?php }?> <?php echo form_close();?>

            </div>

        </div>
        <?php } else { ?>
        <input type="radio" id="tab1" name="tab" checked>
        <label class="tabButton" for="tab1"><?php echo $_smarty_tpl->tpl_vars['tab_title']->value;?>
</label>
        <div class="tab">
            <div class="content">
             <div class="m-b pink-gradient ">
                <div class="card-body ">
                    <div class="media ">
                        <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
                        <div class="media-body ">
                            <h6 class="my-0 ">Shows the list of payout based on user's ewallet balance. Admin can pay the amount by choosing a payout method. </h6>
                        </div>
                    </div>
                </div>
            </div>
                <?php echo form_open('/admin/post_payout_release','name="ewallet_form_det" class="" id="ewallet_form_det" method="post" ');?>
 <?php if ($_smarty_tpl->tpl_vars['count']->value > 0) {?>
                <input type="hidden" id="payment_method" name="payment_method" value="<?php echo $_smarty_tpl->tpl_vars['payment_type']->value;?>
">
                <input type='hidden' name="table_rows" value="<?php echo $_smarty_tpl->tpl_vars['count']->value;?>
">
                <div class="panel panel-default table-responsive">


                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('sl_no');?>
</th>
                                <th><?php echo lang('user_name');?>
</th>
                                <th><?php echo lang('user_full_name');?>
</th>
                                <th><?php echo lang('balance_amount');?>
</th>
                                <th><?php echo lang('Payout_Amount');?>
</th>
                                <th><?php echo lang('payout_type');?>
</th>
                                <th class="check_all"><?php echo lang('check');?>
/<a class="cursor" type="submit" name="check_all" value="Check All" id="check_all" onclick="checkAll();"><?php echo lang('mark_all');?>
</a>
                                    <a class="cursor" type="submit" name="uncheck_all" value="Uncheck All" id="uncheck_all" onclick="uncheckAll();" style="display:none;"><?php echo lang('unmark_all');?>
</a></th>
                                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['payout_release_status'] == "ewallet_request") {?>
                                <th><?php echo lang('delete');?>
</th>
                                <?php }?>
                                <th><?php echo lang('view_user_data');?>
</th>
                                <th>Registered with Payeer</th>
                            </tr>
                        </thead>
                        <?php $_smarty_tpl->_assignInScope('i', 0);
?> <?php $_smarty_tpl->_assignInScope('path', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."admin/");
?>
                        <tbody>
                            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['payout_details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>

                            <tr>
                                <td><?php echo $_smarty_tpl->tpl_vars['start']->value++;?>

                                    <input type='hidden' name='request_id<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['v']->value['req_id'];?>
'>
                                    <input type='hidden' name='user_name<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
'>
                                    <input type='hidden' name='balance_amount<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['v']->value['balance_amount'];?>
'>
                                    <input type='hidden' name='requested_date<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['v']->value['requested_date'];?>
'>
                                    <input type='hidden' name='payout_amount<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
' value='<?php echo $_smarty_tpl->tpl_vars['v']->value['payout_amount'];?>
'>
                                </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
 </td>
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['full_name'];?>
</td>
                                <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['balance_amount']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                                <td>
                                    <div class="input_width">
                                        <div class="input-group"> <?php if ($_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value) {?><span class="input-group-addon"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
</span><?php }?>
                                            <input type="text" class="payout_amount form-control" name="payout<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" id="payout_amount<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" value="<?php echo round($_smarty_tpl->tpl_vars['v']->value['commision_details']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
" <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['payout_release_status'] != "ewallet_request") {
}?>/> </div>
                                    </div>
                                    <span id="errmsg1"></span>
                                </td>
                                <td><?php echo ucfirst($_smarty_tpl->tpl_vars['v']->value['payout_type']);?>
</td>
                                <td>
                                    <div class="checkbox">
                                        <label class="i-checks">
                                            <input type="checkbox" name="release<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" id="release<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="release">
                                            <i> </i></label>
                                    </div>
                                </td>
                                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['payout_release_status'] == "ewallet_request") {?>
                                <td><button type="button" onclick="delete_request('<?php echo $_smarty_tpl->tpl_vars['v']->value['req_id'];?>
','<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
','<?php echo $_smarty_tpl->tpl_vars['v']->value['payout_type'];?>
')" class="btn btn-xs btn-danger">
                                            <i class="fa fa-times"> </i> </button></td>
                                <?php }?>
                                <td>
                                    <button type="button" class="btn btn-xs btn-info" title="View" onclick="view_popup('<?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
', this.parentNode.parentNode.rowIndex, 'admin', '<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
')" data-toggle="modal" data-target="#panel-config" style='color:#000;'><i class="fa fa-eye"></i></button>

                                </td>
                                
                                <td><?php echo $_smarty_tpl->tpl_vars['v']->value['valid_payeer_account'];?>
</td> 
                            </tr>
                            <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </tbody>
                    </table><?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

                </div>
                <div class="payment f-Blockchain" <?php if ($_smarty_tpl->tpl_vars['payment_type']->value != 'Blockchain') {?>style="display:none;" <?php }?>>
                    <legend><span class="fieldset-legend"><?php echo lang('account_details');?>
</span></legend>

                    <div class="form-group">
                        <div class="col-sm-4 padding_both">
                            <label class="control-label required" for="main_password"><?php echo lang('main_password');?>
</label>
                                <input class="form-control" type="password" name="main_password" id="main_password" value="" title="">
                                <span id="errmsg3"></span> <?php echo form_error('main_password');?>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="second_password"><?php echo lang('second_password');?>
</label>
                                <input class="form-control" type="password" name="second_password" id="second_password" value="" title="">
                                <span id="errmsg3"></span> <?php echo form_error('second_password');?>

                        </div>
                    </div>

                </div>
                <div class="payment f-Bitgo" <?php if ($_smarty_tpl->tpl_vars['payment_type']->value != 'Bitgo') {?>style="display:none;" <?php }?>>
                    <legend><span class="fieldset-legend"><?php echo lang('account_details');?>
</span></legend>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="wallet_id"><?php echo lang('wallet_id');?>
</label>
                                <input class="form-control" type="text" name="wallet_id" id="wallet_id" value="" title="">
                                <span id="errmsg3"></span> <?php echo form_error('wallet_id');?>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="passphrase"><?php echo lang('passphrase');?>
</label>
                                <input class="form-control" type="password" name="passphrase" id="passphrase" value="" title="">
                                <span id="errmsg3"></span> <?php echo form_error('passphrase');?>

                        </div>
                    </div>
                </div>
                <div class="payment f-Bitcoin" <?php if ($_smarty_tpl->tpl_vars['payment_type']->value != 'Bitcoin') {?>style="display:none;" <?php }?>>
                      <legend><span class="fieldset-legend"><?php echo lang('account_details');?>
</span></legend>

                    <div class=" form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="wallet_name"><?php echo lang('wallet_name');?>
</label>
                                <input class="form-control" type="text" name="wallet_name" id="wallet_name" value="" title="">
                                <span id="errmsg3"></span> <?php echo form_error('wallet_name');?>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-4 padding_both_small">
                            <label class="control-label required" for="wallet_password"><?php echo lang('wallet_password');?>
</label>
                                <input class="form-control" type="password" name="wallet_password" id="wallet_password" value="" title="">
                                <span id="errmsg3"></span> <?php echo form_error('wallet_password');?>

                        </div>
                    </div>
                </div>
                 
                <div class="form-group" style="min-height:100px !important;">
                        <div class="col-sm-4 padding_both_small">
                    <input type="hidden" value='release_payout' name='release_payout'>
                    <button class="btn btn-sm btn-primary mark_paid" name="release_payout" id="release_payout" type="button" value="release_payout"> <?php echo lang('release');?>
 </button>
                </div>
                </div>
                <?php } else { ?>
                <h4 align="center "><?php echo lang('no_payout_found');?>
</h4>
                <?php }?> <?php echo form_close();?>

            </div>
           
        </div>
        <?php }?>
    </div>
    <?php $_smarty_tpl->_subTemplateRender("file:layout/otp_modal.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

    <div id='transaction' type="hidden">
        <div class="modal fade " id='panel-config' tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                    </button>
                    <h4 class="modal-title"><?php echo lang('user_details');?>
</h4>
                </div>
                    <div class="modal-body">
                        <div id='div1'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
