<?php
/* Smarty version 3.1.30, created on 2020-08-21 20:34:11
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/news/add_faq.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f3fa3239840d9_79267531',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b61423ff7028a46d534545ec101064d4d7058669' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/news/add_faq.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f3fa3239840d9_79267531 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13204192625f3fa323982b01_47225812', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5105653855f3fa323983be1_76583682', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_13204192625f3fa323982b01_47225812 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div id="span_js_messages" style="display:none;">   
        <span id="error_msg2"><?php echo lang('qstn_req');?>
</span> 
        <span id="error_msg3"><?php echo lang('ans_req');?>
</span>    
        <span id="error_msg4"><?php echo lang('qstn_max');?>
</span>  
        <span id="error_msg5"><?php echo lang('ans_max');?>
</span>
        <span id="error_msg6"><?php echo lang('order_req');?>
</span>
        <span id="error_msg7"><?php echo lang('digits_only');?>
</span> 
        <span id="error_msg8"><?php echo lang('max_5');?>
</span> 
        <span id="error_msg9"><?php echo lang('digit_greater_than_0');?>
</span>
        <span id="validate_msg72"><?php echo lang('order_req');?>
</span>
        <span id="validate_msg27"><?php echo lang('checking_sort_order');?>
</span>
        <span id="validate_msg28"><?php echo lang('sort_order_not_available');?>
</span>
        <span id="validate_msg5"><?php echo lang('sort_order_available');?>
</span>
        <span id="confirm_msg">Do you want to delete this question?</span>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
          <?php echo form_open('','role="form" class="" method="post" name="faq" id="faq"');?>

            <input type="hidden" id="path_root" name="path_root" value="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
">
            <input type="hidden" id="path_temp" name="path_temp" value="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
"/>
            <div class="col-sm-12 padding_both_small">
                <div class="form-group">
                    <label class="control-label required" for="sort_order"><?php echo lang("sort_order");?>
</label>
                        <input type="text"  name="sort_order" id="sort_order"  class="form-control" autocomplete="Off">
                         <span id="checkmsg" class="error-img"></span>
                        <?php echo form_error('sort_order');?>

                </div>
            </div>
            <div class="col-sm-12 padding_both_small">
                <div class="form-group">
                    <label class="required"><?php echo lang('question');?>
</label>
                    <textarea name="question" id="question" autocomplete="Off" class="form-control textfixed"></textarea>
                    <?php echo form_error('question');?>

                </div>
            </div>
            <div class="col-sm-12 padding_both_small">
                <div class="form-group">
                    <label class="required"><?php echo lang('answer');?>
</label>
                    <textarea name="answer" id="answer" class="form-control textfixed"></textarea>
                    <?php echo form_error('answer');?>

                </div>
            </div>
            <div class="col-sm-12 padding_both_small">
                <button name="new_faq" type="submit" id="new_faq" class="btn btn-sm btn-primary" value="<?php echo lang('create');?>
"><?php echo lang('create');?>
</button>
            </div>
          <?php echo form_close();?>

        </div>
    </div>
    
    <div class="panel panel-default table-responsive">
        <div class="panel-body">
          <legend><span class="fieldset-legend">FAQ</span></legend> 
            <div class="errorHandler alert alert-warning">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <?php echo lang('faq_text');?>

            </div>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['faq']->value, 'item');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item']->value) {
?> 
                <div class="panel panel-default">
                    <a data-toggle="collapse" data-parent="#accordion" href="#<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
                        <div class="panel-heading"> 
                            <h4 class="panel-title"><?php echo $_smarty_tpl->tpl_vars['item']->value['order'];?>
.<?php echo $_smarty_tpl->tpl_vars['item']->value['question'];?>
<span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#filterPanel" id='close_icon' onclick='deleteFaq(this)' title='<?php echo lang('delete_this_question');?>
'><i class="icon-close"></i></span></h4>
                        </div>
                        <?php echo form_open('admin/news/delete_faq','class="" method="post" onsubmit="return confirmAction(\'confirm_msg\')"');?>

                        <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
                        <?php echo form_close();?>

                        <div id="<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
" class="panel-collapse panel-collapse collapse">
                            <div class="panel-body">
                                <?php echo $_smarty_tpl->tpl_vars['item']->value['answer'];?>

                            </div>
                        </div>
                    </a>
                </div>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </div>
    </div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_5105653855f3fa323983be1_76583682 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
/javascript/add_faq.js" type="text/javascript" ><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
