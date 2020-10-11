<?php
/* Smarty version 3.1.30, created on 2020-09-25 14:34:04
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/news/faq.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d733c445d23_64389340',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '579d3c23d3f03a892dff1bcf2e50cc1fbe1d116e' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/news/faq.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d733c445d23_64389340 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18650342765f6d733c445419_89469133', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_18650342765f6d733c445419_89469133 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span>
        <span class="sr-only">Close</span></button>
    <?php echo lang("answer_to_some_faq_about");?>
 <strong><?php echo $_smarty_tpl->tpl_vars['COMPANY_NAME']->value;?>
</strong>. <?php echo lang('if_canot_find_answer');?>

    </div>
    <?php if (count($_smarty_tpl->tpl_vars['faq']->value) != 0) {?>
    <?php $_smarty_tpl->_assignInScope('path', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."admin/");
?>
    <?php $_smarty_tpl->_assignInScope('i', 0);
?>
    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['faq']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
   
        <div class="panel panel-default">
         <div class="panel-body">
            <div class="panel-heading">
             <a data-toggle="collapse" data-parent="#accordion" href="#tab<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
">
                <h4 class="panel-title"><?php echo $_smarty_tpl->tpl_vars['v']->value['order'];?>
.<?php echo $_smarty_tpl->tpl_vars['v']->value['question'];?>
 
                <span class="pull-right panel-collapse-clickable" data-toggle="collapse" data-parent="#accordion" href="#filterPanel"> <i class="glyphicon glyphicon-chevron-down"></i> 
                </span> </h4></a>
            </div>

            <div id="tab<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" class="panel-collapse panel-collapse collapse">
                <div class="panel-body"><?php echo $_smarty_tpl->tpl_vars['v']->value['answer'];?>
</div>
            </div>
        </div>
        </div>
    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

    <?php } else { ?>
    <h4 align="center"><?php echo lang('no_faq');?>
</h4>
    <?php }
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
