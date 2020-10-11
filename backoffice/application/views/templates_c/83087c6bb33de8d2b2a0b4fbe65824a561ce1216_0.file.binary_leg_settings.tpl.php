<?php
/* Smarty version 3.1.30, created on 2020-09-25 17:04:44
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/tree/binary_leg_settings.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d968c7c22a4_78887242',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '83087c6bb33de8d2b2a0b4fbe65824a561ce1216' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/tree/binary_leg_settings.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d968c7c22a4_78887242 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17498633935f6d968c7c1755_78239500', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>
 <?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_17498633935f6d968c7c1755_78239500 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div id="span_js_messages" style="display: none;">
        <span id="error_msg2"><?php echo lang('you_must_select_an_amount');?>
</span>
        <span id="error_msg1"><?php echo lang('you_must_enter_count');?>
</span>    
        <span id="error_msg3"><?php echo lang('enter_digits_only');?>
</span>         
        <span id="row_msg"><?php echo lang('rows');?>
</span>
        <span id="show_msg"><?php echo lang('shows');?>
</span>
        <span id="error_msg4"><?php echo lang('Digit limit is five');?>
</span>
    </div>   
    <div class="button_back">
        <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/genology_tree"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i><?php echo lang('back');?>
</button></a>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo form_open('user/binary_leg_settings','role="form"  method="post" name="upload" id="upload" ');?>
 
            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label class="required" for="count"><?php echo lang('binary_leg');?>
</label>
                    <select class="form-control" id="binary_leg" name="binary_leg">
                        <?php if ($_smarty_tpl->tpl_vars['get_leg_settings']->value == 'any') {?>
                            <option value="any" <?php if ($_smarty_tpl->tpl_vars['get_leg_type']->value == 'any') {?> selected="" <?php }?> ><?php echo lang('any');?>
</option>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['get_leg_settings']->value == 'any' || $_smarty_tpl->tpl_vars['get_leg_settings']->value == 'left') {?>
                            <option value="left" <?php if ($_smarty_tpl->tpl_vars['get_leg_type']->value == 'left') {?> selected="" <?php }?>><?php echo lang('left');?>
</option>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['get_leg_settings']->value == 'any' || $_smarty_tpl->tpl_vars['get_leg_settings']->value == 'right') {?>
                            <option value="right" <?php if ($_smarty_tpl->tpl_vars['get_leg_type']->value == 'right') {?> selected="" <?php }?>><?php echo lang('right');?>
</option>
                        <?php }?>
                        <?php if ($_smarty_tpl->tpl_vars['get_leg_settings']->value == 'any') {?>
                            <option value="weak_leg" <?php if ($_smarty_tpl->tpl_vars['get_leg_type']->value == 'weak_leg') {?> selected="" <?php }?>><?php echo lang('weak_leg');?>
</option>
                        <?php }?>
                    </select>
                    <span id="errmsg"></span>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group credit_debit_button_1">
                    <button type="submit" class="btn btn-primary" name="submit" id="submit" value="submit" title="<?php echo lang('submit');?>
"><?php echo lang('submit');?>
</button>
                </div>
            </div>
            <?php echo form_close();?>
  
        </div>
    </div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
