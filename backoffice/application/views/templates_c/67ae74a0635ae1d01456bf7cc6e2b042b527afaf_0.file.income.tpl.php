<?php
/* Smarty version 3.1.30, created on 2020-09-25 15:42:35
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/income_details/income.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6d834b2d84f8_21315672',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '67ae74a0635ae1d01456bf7cc6e2b042b527afaf' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/income_details/income.tpl',
      1 => 1570096368,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f6d834b2d84f8_21315672 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_5973046505f6d834b2d6b63_34578256', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7211748075f6d834b2d8036_58166567', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_5973046505f6d834b2d6b63_34578256 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    
<input type="hidden" id="filter_submit_url" value="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/income_details/income">    
<div class="panel panel-default">
<div class="panel-body">
    <div class = "panel-tools-filter" style="text-align: right;margin: 5px;">
         <?php $_smarty_tpl->_assignInScope('date_text', lang('overall'));
?>
         <?php if ($_smarty_tpl->tpl_vars['date']->value == 'month') {?>
            <?php $_smarty_tpl->_assignInScope('date_text', lang('this_month'));
?>
        <?php } elseif ($_smarty_tpl->tpl_vars['date']->value == 'year') {?>
            <?php $_smarty_tpl->_assignInScope('date_text', lang('this_year'));
?>
        <?php }?>
         <div class="btn-group dropdown filter_date" style = "display: inline-block;vertical-align: middle;">
            <button class="btn btn-sm btn-default" data-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-calendar"></i>
                <b><?php echo $_smarty_tpl->tpl_vars['date_text']->value;?>
 (<?php echo lang('date');?>
)</b>
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li class="<?php if (!$_smarty_tpl->tpl_vars['date']->value) {?>active<?php }?>">
                    <a class="" data-value="">
                        <span class=""><?php echo lang('overall');?>
</span>
                    </a>
                </li>
                <li class="<?php if ($_smarty_tpl->tpl_vars['date']->value == 'month') {?>active<?php }?>">
                    <a class="" data-value="month">
                        <span class=""><?php echo lang('this_month');?>
</span>
                    </a>
                </li>
                <li class="<?php if ($_smarty_tpl->tpl_vars['date']->value == 'year') {?>active<?php }?>">
                    <a class="" data-value="year">
                        <span class=""><?php echo lang('this_year');?>
</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="btn-group dropdown filter_clear">
            <button class="btn btn-sm btn-default" aria-expanded="false">
                <i class="fa fa-circle-o-notch"></i>
                <b><?php echo lang('clear');?>
</b>
            </button>
        </div>
            
     </div> 
    <?php $_smarty_tpl->_assignInScope('i', "0");
?> 
    <?php $_smarty_tpl->_assignInScope('total', "0");
?> 
    <?php $_smarty_tpl->_assignInScope('class', '');
?>
    <div class=" table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
        <thead class="table-bordered">
            <tr class="th">
                <th><?php echo lang('sl_no');?>
</th>
                <th><?php echo lang('user_name');?>
</th>
                <th><?php echo lang('level');?>
</th>
                <th><?php echo lang('amount_type');?>
</th>
                <th><?php echo lang('amount');?>
</th>
            </tr>
        </thead>
        <?php if (count($_smarty_tpl->tpl_vars['amount']->value) > 0) {?>
        <tbody>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['amount']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?> 
                <?php if ($_smarty_tpl->tpl_vars['i']->value%2 == 0) {?> 
                    <?php $_smarty_tpl->_assignInScope('class', "tr2");
?> 
                <?php } else { ?> 
                    <?php $_smarty_tpl->_assignInScope('class', "tr1");
?> 
                <?php }?>
                
                <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?> 
                <?php $_smarty_tpl->_assignInScope('total', $_smarty_tpl->tpl_vars['total']->value+$_smarty_tpl->tpl_vars['v']->value['amount_payable']);
?>
                
            <tr class="<?php echo $_smarty_tpl->tpl_vars['class']->value;?>
">
                <td><?php echo $_smarty_tpl->tpl_vars['i']->value+$_smarty_tpl->tpl_vars['page']->value;?>
</td>
                <td>
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['from_user'] && in_array($_smarty_tpl->tpl_vars['v']->value['amount_type'],$_smarty_tpl->tpl_vars['from_user_amount_types']->value)) {?>
                        <?php echo $_smarty_tpl->tpl_vars['v']->value['from_user'];?>

                    <?php } else { ?>
                        NA
                    <?php }?>
                </td>
                <td>
                    <?php if (in_array($_smarty_tpl->tpl_vars['v']->value['amount_type'],$_smarty_tpl->tpl_vars['level_based_amount_type']->value)) {?>
                        <?php echo $_smarty_tpl->tpl_vars['v']->value['user_level'];?>

                    <?php } else { ?>
                        NA
                    <?php }?>
                </td>
                <td>
                    <?php if ($_smarty_tpl->tpl_vars['v']->value['amount_type'] == 'board_commission' && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['table_status'] == 'yes') {?>
                        <?php echo lang('table_commission');?>

                    <?php } else { ?>
                        <?php echo lang($_smarty_tpl->tpl_vars['v']->value['amount_type']);?>

                    <?php }?>
                </td>

                <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
 <?php echo number_format($_smarty_tpl->tpl_vars['v']->value['amount_payable']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
 <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
            </tr>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            <td colspan="4" class="text-right"><b><?php echo lang('amount_total');?>
</b></td>
            <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;?>
 <?php echo number_format($_smarty_tpl->tpl_vars['total']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);?>
 <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
            </tr>
        </tbody>
        <?php } else { ?>
        <tbody>
            <tr>
                <td colspan="12" align="center">
                    <h4><?php echo lang('no_income_details_were_found');?>
</h4></td>
            </tr>
        </tbody>
        <?php }?>

    </table>
    </div>
       </div>
</div>
 <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_7211748075f6d834b2d8036_58166567 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

     <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

     <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/income_details_filter.js" type="text/javascript" ><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
