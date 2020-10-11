<?php
/* Smarty version 3.1.30, created on 2020-09-25 15:30:04
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/tree/sponsor_tree.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d805c2a6177_14313344',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fcb56f440296aa03bf9ad959c203b59c97764c84' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/tree/sponsor_tree.tpl',
      1 => 1574510463,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d805c2a6177_14313344 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_6212317425f6d805c2a3589_33617881', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18062243025f6d805c2a4b01_60796948', 'style');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13026957155f6d805c2a5c17_25577340', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_6212317425f6d805c2a3589_33617881 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div id="span_js_messages" class="no-display">
        <span id="error_msg"><?php echo lang('select_user_id');?>
</span>
    </div>
   <div class="panel panel-default m-t">
        <div class="panel-body">
            <div class="button_back m-t-md">
                <a href="<?php echo BASE_URL;?>
/user/my_referal" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-forward"></i><?php echo lang('go_to_my_referals');?>
</a>
            </div>
        </div>
    </div>
    <div id="summary" class="tree_main"></div>
    <input id="root_user_name" value="<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
" type="hidden">
    <input id="tree_url" value="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/tree/tree_view_sponsor" type="hidden">
    <div class="panel panel-default m-t">
        <div class="panel-body">
            <div class="col-lg-9 col-sm-12 col-md-9">
                <div class="m-b m-t-sm tree_img">
                    <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/tree/active.png">
                    <p><?php echo lang('customer');?>
</p>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/tree/blue.png">
                    <p><?php echo lang('business_affiliate');?>
</p>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/tree/Brown.png">
                    <p><?php echo lang('rank_2');?>
</p>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/tree/gray.png">
                    <p><?php echo lang('rank_3');?>
</p>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/tree/green.png">
                    <p><?php echo lang('rank_4');?>
</p>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/tree/light green.png">
                    <p><?php echo lang('rank_5');?>
</p>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/tree/orenge.png">
                    <p><?php echo lang('rank_6');?>
</p>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/tree/pink.png">
                    <p><?php echo lang('rank_7');?>
</p>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/tree/red.png">
                    <p><?php echo lang('rank_8');?>
</p>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/tree/sky blue.png">
                    <p><?php echo lang('rank_9');?>
</p>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/tree/yellow.png">
                    <p><?php echo lang('rank_10');?>
</p>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/tree/inactive.png">
                    <p><?php echo lang('inactive');?>
</p>
                </div>
            </div>
            <div class="col-lg-3 col-sm-12 col-md-3 m-t-md">
                <div class=" pull-right">
                    <button class="btn m-b-xs btn-primary zoom-in"><i class="glyphicon glyphicon-zoom-in"></i></button>
                    <button class="btn m-b-xs btn-info zoom-out"><i class="glyphicon glyphicon-zoom-out"></i></button>
                    <button class="btn m-b-xs btn-primary zoom-reset"><i class="icon-power"></i></button>
                </div>
    
            </div>
        </div>
    </div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'style'} */
class Block_18062243025f6d805c2a4b01_60796948 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/css/tree.css" type="text/css"/>
    <link rel="stylesheet" href="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/css/tree_tooltip.css" type="text/css"/>
<?php
}
}
/* {/block 'style'} */
/* {block 'script'} */
class Block_13026957155f6d805c2a5c17_25577340 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
theme/libs/jquery/panzoom/jquery.panzoom.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/tree/jquery.tree.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/tree/genealogy.js"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
