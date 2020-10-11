<?php
/* Smarty version 3.1.30, created on 2020-08-18 21:56:45
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/member/edit_video.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f3bc1fd7f8498_12894196',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0f4b7e99873c6f94eba45fd0aca039000a425709' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/member/edit_video.tpl',
      1 => 1584528556,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/error_box.tpl' => 1,
  ),
),false)) {
function content_5f3bc1fd7f8498_12894196 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13813489615f3bc1fd7f68a4_42872335', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8758353005f3bc1fd7f7ea7_54783163', 'script');
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_13813489615f3bc1fd7f68a4_42872335 extends Smarty_Internal_Block
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
        <span id="error_msg2"><?php echo lang('description_required');?>
</span> 
    <span id="error_msg3"><?php echo lang('video_title_required');?>
</span>
    <span id="error_msg6"><?php echo lang('sort_order_required');?>
</span>
      <span id="error_msg9"><?php echo lang('digit_greater_than_0');?>
</span>
       <span id="error_msg7"><?php echo lang('digits_only');?>
</span> 
</div>

<legend>
    
    <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/add_video" class="btn btn-addon btn-sm btn-info pull-right">
        <i class="fa fa-backward"></i>
        <?php echo lang('back');?>

    </a>
</legend>

<div class="panel panel-default">
    <div class="panel-body">
        <?php echo form_open('','role="form" class="" method="post" name="rank_form" id="rank_form"');?>

            <?php $_smarty_tpl->_subTemplateRender("file:layout/error_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

            <div class="form-group">
                <label class="required"><?php echo lang('video_type');?>
</label>
               <!-- <input type="text" class="form-control" name="video_type" id="video_type"   value="<?php echo $_smarty_tpl->tpl_vars['video_type']->value;?>
" >-->
                
                 <select  name="video_type" id="video_type" class="form-control">
                                     <option value="<?php echo $_smarty_tpl->tpl_vars['video_type']->value;?>
"><?php echo lang($_smarty_tpl->tpl_vars['video_type']->value);?>
</option>  
                                    <option value="normal"><?php echo lang('normal');?>
</option>   
                                    <option value="get_started"><?php echo lang('get_started');?>
</option>
                                    <option value="live_session"><?php echo lang('live_session');?>
</option>   
                                    <option value="grow_your_business"><?php echo lang('grow_your_business');?>
</option>
                                
                                </select>
                <?php echo form_error('video_type');?>

            </div>
            <div class="form-group">
                <label class="required"><?php echo lang('title');?>
</label>
                <input type="text" class="form-control" name="title" id="title"   value="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
" >
                <?php echo form_error('title');?>

            </div>
             <div class="form-group">
                <label class="required"><?php echo lang('video_description');?>
</label>
                <input type="text" class="form-control" name="video_description" id="video_description"   value="<?php echo $_smarty_tpl->tpl_vars['video_description']->value;?>
" >
                <?php echo form_error('video_description');?>

            </div>
            
                <div class="form-group">
                <label class="required"><?php echo lang('video_link');?>
</label>
                <input type="text" class="form-control" name="video_link" id="video_link"   value="<?php echo $_smarty_tpl->tpl_vars['video_link']->value;?>
" >
                <?php echo form_error('video_link');?>

            </div>
            
              <div class="form-group">
                       <label class=""><?php echo lang('package_type');?>
</label>
                        
                            <div class="input-group" style="width: 100% !important;">
                                <select  name="package_type[]" id="package_type" class="form-control" >
                                    
                                   <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['package']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>                                 
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['module_id'];?>
"><?php echo lang($_smarty_tpl->tpl_vars['v']->value['video_module_name']);?>
</option>                      
                                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                                </select>
                            </div>
                        <?php echo form_error('package_type');?>

                    </div>
                   
            <!--<div class="form-group">
                <label class="required"><?php echo lang('sort_order');?>
</label>
                <input type="text" class="form-control" name="sort_order" id="sort_order"   value="<?php echo $_smarty_tpl->tpl_vars['sort_order']->value;?>
" >
                <?php echo form_error('sort_order');?>

            </div>-->
           
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
class Block_8758353005f3bc1fd7f7ea7_54783163 extends Smarty_Internal_Block
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
        <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/add_video.js" type="text/javascript" ><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
