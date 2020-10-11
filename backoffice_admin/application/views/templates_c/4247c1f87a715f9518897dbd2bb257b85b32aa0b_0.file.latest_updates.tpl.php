<?php
/* Smarty version 3.1.30, created on 2020-08-17 13:18:26
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/home/latest_updates.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f39f702acc984_63033772',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4247c1f87a715f9518897dbd2bb257b85b32aa0b' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/home/latest_updates.tpl',
      1 => 1583916900,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f39f702acc984_63033772 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_function_counter')) require_once '/home/mbatradingacadem/public_html/office/backoffice_admin/application/third_party/Smarty/plugins/function.counter.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17723133925f39f702ab50c7_51882220', "script");
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_15241277175f39f702acbf44_59409893', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block "script"} */
class Block_17723133925f39f702ab50c7_51882220 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>
 <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/validate_edit_profile.js"><?php echo '</script'; ?>
>
     <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/validate_rank_configuration.js"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block "script"} */
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_15241277175f39f702acbf44_59409893 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

     <div id="span_js_messages" style="display:none;">
<span id="confirm_inactivate"><?php echo lang('sure_you_want_to_inactivate');?>
</span>
<span id="confirm_activate"><?php echo lang('sure_you_want_to_activate');?>
</span>
   
</div>

    <div class="panel panel-default">
        <?php if ($_smarty_tpl->tpl_vars['banner_count']->value == 0) {?>
        <div class="panel-body">
            <?php echo form_open_multipart('admin/home/upload_banner','role="form" class="" name= ""  id=""');?>

            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="control-label pro-label"><?php echo lang('Banner_update');?>
</label>
                    <div data-provides="" class=" ">
                        <input name="file3" id="file3" type="file">
                        <label><?php echo lang('select_file');?>
</label>
                    </div>
                </div>
            </div>
             <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label><?php echo lang('url');?>
</label>
                    <input type="text" name="bannerurl" id="bannerurl" class="form-control" placeholder="https://www.google.com/">
                </div>
            </div>
                    
            <div class="col-sm-3 padding_both_small">
                <div class="form-group mark_paid">
                    <button type="submit" class="btn btn-sm btn-primary"><?php echo lang('add');?>
</button>
                </div>
            </div>  
              
        </div>
          <?php }?>
            <div class="panel-body">
            <?php echo form_open_multipart('admin/home/upload_latest_updates','role="form" class="" name= "edit_profile"  id="edit_profile"');?>

            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="control-label pro-label"><?php echo lang('mba_update_page');?>
</label>
                    <div data-provides="fileupload" class="bg_file_upload pro_file_upload">
                        <input name="file1" id="file1" type="file">
                        <label><?php echo lang('select_file');?>
</label>
                    </div>
                </div>
            </div>
             <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label><?php echo lang('url');?>
</label>
                    <input type="text" name="url" id="url" class="form-control" placeholder="https://www.google.com/">
                </div>
            </div>
                    
            <div class="col-sm-3 padding_both_small">
                <div class="form-group mark_paid">
                    <button type="submit" class="btn btn-sm btn-primary"><?php echo lang('add');?>
</button>
                </div>
            </div>  
              
        </div>

    </div>
    
    <div class="panel panel-default">
        <div class="panel-body">
            <legend><span class="fieldset-legend"><?php echo lang('upload_list');?>
</span>
                
            </legend>
            <div>
                   <div class="panel panel-default table-responsive">
                        <?php if ($_smarty_tpl->tpl_vars['banner_count']->value > 0) {?>
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                               
                                <th><?php echo lang('banner');?>
</th>
                                <th><?php echo lang('url');?>
</th>
                                <th><?php echo lang('edit');?>
</th>
                                <th><?php echo lang('action');?>
</th>
                               
                            </tr>
                        </thead>
                        
                        <tbody>
                        <?php $_smarty_tpl->_assignInScope('path', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."admin/");
?>
                       
                       
                                <tr>
                                    <td><img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/latest_uploads/<?php echo $_smarty_tpl->tpl_vars['banner']->value['image_name'];?>
" style="height: 150px; width:200px;"/></td>  
                                    <td><input type="text" name="url2" id="url2" class="form-control" placeholder="https://www.google.com/" value="<?php echo $_smarty_tpl->tpl_vars['banner']->value['url'];?>
"></td>
                                    <td> 
                                    <input name="file2" id="file2" type="file">
                                   
                                    </td>
                                    <td> <button type="submit" class="btn btn-sm btn-primary"><?php echo lang('update');?>
</button></td>
                                    </tr>
               
                        </tbody>
                        
                    </table>
              
                <?php } else { ?>
        <h4 align="center"><?php echo lang('no_bannerrs');?>
</h4>
<?php }?>
                </div>
                    <?php echo form_close();?>

                    <div class="panel panel-default table-responsive">
                    <?php if ($_smarty_tpl->tpl_vars['count']->value > 0) {?>
                    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th><?php echo lang('sl_no');?>
</th>
                                <th><?php echo lang('image');?>
</th>
                                  <th><?php echo lang('url');?>
</th>
                              
                              <!--  <th><?php echo lang('status');?>
</th>-->
                                <th><?php echo lang('action');?>
</th>
                                <th><?php echo lang('Inactive');?>
</th>
                               
                            </tr>
                        </thead>
                        
                        <tbody>
                        <?php $_smarty_tpl->_assignInScope('path', ((string)$_smarty_tpl->tpl_vars['BASE_URL']->value)."admin/");
?>
                        
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['image_details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                <tr>
                                    <td><?php echo smarty_function_counter(array(),$_smarty_tpl);?>
</td>
                                    <td><img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/latest_uploads/<?php echo $_smarty_tpl->tpl_vars['v']->value['image_name'];?>
" style="height: 150px; width:200px;"/></td> 
                                      <td><input type="text" name="url_image" id="url_image" class="form-control" placeholder="https://www.google.com/" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['url'];?>
" readonly></td>
                                   
                                  
                                   
                                   <td>  <a href="<?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
admin/home/update_image_update/<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
" onclick="return confirm('Do u want to edit?')"  title="Enable" class="has-tooltip btn-link btn_size text-info">
                                     <i class="fa fa-edit"></i> </a></td> <!--<td><?php echo lang($_smarty_tpl->tpl_vars['v']->value['status']);?>
</td>-->
                                    <td class="ipad_button_table">
                                        <?php if ($_smarty_tpl->tpl_vars['v']->value['status'] == "active") {?>
                                            
                                            <button class="btn-link btn_size has-tooltip text-info inactivate_membership_package" onclick="inactivate_image(<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
, '<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
')" title="<?php echo lang('inactivate');?>
"><i class="fa fa-ban"></i></button>
                                        <?php } else { ?>
                                            <button class="has-tooltip btn-link btn_size text-info" onclick="activate_image(<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
, '<?php echo $_smarty_tpl->tpl_vars['path']->value;?>
')" title="<?php echo lang('activate');?>
"><i class="icon-check"></i></button>
                                        <?php }?>
                                    </td>
                                </tr>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                       
                        </tbody>
                        
                    </table>
                     <?php } else { ?>
                <div class="panel-body"><?php echo lang('no_uploads');?>
</div>
            
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
