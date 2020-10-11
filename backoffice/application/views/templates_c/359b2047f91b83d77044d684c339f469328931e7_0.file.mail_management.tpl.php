<?php
/* Smarty version 3.1.30, created on 2020-09-25 17:48:41
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/mail/mail_management.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6da0d980e056_35286711',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '359b2047f91b83d77044d684c339f469328931e7' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/mail/mail_management.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:user/mail/mail_header.tpl' => 1,
    'file:layout/alert_box.tpl' => 1,
  ),
),false)) {
function content_5f6da0d980e056_35286711 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2775178055f6da0d980d167_79194140', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_2775178055f6da0d980d167_79194140 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

 <div id="span_js_messages" style="display:none;">
            <span id="confirm_msg"><?php echo lang('Sure_you_want_to_Delete_There_is_NO_undo');?>
</span>
        </div>


    <div class="hbox hbox-auto-xs hbox-auto-sm" ng-controller="MailCtrl">
        <?php $_smarty_tpl->_subTemplateRender("file:user/mail/mail_header.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('name'=>''), 0, false);
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
             <ul class="list-group list-group-lg no-radius m-t-n-xxs">
              <?php $_smarty_tpl->_assignInScope('i', 1);
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

              <?php if ($_smarty_tpl->tpl_vars['cnt_mails']->value > 0) {?>
                  <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['row']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['type'] == 'contact') {?>
                        <?php $_smarty_tpl->_assignInScope('msg_tid', $_smarty_tpl->tpl_vars['v']->value['mailtousid']);
?>
                    <?php } else { ?>
                        <?php $_smarty_tpl->_assignInScope('msg_tid', $_smarty_tpl->tpl_vars['v']->value['thread']);
?>
                    <?php }?>
                      <?php if ($_smarty_tpl->tpl_vars['v']->value['read_msg'] == 'yes') {?>
                           <?php $_smarty_tpl->_assignInScope('id', $_smarty_tpl->tpl_vars['v']->value['mailtousid']);
?>      
                          <li class="list-group-item clearfix b-l-3x b-l-info">
                              <span class="avatar thumb pull-left m-r">
                                <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/mail_pro.png">
                              </span>

                              <?php if ($_smarty_tpl->tpl_vars['v']->value['type'] == "user" || $_smarty_tpl->tpl_vars['v']->value['type'] == "admin") {?>
                                <?php $_smarty_tpl->_assignInScope('thread', $_smarty_tpl->tpl_vars['v']->value['thread']);
?>
                                <?php $_smarty_tpl->_assignInScope('msg_id', $_smarty_tpl->tpl_vars['v']->value['mailtousid']);
?>

                              <div class="pull-right text-sm text-muted">
                                <span class="hidden-xs "><?php echo $_smarty_tpl->tpl_vars['v']->value['mailtousdate'];?>
</span>
                                  <?php $_smarty_tpl->_assignInScope('msg_id', $_smarty_tpl->tpl_vars['v']->value['mailtousid']);
?>       
                                  <button type="button" class="btn-link text-danger btn-md" onclick="javascript:deleteMessage(<?php echo $_smarty_tpl->tpl_vars['thread']->value;?>
, this.parentNode.parentNode.rowIndex, '<?php echo $_smarty_tpl->tpl_vars['v']->value['type'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user')" data-original-title="Delete"><i class="fa fa-trash-o" ></i></button>
                              </div> 

                              <div class="clear">
                                <?php if ($_smarty_tpl->tpl_vars['v']->value['flag']) {?><div><span class="text-md "><?php echo $_smarty_tpl->tpl_vars['v']->value['from_user_name'];?>
</span></div><?php }?>
                                <div class="text-ellipsis m-t-xs "><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/mail/read_mail/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_type'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_thread'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['mailtoussub'];?>
</a></div>
                              </div>  
                              <?php } else { ?>
                                <?php $_smarty_tpl->_assignInScope('msg_id', $_smarty_tpl->tpl_vars['v']->value['mailtousid']);
?>
                                  <div class="pull-right text-sm text-muted">
                                    <span class="hidden-xs "><?php echo $_smarty_tpl->tpl_vars['v']->value['mailtousdate'];?>
</span>
                                      <button type="button" class="btn-link text-danger btn-md" onclick="javascript:deleteMessage(<?php echo $_smarty_tpl->tpl_vars['msg_id']->value;?>
, this.parentNode.parentNode.rowIndex, '<?php echo $_smarty_tpl->tpl_vars['v']->value['type'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user')" data-original-title="Delete"><i class="fa fa-trash-o" ></i></button>
                                  </div>
                                 <div class="clear">
                                <?php if ($_smarty_tpl->tpl_vars['v']->value['flag']) {?><div><span class="text-md " ><?php echo $_smarty_tpl->tpl_vars['v']->value['from_user_name'];?>
</span></div><?php }?>
                                <div class="text-ellipsis m-t-xs "><a  href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/mail/read_mail/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_type'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['mailtoussub'];?>
</a></div>
                              </div>  
                              <?php }?>
                          </li>
                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?> 
                      <?php } else { ?>
                        <?php $_smarty_tpl->_assignInScope('id', $_smarty_tpl->tpl_vars['v']->value['mailtousid']);
?> 

                        <li class="list-group-item clearfix b-l-3x b-l-info">
                          <span class="avatar thumb pull-left m-r">
                            <img src="<?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
/uploads/images/profile_picture/mail_pro.png">
                          </span>
                          <?php if ($_smarty_tpl->tpl_vars['v']->value['type'] == "user" || $_smarty_tpl->tpl_vars['v']->value['type'] == "admin") {?>
                            <?php $_smarty_tpl->_assignInScope('thread', $_smarty_tpl->tpl_vars['v']->value['thread']);
?>
                            <?php $_smarty_tpl->_assignInScope('msg_id', $_smarty_tpl->tpl_vars['v']->value['mailtousid']);
?>
                              <div class="pull-right text-sm text-muted">
                                <span class="hidden-xs "> <?php echo $_smarty_tpl->tpl_vars['v']->value['mailtousdate'];?>
</span>
                                <button type="button" class="btn-link text-danger btn-md" onclick="javascript:deleteMessage('<?php echo $_smarty_tpl->tpl_vars['thread']->value;?>
', this.parentNode.parentNode.rowIndex, '<?php echo $_smarty_tpl->tpl_vars['v']->value['type'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user')" data-original-title="Delete"><i class="fa fa-trash-o" ></i></button>
                              </div>
                              <div class="clear">
                                  <div><span  class="text-md "><?php echo $_smarty_tpl->tpl_vars['v']->value['from_user_name'];?>
</span><span class="label bg-primary m-l-sm "><?php echo lang('new');?>
</span></div>
                                  <div class="text-ellipsis m-t-xs "><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/mail/read_mail/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_type'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_thread'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['mailtoussub'];?>
</a></div>
                              </div>
                          <?php } else { ?>
                            <?php $_smarty_tpl->_assignInScope('msg_id', $_smarty_tpl->tpl_vars['v']->value['mailtousid']);
?>
                              <div class="pull-right text-sm text-muted">
                                <span class="hidden-xs "> <?php echo $_smarty_tpl->tpl_vars['v']->value['mailtousdate'];?>
</span>
                                <button type="button" class="btn-link text-danger btn-md" onclick="javascript:deleteMessage(<?php echo $_smarty_tpl->tpl_vars['msg_id']->value;?>
, this.parentNode.parentNode.rowIndex, '<?php echo $_smarty_tpl->tpl_vars['v']->value['type'];?>
', '<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user')" data-original-title="Delete"><i class="fa fa-trash-o" ></i></button>
                              </div>
                              <div class="clear">
                                  <div><span  class="text-md "><?php echo $_smarty_tpl->tpl_vars['v']->value['from_user_name'];?>
</span><span class="label bg-primary m-l-sm "><?php echo lang('new');?>
</span></div>
                                  <div class="text-ellipsis m-t-xs "><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/mail/read_mail/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_id'];?>
/<?php echo $_smarty_tpl->tpl_vars['v']->value['mail_enc_type'];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['mailtoussub'];?>
</a></div>
                              </div>
                          <?php }?>  
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
         <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

         <!-- / list -->
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
