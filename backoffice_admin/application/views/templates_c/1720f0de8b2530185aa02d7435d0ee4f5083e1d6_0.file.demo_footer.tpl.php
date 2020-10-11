<?php
/* Smarty version 3.1.30, created on 2020-09-16 22:22:14
  from "/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/layout/demo_footer.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f620376102350_37833709',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1720f0de8b2530185aa02d7435d0ee4f5083e1d6' => 
    array (
      0 => '/Users/henryhardy/Development/MBA/MBA_Platform/platform/backoffice_admin/application/views/layout/demo_footer.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f620376102350_37833709 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!----demo-->
<?php if (DEMO_STATUS == "yes") {?>
<div class="panel-body setting_margin  demo_margin_top" id="demo_footer">
  <div class="m-b-xxl">
    <div class="panel no-border">
      <div class="wrapper-md">
        <div class="row">
          <?php if ($_smarty_tpl->tpl_vars['is_preset_demo']->value) {?>               
            <div class="col-md-6">
              <p><i class="fa fa-check-circle"></i> You are viewing shared demo. Multiple users may try this demo simultaneously.</p>
              <p><i class="fa fa-check-circle"></i> Try  <a class="text-primary" href="https://infinitemlmsoftware.com/register.php" target="_blank">custom demo </a>as per your configurations.</p>
            </div>
          <?php } else { ?> 
            <div class="col-md-6">
              <p><i class="fa fa-check-circle"></i> Custom demo will be automatically deleted after 48 hours unless upgraded.</p>
              <p><i class="fa fa-check-circle"></i> You can upgrade custom demo to one month or can purchase the software.</p>
            </div>   
          <?php }?>
          <div class="col-md-6 b-l">
            <p><i class="fa fa-check-circle"></i> Once the demo is ready, you can simply move the demo to your own domain name.</p>
            <?php if ($_smarty_tpl->tpl_vars['LOG_USER_TYPE']->value == 'admin') {?><p><i class="fa fa-check-circle"></i> Click here to place a 
            <a class="text-primary" href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/revamp/send_feedback" target="_blank">Feedback For Support </a></p>
            <?php }?>
           
          </div>
          <?php if (!$_smarty_tpl->tpl_vars['is_preset_demo']->value && $_smarty_tpl->tpl_vars['LOG_USER_TYPE']->value == 'admin') {?>
           <div class="col-md-12 text-center m-t-sm">
            <a class="btn m-b-xs btn-sm btn-primary btn-addon" href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/revamp/revamp_update_plan"><i class="fa fa-plus"></i> Upgrade Now</a>
            </div>
            <?php }?>
        </div>
        <hr>
        
                 <div class="row">
         <div class="col-md-3">
         <ul class="social">
            <li><a href="#">  <i class="fa fa-newspaper-o"></i> </a> </li>
           <span class="m-t-sm"><?php if ($_smarty_tpl->tpl_vars['is_app']->value) {?> <a class="font-bold " href="https://blog.infinitemlmsoftware.com" target="_blank">Infinite MLM Blog</a>
           <?php } else { ?><div class="font-bold " href="" target="_blank">Infinite MLM Blog</div><?php }?></span>
          </ul>
         </div>
         <div class="col-md-3">
         <ul class="social">
            <li><a href="#">  <i class="fa fa-skype"></i> </a> </li>
           <span class="m-t-sm"> <div class="font-bold " href="" target="_blank">infinitemlm</div></span>
          </ul>
         </div>
         <div class="col-md-3">
         <ul class="social">
            <li><a href="#">  <i class="fa fa-whatsapp"></i> </a> </li>
           <span class="m-t-sm"> <div class="font-bold " href="" target="_blank">+91 9562-941-055</div></span>
          </ul>
         </div>
         <div class="col-md-3">
         <ul class="social">
            <li><a href="#">  <i class="fa fa-envelope"></i> </a> </li>
           <span class="m-t-sm"> <div class="font-bold " href="" target="_blank">support@ioss.in</div></span>
          </ul>
         </div>
         </div>
        
      </div>
    </div>
  </div>
</div>
<?php }?>

<!--end demo--> 


 
<?php }
}
