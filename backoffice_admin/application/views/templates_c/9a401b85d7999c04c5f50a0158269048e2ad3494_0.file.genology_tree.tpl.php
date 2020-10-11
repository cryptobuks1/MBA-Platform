<?php
/* Smarty version 3.1.30, created on 2020-08-05 17:53:38
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/tree/genology_tree.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2a6582bf8a11_84382115',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9a401b85d7999c04c5f50a0158269048e2ad3494' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/tree/genology_tree.tpl',
      1 => 1574510100,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f2a6582bf8a11_84382115 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13388507255f2a6582bf5ac2_03239306', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_4634887285f2a6582bf7238_30773787', 'style');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_9617140735f2a6582bf83b9_02741139', 'script');
?>

<?php $_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_13388507255f2a6582bf5ac2_03239306 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


    <div id="span_js_messages" class="no-display">
        <span id="error_msg"><?php echo lang('select_user_id');?>
</span>
    </div>

    <input type="hidden" id="search_member_error" value="<?php echo lang('search_member_error');?>
" />
    <input type="hidden" id="search_member_error2" value="<?php echo lang('invalid_user_name');?>
" />

    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo form_open('admin/genology_tree','role="form"  name="search_member" id="search_member" method="post"');?>

                <div class="col-sm-3 padding_both">
                    <div class="form-group">
                        <label class="required" for="user_name"><?php echo lang('user_name');?>
</label>
                        <input class="form-control user_autolist" type="text" id="user_name" name="user_name" autocomplete="Off" size="100">
                    </div>
                </div>
                <div class="col-sm-2 padding_both_small">
                    <div class="form-group mark_paid">
                        <button class="btn btn-sm btn-primary" type="submit" id="search_member_submit" value="search_member_submit" name="search_member_submit">
                            <?php echo lang('search');?>

                        </button>
                    </div>
                </div>
            <?php echo form_close();?>

            <div class="button_back m-t-sm">    
                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['mlm_plan'] == "Unilevel") {?>
                    <?php if (isset($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['sponsor_commission_status']) && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['sponsor_commission_status'] == 'yes') {?>
                        <a href="<?php echo BASE_URL;?>
/admin/unilevel_history" class="btn m-b-xs m-t-md btn-sm btn-info btn-addon"><i class="fa fa-forward"></i><?php echo lang('go_to_unilevel_list');?>
</a>
                    <?php }?>
                <?php } else { ?>
                    <a href="<?php echo BASE_URL;?>
/admin/binary_history" class="btn m-b-xs m-t-md btn-sm btn-info btn-addon"><i class="fa fa-forward"></i><?php echo lang('downline_list');?>
</a>
                <?php }?>
            </div>
        </div>
    </div>
    <div id="summary" class="tree_main"></div>
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
                    <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Binary') {?>
                        <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/tree/add_disabled.png">
                        <p><?php echo lang('disabled');?>
</p>
                    <?php }?>
                    <img src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
images/tree/add.png">
                    <p><?php echo lang('vacant');?>
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
    <input id="root_user_name" value="<?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
" type="hidden">
    <input id="tree_url" value="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/tree/tree_view" type="hidden">
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'style'} */
class Block_4634887285f2a6582bf7238_30773787 extends Smarty_Internal_Block
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
class Block_9617140735f2a6582bf83b9_02741139 extends Smarty_Internal_Block
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
