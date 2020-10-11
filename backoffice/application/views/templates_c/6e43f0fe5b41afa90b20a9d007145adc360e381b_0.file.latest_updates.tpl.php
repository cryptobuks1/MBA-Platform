<?php
/* Smarty version 3.1.30, created on 2020-09-25 14:33:30
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/home/latest_updates.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d731abe3c98_43340041',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6e43f0fe5b41afa90b20a9d007145adc360e381b' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/home/latest_updates.tpl',
      1 => 1577954616,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d731abe3c98_43340041 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17780274755f6d731abe3290_58897952', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<style>

</style>
  
     
  <?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_17780274755f6d731abe3290_58897952 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display: none;"> <span id="left_join"><?php echo lang('left_join');?>
</span> <span id="right_join"><?php echo lang('right_join');?>
</span> <span id="join"><?php echo lang('joinings');?>
</span> <span id="confirm_msg"><?php echo lang('are_you_sure_want_delete');?>
</span> </div>
   <?php if ($_smarty_tpl->tpl_vars['banner_count']->value > 0) {?>
  <div class="fb-profile"> <a href="" class="wall-img-edit-btn"></a> 
  <a target="_blank" href="https://<?php echo $_smarty_tpl->tpl_vars['banner']->value[0]['url'];?>
">
  <img align="left" class="fb-image-lg" src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/latest_uploads/<?php echo $_smarty_tpl->tpl_vars['banner']->value[0]['image_name'];?>
"/></a>
                <div class="edit_button"> </div>
                <div class="col-sm-9">
                </div>
                <div class="col-sm-12">
                </div>
 </div>
  <?php } else { ?>
        <h4 align="center"><?php echo lang('no_uploads');?>
</h4>
<?php }?>
 
            <?php if ($_smarty_tpl->tpl_vars['count']->value > 0) {?>
             <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['image_det']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
          <div class="panel panel-default">
                <div class="col-lg-4">
                      
                        <div class="panel-body">
                            <div class="clearfix text-center">
                                <div class="inline">
                                    <a target="_blank" href="https://<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
"> <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/latest_uploads/<?php echo $_smarty_tpl->tpl_vars['v']->value['image_name'];?>
" style="height: 200px;"/></a>
                                </div>
                            </div>
                        </div>
                    
                   
                </div></div>
               <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
  
   
    
<?php }
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
