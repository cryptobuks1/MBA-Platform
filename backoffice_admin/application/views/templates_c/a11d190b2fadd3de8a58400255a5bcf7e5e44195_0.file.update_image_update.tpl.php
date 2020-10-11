<?php
/* Smarty version 3.1.30, created on 2020-08-17 13:18:33
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/home/update_image_update.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f39f709a032c1_70737647',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a11d190b2fadd3de8a58400255a5bcf7e5e44195' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/home/update_image_update.tpl',
      1 => 1583914922,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/error_box.tpl' => 1,
  ),
),false)) {
function content_5f39f709a032c1_70737647 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14992502605f39f709a01a32_58185112', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7192250085f39f709a02cd9_75939184', 'script');
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_14992502605f39f709a01a32_58185112 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="span_js_messages" style="display:none;">

   
    <span id="title_req"><?php echo lang('video_title_req');?>
</span>
    <span id="type_req"><?php echo lang('video_type_req');?>
</span>
    <span id="desc_req"><?php echo lang('desc_req');?>
</span>
    <span id="package_req"><?php echo lang('package_req');?>
</span>
</div>

<legend>
    
    <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/latest_updates" class="btn btn-addon btn-sm btn-info pull-right">
        <i class="fa fa-backward"></i>
        <?php echo lang('back');?>

    </a>
</legend>

<div class="panel panel-default">
    <div class="panel-body">
        <?php echo form_open_multipart('','role="form" class="" method="post" name="rank_form" id="rank_form"');?>

            <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                 <input type="hidden" name="id" id="id" class="form-control"  value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
">
                   <input type="hidden" name="image_name" id="image_name" class="form-control"  value="<?php echo $_smarty_tpl->tpl_vars['image_name']->value;?>
">
                 
       
            
            <div class="form-group">
                <label class="required"><?php echo lang('url');?>
</label>
             <input type="text" name="url" id="url" class="form-control" placeholder="https://www.google.com/" value="<?php echo $_smarty_tpl->tpl_vars['url']->value;?>
"></td>
                <?php echo form_error('url');?>

            </div>
            
             <div class="form-group">
                <label class="required"><?php echo lang('image');?>
</label>
                <input type="file" class="form-control" name="file" id="file"   value="" >
                <?php echo form_error('image');?>

            </div>
            
           
            <div class="form-group">
                
                    <button class="btn btn-sm btn-primary" name="video_update" type="submit" value="Update"><?php echo lang('update');?>
</button>
                    <input name="id" id="id" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" />
              
                <input type="hidden" id="path_temp" name="path_temp" value="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
">
            </div>
        <?php echo form_close();?>

    </div>
</div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_7192250085f39f709a02cd9_75939184 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

     <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/validate_rank.js" type="text/javascript" ><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
