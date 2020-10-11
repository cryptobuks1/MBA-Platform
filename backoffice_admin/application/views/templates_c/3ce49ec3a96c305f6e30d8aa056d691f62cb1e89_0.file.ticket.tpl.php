<?php
/* Smarty version 3.1.30, created on 2020-08-05 22:07:34
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ticket_system/ticket.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2aa106924e84_36896595',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3ce49ec3a96c305f6e30d8aa056d691f62cb1e89' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/ticket_system/ticket.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f2aa106924e84_36896595 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_121785555f2aa1069230e1_64206568', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14499005065f2aa106924979_39688513', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_121785555f2aa1069230e1_64206568 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <span id="cmnt_msg" style="display:none"><?php echo lang('comment_added_successfully');?>
</span>
    <span id="err_msg" style="display:none"><?php echo lang('please_enter_comment');?>
</span>   
    <div class="panel panel-default table-responsive">
        <table st-table="rowCollectionBasic" class="table table-striped borderless">
            <tbody>
                <tr>
                    <td>Tracking ID</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['ticket']->value['ticket_id'];?>
</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr >
                    <td><?php echo lang('user_id');?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['ticket']->value['user'];?>
</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr >
                    <td><?php echo lang('subject');?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['ticket']->value['subject'];?>
</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?php echo lang('created_on');?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['ticket']->value['created_date'];?>
</td>
                    <td> </td>
                    <td></td>
                </tr>
                <tr>
                    <td><?php echo lang('updated');?>
</td>
                    <td><?php echo $_smarty_tpl->tpl_vars['ticket']->value['updated_date'];?>
</td>
                    <td></td>
                    <td></td>
                </tr>

                <tr>
                    <td><?php echo lang('ticket_status');?>
</td>
                    <td><span id='status_name'><?php echo $_smarty_tpl->tpl_vars['ticket']->value['status'];?>
</span></td>
                    <td style="text-align: right;"><label for="sel3"><?php echo lang('change_status_to');?>
 </label></td>
                    <td>
                        <div class="form-group">
                            <select class="form-control btn-xs w-sm " id="sel3" onchange="changeStatus(<?php echo $_smarty_tpl->tpl_vars['ticket']->value['id'];?>
);">
                                <option value="" ><?php echo lang('click_to_select');?>
</option>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ticket_status']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['status'];?>
</option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><?php echo lang('category');?>
</td>
                    <td><span id='category_name'><?php echo $_smarty_tpl->tpl_vars['ticket']->value['category'];?>
</span></td>
                    <td style="text-align: right;"><label for="sel2"><?php echo lang('change_category_to');?>
 </label></td>
                    <td>

                        <div class="form-group">
                            <select class="form-control btn-xs w-sm " id="sel2" onchange="changeCategory(<?php echo $_smarty_tpl->tpl_vars['ticket']->value['id'];?>
);">
                                <option value=""><?php echo lang('click_to_select');?>
</option>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ticket_category']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['category_name'];?>
</option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                            </select>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><?php echo lang('priority');?>
</td>
                    <td><span id='priority_name'><?php echo $_smarty_tpl->tpl_vars['ticket']->value['priority'];?>
</span></td>
                    <td style="text-align: right;"><label for="sel1"><?php echo lang('change_priority_to');?>
 </label></td>
                    <td>
                        <div class="form-group">
                            <select class="form-control btn-xs w-sm" id="sel1" onchange="changePriority(<?php echo $_smarty_tpl->tpl_vars['ticket']->value['id'];?>
);">
                                <option value=""><?php echo lang('click_to_select');?>
</option>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ticket_priority']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['priority'];?>
</option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                            </select>
                        </div>
                    </td>
                </tr>
                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['employee_status'] == 'yes') {?>
                <tr>
                    <td><?php echo lang('assignee');?>
 </td>
                    <td><span id='assignee_name'> <?php echo $_smarty_tpl->tpl_vars['ticket']->value['assignee'];?>
</span></td>
                    <td style="text-align: right;"><label for="sel1"><?php echo lang('change_assignee_to');?>
</label></td>
                    <td>
                        <div class="form-group">
                            <select class="form-control btn-xs w-sm" id="sel4" onchange="changeAssignee(<?php echo $_smarty_tpl->tpl_vars['ticket']->value['id'];?>
);">
                                <option value=""><?php echo lang('click_to_select');?>
</option>
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['employee_details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['user_id'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                            </select>
                        </div>
                    </td>
                </tr>
                <?php }?>
            </tbody>
            <tfoot> 
                <tr>
                    <td><?php echo lang('tags');?>
:</td> 
                    <td colspan="1">
                        <input id="activate_tagator2" type="text" class="tagator form-control" value="<?php echo $_smarty_tpl->tpl_vars['ticket']->value['tags'];?>
" data-tagator-show-all-options-on-focus="true" data-tagator-autocomplete="<?php echo $_smarty_tpl->tpl_vars['ticket_tags']->value;?>
">
                    </td>  
                    <td>
                        <button class="btn btn-bricky btn-primary" id="btn-update" onclick='updateTags(<?php echo $_smarty_tpl->tpl_vars['ticket']->value['id'];?>
);'><?php echo lang('update');?>
</button>
                        <span class="input-group-btn">
                        </span>
                    </td> 
                </tr>
            </tfoot>

        </table>
    </div>
    
    <div class="panel panel-default m-t">
        <div class="panel-body">
            <div class="row"> 
                <legend class="col-md-12">
                    <span class="fieldset-legend">
                        <?php echo lang('comment');?>

                    </span>
                </legend>
            
                <div class="col-xs-6 col-md-6">                       
                    <div class="col-md-12 col-xs-12"  id="comments_box">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ticket_comments']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                            <div class="messages m-t-xs">
                                <p><?php echo $_smarty_tpl->tpl_vars['v']->value['comment'];?>
</p>
                            </div>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </div>
                </div>
                <div class="col-sm-6"> 
                    <div class="input-group col-md-12 col-xs-12">
                        <textarea  id="comments" type="text" class="form-control input-sm chat_input" name='comments'></textarea>
                        <span id="added"></span>
                    </div>
                    <div class="input-group col-md-12 col-xs-12 m-t-sm">
                        <div data-provides="fileupload" class="fileupload fileupload-new">
                            <input type="hidden" id="base_url_id" value="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
"/>
                            <button class="btn btn-bricky btn-primary pull-right" id="btn-addcomment" onclick='addComments(<?php echo $_smarty_tpl->tpl_vars['ticket']->value['id'];?>
);'><?php echo lang('add');?>
</button>
                        </div>   
                    </div>
                </div>
            </div>
            <hr class="new_line">
            <div class="row"> 
                <legend class="col-md-12">
                    <span class="fieldset-legend">
                        <?php echo lang('reply');?>

                    </span>
                </legend>
                <div class="col-xs-6 col-md-6">
                    <div class="msg_container_base">
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ticket_replies']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                            <?php if ($_smarty_tpl->tpl_vars['ticket']->value['user_id'] == $_smarty_tpl->tpl_vars['v']->value['user_id']) {?>
                                <div class="row msg_container base_receive ">
                                    <div class="col-md-1 col-xs-1 avatar ">
                                        <img src='<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/<?php echo $_smarty_tpl->tpl_vars['v']->value['profile_pic'];?>
' class="img-responsive message-avatar">
                                    </div>
                                    <div class="col-md-10 col-xs-10">
                                        <div class="messages  msg_receive">
                                            <p><?php echo $_smarty_tpl->tpl_vars['v']->value['message'];?>
</p>
                                            <?php if ($_smarty_tpl->tpl_vars['v']->value['attachments']) {?>
                                                <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/ticket_system/<?php echo $_smarty_tpl->tpl_vars['v']->value['attachments'];?>
" target="_blank"><img src='<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/ticket_system/<?php echo $_smarty_tpl->tpl_vars['v']->value['attachments'];?>
' alt='' style="width: 35%;"></a>
                                            <?php }?>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <div class="row msg_container base_sent">
                                    <div class="col-md-10 col-xs-10">
                                        <div class="messages  msg_sent">
                                            <p><?php echo $_smarty_tpl->tpl_vars['v']->value['message'];?>
</p>               
                                            <?php if ($_smarty_tpl->tpl_vars['v']->value['attachments']) {?>
                                                <a href="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/ticket_system/<?php echo $_smarty_tpl->tpl_vars['v']->value['attachments'];?>
" target="_blank"><img src='<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/ticket_system/<?php echo $_smarty_tpl->tpl_vars['v']->value['attachments'];?>
' alt='' style="width: 35%;"></a> 
                                                <?php }?>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-xs-1 avatar ">
                                        <img src='<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/<?php echo $_smarty_tpl->tpl_vars['v']->value['profile_pic'];?>
' class="img-responsive  message-avatar">
                                    </div>
                                </div>
                            <?php }?>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    </div>
                </div>
                <div class="col-sm-6">
                    <?php echo form_open_multipart("admin/ticket_system/ticket/".((string)$_smarty_tpl->tpl_vars['ticket']->value['ticket_id']),'role="form" class=""  name="message" id="message" method="post" action="" enctype="multipart/form-data"');?>
 
                    <div class="panel-footer">
                        <div class="input-group col-md-12 col-xs-12">
                            <textarea  id="btn-input" type="text" class="form-control input-sm chat_input textfixed" name='message' id='message'>
                            </textarea>
                        </div>
                        <div class="input-group col-md-12 col-xs-12 m-t-sm">
                            <div data-provides="fileupload" class="fileupload fileupload-new">
                                <span class="btn btn-file btn-primary ticket-upload-btn"><i class="fa fa-paperclip"></i> <span class="fileupload-new"><?php echo lang('attach_file');?>
 </span><span class="fileupload-exists"><?php echo lang('change');?>
</span>
                                    <input type="file" id="upload_doc" name="upload_doc"  >
                                </span>
                                <span class="fileupload-preview"></span>
                                <a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="#"> ×
                                </a>
                                <button class="btn btn-bricky btn-info btn-right" type="submit" id="btn-chat" name="message_send"  id="message_send" value='ok'> <?php echo lang('send');?>
</button>
                                <span class="input-group-btn ">
                                </span>
                            </div>
                            <p>
                                <font color="#ff0000"><?php echo lang('kb');?>
(<?php echo lang('allowed_types_are_gif_jpg_png_jpeg_jpg');?>
)</font>
                            </p>    
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
class Block_14499005065f2aa106924979_39688513 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>
 
<?php echo '<script'; ?>
>
    $(function () {
        var $input_tagator1 = $('#input_tagator1');
        var $activate_tagator1 = $('#activate_tagator1');
        $activate_tagator1.click(function () {
            if ($input_tagator1.data('tagator') === undefined) {
                $input_tagator1.tagator({
                    autocomplete: ['first', 'second', 'third', 'fourth', 'fifth', 'sixth', 'seventh', 'eighth', 'ninth', 'tenth'],
                    useDimmer: true
                });
                $activate_tagator1.val('destroy tagator');
            } else {
                $input_tagator1.tagator('destroy');
                $activate_tagator1.val('activate tagator');
            }
        });
        $activate_tagator1.trigger('click');
    });
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
