<?php
/* Smarty version 3.1.30, created on 2020-09-25 20:26:51
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/configuration/my_referal.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6dc5eb573847_45367497',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd172372f0e7babc81818216b1979358191f9b11b' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/configuration/my_referal.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6dc5eb573847_45367497 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8966838385f6dc5eb572de7_69221496', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_8966838385f6dc5eb572de7_69221496 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <div class="button_back">
        <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['mlm_plan'] != "Unilevel") {?>
            <a href="<?php echo BASE_URL;?>
/user/sponsor_tree"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i><?php echo lang('back');?>
</button></a>
                <?php } else { ?>
            <a href="<?php echo BASE_URL;?>
/user/genology_tree"> <button class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i><?php echo lang('back');?>
</button></a>
                <?php }?>

    </div>
    <div class="panel panel-default table-responsive">
    <div class="panel-body">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead class="table-bordered">
                <tr class="th">
                    <th><?php echo lang('sl_no');?>
</th>
                    <th><?php echo lang('user_name');?>
</th>
                    <th><?php echo lang('full_name');?>
</th>
                    <th><?php echo lang('joinig_date');?>
</th>
                    <th> <?php echo lang('email');?>
</th>
                    <th><?php echo lang('country');?>
</th>
                </tr>
            </thead>
            <?php if ($_smarty_tpl->tpl_vars['count']->value > 0) {?>
                <tbody>
                    <?php $_smarty_tpl->_assignInScope('i', "0");
?>
                    <?php $_smarty_tpl->_assignInScope('class', '');
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['arr']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <?php if ($_smarty_tpl->tpl_vars['i']->value%2 == 0) {?>
                            <?php $_smarty_tpl->_assignInScope('class', 'tr1');
?>
                        <?php } else { ?>
                            <?php $_smarty_tpl->_assignInScope('class', 'tr2');
?>
                        <?php }?>
                        <tr class="<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
">
                            <td><?php echo $_smarty_tpl->tpl_vars['i']->value+1+$_smarty_tpl->tpl_vars['page']->value;?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['user_name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['name'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['join_date'];?>
</td>
                            <td> <?php echo $_smarty_tpl->tpl_vars['v']->value['email'];?>
</td>
                            <td><?php echo $_smarty_tpl->tpl_vars['v']->value['country'];?>
</td>
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
                <tbody>
                    <tr><td colspan="12" align="center"><h4><?php echo lang('no_referels');?>
</h4></td></tr>
                </tbody> 
            <?php }?>
        </table>
        </div>
    </div>
    <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
}
