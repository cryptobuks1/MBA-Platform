<?php
/* Smarty version 3.1.30, created on 2020-08-05 21:24:46
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ewallet/fund_management.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2a96fe8f44d9_53172000',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e765bc24ab9766784c4643e762716411610fa41c' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ewallet/fund_management.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/error_box.tpl' => 1,
  ),
),false)) {
function content_5f2a96fe8f44d9_53172000 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1522028635f2a96fe8ea450_36761921', 'script');
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8617307415f2a96fe8f3dd9_77319253', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block 'script'} */
class Block_1522028635f2a96fe8ea450_36761921 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

<?php echo '<script'; ?>
>
    jQuery(document).ready(function() {
        ValidateUser.init();
    });
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_8617307415f2a96fe8f3dd9_77319253 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display:none;">
    <span id="error_msg1"><?php echo lang('You_must_enter_user_name');?>
</span>
    <span id="error_msg2"><?php echo lang('Please_type_Amount');?>
</span>
    <span id="error_msg3"><?php echo lang('invalid_amount');?>
</span>
    <span id="validate_msg1"><?php echo lang('digits_only');?>
</span>
    <span id="validate_msg17"><?php echo lang('please_enter_transaction_concept');?>
</span>
    <span id="error_name"><?php echo lang('invalid_user_name');?>
</span>
</div>


<div class="m-b pink-gradient">
          <div class="card-body ">
            <div class="media">
              <figure class=" avatar-50 "> <i class="glyphicon glyphicon-book"></i> </figure>
              <div class="media-body">
                <h6 class="my-0"><?php echo lang('note_fund_credit_debit');?>
</h6>
              </div>
            </div>
          </div>
        </div>

   <div class="panel panel-default">
     <div class="panel-body">
      <?php echo form_open('/admin/post_fund_management','role="form" class="form" method="post"  name="fund_form" id="fund_form"');?>

        <input type="hidden" name="path" id="path" value="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
admin">
        <input type="hidden" name="fund1" id="fund1" value=""> <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

        <div class="form-group">
            <label class="required"><?php echo lang('user_name');?>
</label>
            <input class="form-control user_autolist" type="text" id="user_name" name="user_name" autocomplete="Off" /> <?php echo form_error('user_name');?>

        </div>
        <div class="form-group">
            <label class="required"><?php echo lang('amount');?>
</label>
            <div class="input-group <?php echo $_smarty_tpl->tpl_vars['input_group_hide']->value;?>
">
                <?php echo $_smarty_tpl->tpl_vars['left_symbol']->value;?>
 <?php echo $_smarty_tpl->tpl_vars['right_symbol']->value;?>

                <input type="text" class="form-control" id="amount" name="amount" maxlength="5">
            </div>
            <span id="errmsg1"></span> <?php echo form_error('amount');?>

        </div>
        <div class="form-group">
            <label class="required"><?php echo lang('transaction_note');?>
</label>
            <textarea class="form-control textfixed" name="tran_concept" rows="" placeholder="" id="tran_concept"></textarea> <?php echo form_error('tran_concept');?>

        </div>
        <div class="form-group ">
            <button class="btn btn-primary" name="add_amount" id="add_amount" type="submit" value="<?php echo lang('add_amount');?>
"> <?php echo lang('add_amount');?>
</button>

            <button class="btn btn-primary" name="deduct_amount" id="deduct_amount" type="submit" value="<?php echo lang('deduct_amount');?>
"> <?php echo lang('deduct_amount');?>
</button>
        </div>
        <?php echo form_close();?>

    </div>
</div>
    
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
