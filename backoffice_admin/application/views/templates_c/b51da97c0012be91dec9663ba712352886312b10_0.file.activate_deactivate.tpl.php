<?php
/* Smarty version 3.1.30, created on 2020-08-05 21:25:46
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/activate/activate_deactivate.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2a973a850052_80229801',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b51da97c0012be91dec9663ba712352886312b10' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/activate/activate_deactivate.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/search_member.tpl' => 1,
  ),
),false)) {
function content_5f2a973a850052_80229801 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_17562864975f2a973a84e586_70454992', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>
 <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_14826712605f2a973a84fd40_05179671', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_17562864975f2a973a84e586_70454992 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display: none;">
    <span id="error_msg1"><?php echo lang('you_must_enter_username');?>
</span>
</div>
<legend><span class="fieldset-legend"><?php echo lang('search_member');?>
</span></legend>
<?php $_smarty_tpl->_subTemplateRender("file:layout/search_member.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 <?php if ($_smarty_tpl->tpl_vars['flag']->value == "true") {?>
<div class="panel panel-default table-responsive ng-scope">
    <div class="panel-body">
        <legend><span class="fieldset-legend"><?php echo lang('member_details');?>
</span></legend>
        <div class="table-responsive">
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                    <tr class="th">
                        <?php if (!isset($_smarty_tpl->tpl_vars['user_name']->value)) {?>
                        <th><?php echo lang('slno');?>
</th>
                        <?php }?>
                        <th><?php echo lang('user_name');?>
</th>
                        <th><?php echo lang('name');?>
</th>
                        <th><?php echo lang('sponser_name');?>
</th>
                        <th><?php echo lang('mobile_no');?>
</th>
                        <th><?php echo lang('action');?>
</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($_smarty_tpl->tpl_vars['user_details']->value) > 0) {?> <?php $_smarty_tpl->_assignInScope('i', 0);
?> <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                    <tr>
                        <?php if (!isset($_smarty_tpl->tpl_vars['user_name']->value)) {?>
                        <td><?php echo $_smarty_tpl->tpl_vars['page_id']->value+$_smarty_tpl->tpl_vars['i']->value+1;?>
</td>
                        <?php }?>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
 <?php if (($_smarty_tpl->tpl_vars['v']->value['active']) == 'yes') {?>
                            <b class="badge label-primary-1"><?php echo lang('active');?>
</b> <?php } else { ?>
                            <b class="badge label-primary-2"><?php echo lang('inactive');?>
</b> <?php }?>
                        </td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['full_name'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['sponsor_full_name'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['mobile_no'];?>
</td>
                        <td>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['active'] == "yes") {?> <?php $_smarty_tpl->_assignInScope('action_url', "admin/activate/deactivate_user");
?> <?php } else { ?> <?php $_smarty_tpl->_assignInScope('action_url', "admin/activate/activate_user");
?> <?php }?> <?php echo form_open($_smarty_tpl->tpl_vars['action_url']->value,'method="post"');?>

                            <div class="">
                                <button class="btn btn-sm btn-primary" type="submit" name="user_name" id="user_name" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
" tabindex="3" onclick="$(this).button('loading');"><?php if ($_smarty_tpl->tpl_vars['v']->value['active'] == "yes") {?> <?php echo lang('block');
} else {
echo lang('unblock');
}?> </button>
                            </div>
                            <?php echo form_close();?>


                        </td>
                    </tr>
                    <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 <?php } else { ?>
                    <tr>
                        <td colspan="6">
                            <h4 align="center"><?php echo lang('No_Details_Found');?>
</h4>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <?php if (!isset($_smarty_tpl->tpl_vars['user_name']->value)) {?> <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>
 <?php }?>

        </div>
    </div>
</div>
<?php } else { ?>
<legend><span class="fieldset-legend"><?php echo lang('member_details');?>
</span></legend>
<div class="tabsy">
    <input type="radio" id="tab1" name="tab" <?php if ($_smarty_tpl->tpl_vars['tab1']->value) {?>checked<?php }?>>
    <label class="tabButton" for="tab1"><?php echo lang('active_users');?>
</label>
    <div class="tab">
        <div class="content table-responsive">
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                    <tr class="th">
                        <th><?php echo lang('slno');?>
</th>
                        <th><?php echo lang('user_name');?>
</th>
                        <th><?php echo lang('name');?>
</th>
                        <th><?php echo lang('sponser_name');?>
</th>
                        <th><?php echo lang('mobile_no');?>
</th>
                        <th><?php echo lang('action');?>
</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($_smarty_tpl->tpl_vars['user_details1']->value) > 0) {?> <?php $_smarty_tpl->_assignInScope('i', 0);
?> <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_details1']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['start1']->value++;?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
 <?php if (($_smarty_tpl->tpl_vars['v']->value['active']) == 'yes') {?>
                            <b class="badge label-primary-1"><?php echo lang('active');?>
</b> <?php } else { ?>
                            <b class="badge label-primary-2"><?php echo lang('inactive');?>
</b> <?php }?>
                        </td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['full_name'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['sponsor_full_name'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['mobile_no'];?>
</td>
                        <td>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['active'] == "yes") {?> <?php $_smarty_tpl->_assignInScope('action_url', "admin/activate/deactivate_user");
?> <?php } else { ?> <?php $_smarty_tpl->_assignInScope('action_url', "admin/activate/activate_user");
?> <?php }?> <?php echo form_open($_smarty_tpl->tpl_vars['action_url']->value,'method="post"');?>

                            <div class="">
                                <button class="btn btn-sm btn-primary" type="submit" name="user_name" id="user_name" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
" tabindex="3" onclick="$(this).button('loading');"><?php if ($_smarty_tpl->tpl_vars['v']->value['active'] == "yes") {?> <?php echo lang('block');
} else {
echo lang('unblock');
}?> </button>
                            </div>
                            <?php echo form_close();?>


                        </td>
                    </tr>
                    <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 <?php } else { ?>
                    <tr>
                        <td colspan="6">
                            <h4 align="center"><?php echo lang('no_data');?>
</h4>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <?php echo $_smarty_tpl->tpl_vars['result_per_page1']->value;?>

        </div>
    </div>
    <input type="radio" id="tab2" name="tab" <?php if ($_smarty_tpl->tpl_vars['tab2']->value) {?>checked<?php }?>>
    <label class="tabButton" for="tab2"><?php echo lang('block_users');?>
</label>
    <div class="tab">
        <div class="content table-responsive">
            <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                <thead>
                    <tr class="th">
                        <th><?php echo lang('slno');?>
</th>
                        <th><?php echo lang('user_name');?>
</th>
                        <th><?php echo lang('name');?>
</th>
                        <th><?php echo lang('sponser_name');?>
</th>
                        <th><?php echo lang('mobile_no');?>
</th>
                        <th><?php echo lang('action');?>
</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($_smarty_tpl->tpl_vars['user_details2']->value) > 0) {?> <?php $_smarty_tpl->_assignInScope('i', 0);
?> <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['user_details2']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                    <tr>
                        <td><?php echo $_smarty_tpl->tpl_vars['start2']->value++;?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
 <?php if (($_smarty_tpl->tpl_vars['v']->value['active']) == 'yes') {?>
                            <b class="badge label-primary-1"><?php echo lang('active');?>
</b> <?php } else { ?>
                            <b class="badge label-primary-2"><?php echo lang('inactive');?>
</b> <?php }?>
                        </td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['full_name'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['sponsor_full_name'];?>
</td>
                        <td><?php echo $_smarty_tpl->tpl_vars['v']->value['mobile_no'];?>
</td>
                        <td>
                            <?php if ($_smarty_tpl->tpl_vars['v']->value['active'] == "yes") {?> <?php $_smarty_tpl->_assignInScope('action_url', "admin/activate/deactivate_user");
?> <?php } else { ?> <?php $_smarty_tpl->_assignInScope('action_url', "admin/activate/activate_user");
?> <?php }?> <?php echo form_open($_smarty_tpl->tpl_vars['action_url']->value,'method="post"');?>

                            <div class="">
                                <button class="btn btn-sm btn-primary" type="submit" name="user_name" id="user_name" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
" tabindex="3" onclick="$(this).button('loading');"><?php if ($_smarty_tpl->tpl_vars['v']->value['active'] == "yes") {?> <?php echo lang('block');
} else {
echo lang('unblock');
}?> </button>
                            </div>
                            <?php echo form_close();?>


                        </td>
                    </tr>
                    <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?> <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 <?php } else { ?>
                    <tr>
                        <td colspan="6">
                            <h4 align="center"><?php echo lang('no_data');?>
</h4>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <?php echo $_smarty_tpl->tpl_vars['result_per_page2']->value;?>

        </div>
    </div>
</div>
<?php }?> <?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_14826712605f2a973a84fd40_05179671 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php echo '<script'; ?>
>
    jQuery(document).ready(function() {
        ValidateSearchMember.init();
    });
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
