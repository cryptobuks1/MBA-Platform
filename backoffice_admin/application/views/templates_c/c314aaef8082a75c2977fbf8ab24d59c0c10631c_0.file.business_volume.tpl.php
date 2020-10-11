<?php
/* Smarty version 3.1.30, created on 2020-08-07 15:52:58
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/profile/business_volume.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2cec3a3d65f3_14243942',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c314aaef8082a75c2977fbf8ab24d59c0c10631c' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/profile/business_volume.tpl',
      1 => 1589258552,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/search_member.tpl' => 1,
  ),
),false)) {
function content_5f2cec3a3d65f3_14243942 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1753628865f2cec3a3d5ae5_84890706', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_1753628865f2cec3a3d5ae5_84890706 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="span_js_messages" class="no-display">
    <span id="error_msg"><?php echo lang('select_user_id');?>
</span>
    <span id="errmsg1"><?php echo lang('you_must_enter_username');?>
</span>
</div>

<div id="page_path" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
admin/</div>

<?php $_smarty_tpl->_subTemplateRender("file:layout/search_member.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php $_smarty_tpl->_assignInScope('u', $_smarty_tpl->tpl_vars['u_name']->value);
if ($_smarty_tpl->tpl_vars['u_name']->value) {?>
    <div id="user_account"></div>
    <div id="username_val" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['u']->value;?>
</div>

    

    <div class="panel panel-default">
    <div class="panel-body">
    <legend>
        <span class="fieldset-legend"><?php echo lang('business_volume');?>
: <?php echo $_smarty_tpl->tpl_vars['u_name']->value;?>
</span>
    </legend>
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead class="table-bordered">
                <tr class="th">
                    <th><?php echo lang('slno');?>
</th>
                    <th><?php echo lang('user_name');?>
</th>
                    <th><?php echo lang('left_leg');?>
</th>
                    <th><?php echo lang('left_leg_carry');?>
</th>
                    <th><?php echo lang('right_leg');?>
</th>
                    <th><?php echo lang('right_leg_carry');?>
</th>
                    <th><?php echo lang('description');?>
</th>
                    <th><?php echo lang('date');?>
</th>
                </tr>
            </thead>
            <?php if (count($_smarty_tpl->tpl_vars['details']->value) > 0) {?>
                <tbody>
                    <?php $_smarty_tpl->_assignInScope('i', "0");
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['details']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                        <?php $_smarty_tpl->_assignInScope('amount_type', $_smarty_tpl->tpl_vars['v']->value['amount_type']);
?>
                        <?php $_smarty_tpl->_assignInScope('action', $_smarty_tpl->tpl_vars['v']->value['action']);
?>

                        <?php if ($_smarty_tpl->tpl_vars['amount_type']->value == "user_join") {?> 
                            <?php ob_start();
echo lang('volume_added_from_member');
$_prefixVariable1=ob_get_clean();
ob_start();
echo lang('join');
$_prefixVariable2=ob_get_clean();
$_smarty_tpl->_assignInScope('type', $_prefixVariable1."  ".((string)$_smarty_tpl->tpl_vars['v']->value['from_name'])." ".$_prefixVariable2." ");
?> 
                            <?php $_smarty_tpl->_assignInScope('sign', "+");
?>
                        <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "user_repurchase") {?> 
                            <?php ob_start();
echo lang('volume_added_from_member');
$_prefixVariable3=ob_get_clean();
ob_start();
echo lang('repurchase');
$_prefixVariable4=ob_get_clean();
$_smarty_tpl->_assignInScope('type', $_prefixVariable3."  ".((string)$_smarty_tpl->tpl_vars['v']->value['from_name'])." ".$_prefixVariable4." ");
?> 
                            <?php $_smarty_tpl->_assignInScope('sign', "+");
?>
                        <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "leg" && $_smarty_tpl->tpl_vars['action']->value != "deducted_without_pair") {?>
                            <?php ob_start();
echo lang('volume_taken_for_commission');
$_prefixVariable5=ob_get_clean();
$_smarty_tpl->_assignInScope('type', $_prefixVariable5);
?>
                            <?php $_smarty_tpl->_assignInScope('sign', "-");
?>
                        <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "repurchase_leg" && $_smarty_tpl->tpl_vars['action']->value != "deducted_without_pair") {?>
                            <?php ob_start();
echo lang('volume_taken_for_commission_repurchase');
$_prefixVariable6=ob_get_clean();
$_smarty_tpl->_assignInScope('type', $_prefixVariable6);
?>
                            <?php $_smarty_tpl->_assignInScope('sign', "-");
?>
                        <?php } elseif ($_smarty_tpl->tpl_vars['action']->value == "deducted_without_pair") {?> 
                            <?php ob_start();
echo lang('volume_deducted');
$_prefixVariable7=ob_get_clean();
$_smarty_tpl->_assignInScope('type', $_prefixVariable7);
?>
                            <?php $_smarty_tpl->_assignInScope('sign', "-");
?>
                        <?php } elseif ($_smarty_tpl->tpl_vars['amount_type']->value == "user_renewal") {?> 
                            <?php ob_start();
echo lang('volume_added_from_member');
$_prefixVariable8=ob_get_clean();
ob_start();
echo lang('renewal');
$_prefixVariable9=ob_get_clean();
$_smarty_tpl->_assignInScope('type', $_prefixVariable8."  ".((string)$_smarty_tpl->tpl_vars['v']->value['from_name'])." ".$_prefixVariable9." ");
?> 
                            <?php $_smarty_tpl->_assignInScope('sign', "+");
?>
                        <?php } else { ?> 
                            <?php $_smarty_tpl->_assignInScope('type', " ".((string)$_smarty_tpl->tpl_vars['v']->value['amount_type']));
?> 
                        <?php }?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['i']->value+$_smarty_tpl->tpl_vars['page_id']->value;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</td>
                            <td><?php if ($_smarty_tpl->tpl_vars['v']->value['left_leg_carry'] == '0') {
echo $_smarty_tpl->tpl_vars['v']->value['left_leg_carry'];
} else {
echo $_smarty_tpl->tpl_vars['sign']->value;
echo $_smarty_tpl->tpl_vars['v']->value['left_leg_carry'];
}?></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['left_leg'];?>
</td>
                            <td><?php if ($_smarty_tpl->tpl_vars['v']->value['right_leg_carry'] == '0') {
echo $_smarty_tpl->tpl_vars['v']->value['right_leg_carry'];
} else {
echo $_smarty_tpl->tpl_vars['sign']->value;
echo $_smarty_tpl->tpl_vars['v']->value['right_leg_carry'];
}?></td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['right_leg'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['type']->value;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['date'];?>
</td>
                        </tr>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                </tbody>
            <?php } else { ?>
                <tbody>
                    <tr>
                        <td colspan="8">
                            <h4><?php echo lang('no_details');?>
</h4>
                        </td>
                    </tr>
                </tbody>
            <?php }?>
        </table>
        </div>
         <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

        </div>
    </div>
   
<?php }?>


<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
