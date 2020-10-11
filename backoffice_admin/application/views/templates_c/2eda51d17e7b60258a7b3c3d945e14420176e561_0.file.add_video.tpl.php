<?php
/* Smarty version 3.1.30, created on 2020-08-05 20:45:36
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/member/add_video.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2a8dd0d1df43_72065316',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2eda51d17e7b60258a7b3c3d945e14420176e561' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/member/add_video.tpl',
      1 => 1584529194,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f2a8dd0d1df43_72065316 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4700242925f2a8dd0d1bf70_33561503', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

 
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15074857505f2a8dd0d1da35_65272143', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_4700242925f2a8dd0d1bf70_33561503 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

   
<div id="span_js_messages" style="display: none;"> 
    
    <span id="confirm_msg_edit_video"><?php echo lang('confirm_msg_edit_video');?>
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
    <span id="validate_msg28"><?php echo lang('sort_order_not_available');?>
</span>
    <span id="validate_msg5"><?php echo lang('sort_order_available');?>
</span>
    <span id="validate_msg27"><?php echo lang('checking_sort_order');?>
</span>
    
</div>
    
        <div class="panel panel-default">
            <div class="tab">
                <div class="content">
                    <?php echo form_open_multipart('admin/member/vimeo_upload','role="form" class="smart-wizard form-horizontal"  name="video" id="video"');?>

                    
<input type="hidden" id="path_root" name="path_root" value="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
">
<input type="hidden" id="path_temp" name="path_temp" value="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
"/>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="video_title">
                            <?php echo lang('video_title');?>
<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input  type="text"  class="form-control" name="video_title" id="video_title"  autocomplete="Off" tabindex="4" value=""  >
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="video">
                            <?php echo lang('video_file');?>

                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input class="" type="file" name="video" id="video"  value=""  tabindex="3" > </input>
                            </div>
                        </div>
                          <span class="symbol required" >Note: Please select Video File or Video link to Upload videos</span>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="video_link">
                            <?php echo lang('video_link');?>

                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input  class="form-control" type="text" name="video_link" id="video_link"  value=""  tabindex="3" > </input>
                            </div>
                        </div>
                    </div>
                    
                    
                    <!--<div class="form-group">
                        <label class="col-sm-2 control-label" for="from_date">
                            <?php echo lang('poster');?>
<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input class="" type="file" name="poster" id="poster"  value=""  tabindex="3" required> </input>
                            </div>
                        </div>
                        <p class="help-block">
                                   <?php echo lang('files');?>
<span class="symbol required"></span> 
                                </p>
                    </div>-->

              

                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="type">
                            <?php echo lang('package_type');?>

                        </label>
                        <div class="col-sm-3"> 
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
                        </div>
                    </div>
                    
                    
                <div class="form-group">
                        <label class="col-sm-2 control-label" for="type">
                            <?php echo lang('video_type');?>

                        </label>
                        <div class="col-sm-3"> 
                            <div class="input-group" style="width: 100% !important;">
                                <select  name="video_type" id="video_type" class="form-control">
                                    
                                       <option value="normal"><?php echo lang('normal');?>
</option>   
                                    <option value="get_started"><?php echo lang('get_started');?>
</option>
                                    <option value="live_session"><?php echo lang('live_session');?>
</option>   
                                    <option value="grow_your_business"><?php echo lang('grow_your_business');?>
</option>
                                
                                </select>
                            </div>
                        </div>
                    </div>
                    
                                          <div class="form-group">
                        <label class="col-sm-2 control-label" for="sort_order">
                            <?php echo lang('sort_order');?>
<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input  type="text"  class="form-control" name="sort_order" id="sort_order"  autocomplete="Off" tabindex="4" value=""  >
                                 <span id="checkmsg" class="error-img"></span>
                                   <?php echo form_error('sort_order');?>

                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="video_description">
                            <?php echo lang('video_description');?>
<span class="symbol required"></span>
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                            <textarea rows="4" cols="50" name="video_description" id="video_description">
                            </textarea>
                            
                            </div>
                        </div>
                    </div>


                          <div class="form-group">
                        <label class="col-sm-2 control-label" for="from_date">                            
                        </label>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <button class="btn btn-bricky" type="submit" name="submit" id="submit"  value=""  tabindex="3"> <?php echo lang('add_video_details');?>
 </button>
                            </div>
                        </div>
                    </div>
            

                    
                    
                 
                    
                    <?php echo form_close();?>

            </div>
        </div>
    </div>
            <div class="panel panel-default">
            <div class="tab" style="overflow-x:auto;">
                   <?php if (count($_smarty_tpl->tpl_vars['videos']->value) > 0) {?>
                   
               <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('sl_no');?>
</th>
                                <th><?php echo lang('video_type');?>
</th>
                                <th><?php echo lang('title');?>
</th>
                                 <th><?php echo lang('description');?>
</th>
                                   <th><?php echo lang('sort_order');?>
</th>
                                 
                                <th><?php echo lang('package');?>
</th>
                                <th><?php echo lang('action');?>
</th>
                                
                               
                            </tr>
                        </thead>
                        
                        <tbody>
                        <?php $_smarty_tpl->_assignInScope('path', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."admin/");
?>
                        <?php $_smarty_tpl->_assignInScope('i', 1);
?>
                       <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['videos']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        
                                <tr>
                                    <td><?php echo $_smarty_tpl->tpl_vars['i']->value+$_smarty_tpl->tpl_vars['start']->value;?>
</td>
                                    <td><?php echo lang($_smarty_tpl->tpl_vars['v']->value['video_type']);?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['title'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['video_description'];?>
</td>
                                    <td><?php echo $_smarty_tpl->tpl_vars['v']->value['sort_order'];?>
</td>
                                     <td><?php echo $_smarty_tpl->tpl_vars['v']->value['package_name'];?>
</td>
                                     <?php if ($_smarty_tpl->tpl_vars['v']->value['delete_status'] == 'no') {?>
                                    <td> 
                                    <button class="btn-link btn_size has-tooltip text-info" onclick="edit_video(<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
, '<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
')" title="<?php echo lang('edit');?>
"> <i class="fa fa-edit"></i></button>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
admin/member/disable_enable_video/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
/disable" title="Disable" class="btn-link btn_size has-tooltip text-info">
                                      <i class="fa fa-ban"></i> </a>
                                    <!-- <a href="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
admin/member/disable_enable_video/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
/delete" onclick="return confirm('Do u want to Delete the Video?')" title="Delete" class="btn-link btn_size has-tooltip text-info">
                                      <i class="fa fa-trash"></i> </a> -->
                                    </td>
                                    <?php } else { ?>
                                    <td>
                                    <a href="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
admin/member/disable_enable_video/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
/enable" onclick="return confirm('Do u want to Disable or Enable the Video?')"  title="Enable" class="has-tooltip btn-link btn_size text-info">
                                      <i class="icon-check"></i> </a>
                                       <!--<a href="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
admin/member/disable_enable_video/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
/delete" onclick="return confirm('Do u want to Delete the Video?')" title="Delete" class="btn-link btn_size has-tooltip text-info">
                                      <i class="fa fa-trash"></i> </a> -->
                                    </td>
                                    <?php }?>
                                    
                                </tr>
                               <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                        </tbody>
                         <?php } else { ?>
                <h4 align="center">
                    <font><?php echo lang('no_data');?>
</font>
                </h4>
            <?php }?>
                    </table>
                    
     
          </div>
        </div>
      
    
    

 <?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_15074857505f2a8dd0d1da35_65272143 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

   
      <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/validate_rank_configuration.js" type="text/javascript" ><?php echo '</script'; ?>
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
