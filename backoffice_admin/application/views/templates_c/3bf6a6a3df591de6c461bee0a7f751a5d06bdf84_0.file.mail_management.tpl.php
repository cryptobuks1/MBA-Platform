<?php
/* Smarty version 3.1.30, created on 2020-08-06 10:54:20
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/mail/mail_management.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2b54bc4dc3b2_56541131',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3bf6a6a3df591de6c461bee0a7f751a5d06bdf84' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/mail/mail_management.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/mail/mail_header.tpl' => 1,
    'file:layout/alert_box.tpl' => 1,
  ),
),false)) {
function content_5f2b54bc4dc3b2_56541131 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_20998290395f2b54bc4db7c4_47384767', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_20998290395f2b54bc4db7c4_47384767 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="span_js_messages" style="display:none;">
    <span id="confirm_msg"><?php echo lang('Sure_you_want_to_Delete_There_is_NO_undo');?>
</span>
</div>

    <input type="hidden" id="inbox_form" name="inbox_form" value="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
" />
    <div class="hbox hbox-auto-xs hbox-auto-sm" ng-controller="MailCtrl">
        <?php $_smarty_tpl->_subTemplateRender("file:admin/mail/mail_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
?>

          <div class="col">
            <div class="m-l-sm m-t-sm">
                <?php $_smarty_tpl->_subTemplateRender("file:layout/alert_box.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

                </div>
            <div>
            <!-- header -->
                <div class="wrapper bg-light lter b-b">
                      <div class="btn-group pull-left">
                            <a href="" class="btn btn-sm btn-bg btn-default panel-refresh" data-toggle="tooltip" data-placement="bottom" data-title="Refresh" data-original-title="" title=""><i class="fa fa-refresh"></i></a>
                      </div>
                      <div class="btn-toolbar">

                      </div>
                </div>  
            <!-- / header -->

            <!-- list -->
            <ul class="list-group list-group-lg no-radius   m-t-n-xxs">
              <?php $_smarty_tpl->_assignInScope('i', 0);
?>
              <?php $_smarty_tpl->_assignInScope('clr', '');
?>
              <?php $_smarty_tpl->_assignInScope('id', '');
?>
              <?php $_smarty_tpl->_assignInScope('msg_id', '');
?>
              <?php $_smarty_tpl->_assignInScope('user_name', '');
?>
              <?php $_smarty_tpl->_assignInScope('msg_tid', '');
?>
              <?php if ($_smarty_tpl->tpl_vars['cnt_adminmsgs']->value > 0) {?>
              <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['adminmsgs']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                      <?php if ($_smarty_tpl->tpl_vars['v']->value['type'] == 'contact') {?>
                          <?php $_smarty_tpl->_assignInScope('msg_tid', $_smarty_tpl->tpl_vars['v']->value['id']);
?>
                      <?php } else { ?>
                          <?php $_smarty_tpl->_assignInScope('msg_tid', $_smarty_tpl->tpl_vars['v']->value['thread']);
?>
                      <?php }?>
                      <?php if ($_smarty_tpl->tpl_vars['v']->value['read_msg'] == 'yes') {?>
                          <?php $_smarty_tpl->_assignInScope('id', $_smarty_tpl->tpl_vars['v']->value['id']);
?>     
                          <?php $_smarty_tpl->_assignInScope('user_name', $_smarty_tpl->tpl_vars['v']->value['user_name']);
?>  

                      <li class="list-group-item clearfix b-l-3x b-l-info">
                          <span class="avatar thumb pull-left m-r"> 
                            <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/mail_pro.png">
                          </span>
                          <?php $_smarty_tpl->_assignInScope('msg_id', $_smarty_tpl->tpl_vars['v']->value['id']);
?>
                          <div class="pull-right text-sm text-muted">
                            <span class="hidden-xs "><?php echo $_smarty_tpl->tpl_vars['v']->value['mailadiddate'];?>
</span>
                            <button type="button" class="btn-link text-danger" onclick="javascript:deleteMessage(<?php echo $_smarty_tpl->tpl_vars['msg_id']->value;?>
, this.parentNode.parentNode.rowIndex, '<?php echo $_smarty_tpl->tpl_vars['v']->value['type'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin')"><i class="fa fa-trash-o" ></i></button>
                          </div>
                          <div class="clear">
                            <div><span  class="text-md "><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</span></div>
                            <div class="text-ellipsis m-t-xs ">
                                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/mail/read_mail/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_type'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['mailadsubject'];?>
</a></div>
                          </div>      
                      </li>

                      <?php } else { ?>
                      <?php $_smarty_tpl->_assignInScope('id', $_smarty_tpl->tpl_vars['v']->value['id']);
?> 
                      <?php $_smarty_tpl->_assignInScope('user_name', $_smarty_tpl->tpl_vars['v']->value['user_name']);
?>

                      <li class="list-group-item clearfix b-l-3x b-l-info">
                          <span class="avatar thumb pull-left m-r">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/mail_pro.png">
                          </span>
                          <?php $_smarty_tpl->_assignInScope('msg_id', $_smarty_tpl->tpl_vars['v']->value['id']);
?>
                          <div class="pull-right text-sm text-muted">
                            <span class="hidden-xs "> <?php echo $_smarty_tpl->tpl_vars['v']->value['mailadiddate'];?>
</span>
                            <button type="button" class="btn-link  text-danger" onclick="javascript:deleteMessage(<?php echo $_smarty_tpl->tpl_vars['msg_id']->value;?>
, this.parentNode.parentNode.rowIndex, '<?php echo $_smarty_tpl->tpl_vars['v']->value['type'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin')" data-original-title="Delete"><i class="fa fa-trash-o"></i></button>
                          </div>
                          <div class="clear">
                              <div><span  class="text-md "><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</span><span class="label bg-primary m-l-sm "><?php echo lang('new');?>
</span></div>
                            <div class="text-ellipsis m-t-xs "><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/mail/read_mail/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_type'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['mailadsubject'];?>
</a></div>
                          </div>      
                      </li>
                      <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                          <?php }?>
                      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                      <?php } else { ?>
                        <li class="list-group-item clearfix b-l-3x b-l-info">
                          <center>
                            <?php echo lang('You_have_no_mails_in_inbox');?>
  
                          </center>
                        </li>
                      <?php }?>
                  </ul>
            <!-- / list -->
          <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

        </div>

      </div>
   
    </div>
 <style>
 ul.pagination {
    margin-top: 0px;
    float: right !important;
    margin-bottom: 51px;
}
</style>
     
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
