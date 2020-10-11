<?php
/* Smarty version 3.1.30, created on 2020-08-27 11:33:02
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/member/choose_default_legs.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f470d4ee4f308_11396311',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '279abcf6b0cb74218540352a7dcc32c1adb17a71' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/member/choose_default_legs.tpl',
      1 => 1571980561,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f470d4ee4f308_11396311 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20973257085f470d4ee4d969_72772561', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_79653965f470d4ee4ede3_69498926', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_20973257085f470d4ee4d969_72772561 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


    <div id="span_js_messages" style="display: none;">
        <span id="label_field_is_required"><?php echo lang('field_is_required');?>
</span>
        <span id="label_enter_valid_field"><?php echo lang('enter_valid_field');?>
</span>
        <span id="label_field_greater_than_zero"><?php echo lang('field_greater_than_zero');?>
</span>
        <span id="label_amount"><?php echo strtolower(lang('amount'));?>
</span>
    </div>

   <div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
               
                <?php echo lang('change_placement');?>

            </div>
            <div class="panel-body">
                <div class="col-md-12">
               
             
               <?php echo form_open('','role="form" class="smart-wizard form-horizontal form-inline" id="change_pass_admin" name="change_pass_admin"  method="post" ');?>

                    <div class="row">  
                        <div class="errorHandler alert alert-danger no-display">
                            <i class="fa fa-times-sign"></i> <?php echo lang('errors_check');?>
.
                        </div>
                    </div>
                <div class="row">  
                     <div class="col-sm-4 ">
                        <label class="control-label" for="new_pwd_admin"><?php echo lang('default_leg');?>
<font color="#ff0000">*</font></label>
                        <div class="">
                             <select tabindex="5" name="left_leg" id="left_leg" class="form-control" >   
                          
                                                <option value="L" <?php if ($_smarty_tpl->tpl_vars['leg_details']->value[0]['default_leg'] == 'L') {?>selected=""<?php }?>><?php echo lang('left_leg');?>
</option>
                                                <option value="R" <?php if ($_smarty_tpl->tpl_vars['leg_details']->value[0]['default_leg'] == 'R') {?>selected=""<?php }?> ><?php echo lang('right_leg');?>
</option>
                                                </select>
                        </div>

                    </div>
                    
                     <div class="col-sm-3">
                        <div class="" style="padding-top: 27px;">
                            <button class="btn btn-primary" type="submit" name="change_position" id="change_position" value="<?php echo lang('change_position');?>
" tabindex="4"><?php echo lang('update');?>
</button>
                        </div>
                    </div>
                </div>
                
                
                
                        <?php echo form_close();?>

                </div>
            </div>
        </div>
    </div>
</div>
    

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_79653965f470d4ee4ede3_69498926 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/purchase_wallet.js"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
