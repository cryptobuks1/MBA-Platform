<?php
/* Smarty version 3.1.30, created on 2020-08-05 18:56:03
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/income_details/income.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f2a7423ab5ed3_21911965',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '66632b39fe351acf5e40eea7ff110069f8c63712' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/income_details/income.tpl',
      1 => 1574831511,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:layout/search_member.tpl' => 1,
  ),
),false)) {
function content_5f2a7423ab5ed3_21911965 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2918018035f2a7423ab4062_96086081', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2560359005f2a7423ab5bc5_86247919', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_2918018035f2a7423ab4062_96086081 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>


<div id="span_js_messages" class="no-display">
    <span id="error_msg"><?php echo lang('select_user_id');?>
</span>
    <span id="row_msg"><?php echo lang('rows');?>
</span>
    <span id="show_msg"><?php echo lang('shows');?>
</span>
    <span id="username_msg"><?php echo lang('you_must_enter_username');?>
</span>
</div>

<input type="hidden" id="filter_submit_url" value="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/income_details/income">
<div id="page_path" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['PATH_TO_ROOT_DOMAIN']->value;?>
admin/</div>

<?php $_smarty_tpl->_subTemplateRender("file:layout/search_member.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<?php if (isset($_smarty_tpl->tpl_vars['user_name']->value) && $_smarty_tpl->tpl_vars['is_valid_username']->value) {?>
    <?php if ($_smarty_tpl->tpl_vars['overview_disp']->value) {?>
        <div id="user_account"></div>
    <?php }?>
    <div id="username_val" style="display:none;"><?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</div>

    <legend>
        <span class="fieldset-legend"><?php echo lang('income_details');?>
: <?php echo $_smarty_tpl->tpl_vars['user_name']->value;?>
</span>
    </legend>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php echo form_open('admin/income','role="form" class="" method="post" name="feedback_form"
        id="feedback_form"');?>

                <input type="hidden" value='<?php echo $_smarty_tpl->tpl_vars['from_page']->value;?>
' name="from_page" id="from_page">
                <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <select name="amount_type" id="amount_type" class="form-control">
                        <option value="all"><?php echo lang('all');?>
 </option>
                        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['all_amount_type']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['v']->value['db_amount_type'];?>
" <?php if ($_smarty_tpl->tpl_vars['amount_type']->value == $_smarty_tpl->tpl_vars['v']->value['db_amount_type']) {?> selected <?php }?>><?php echo lang($_smarty_tpl->tpl_vars['v']->value['db_amount_type']);?>
</option>
                        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 
                    </select>
                    </div>
                </div> 
                <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <button class="btn btn-sm btn-primary btn_height" type="submit" id="search_amountype_submit" value="search_amountype_submit" name="search_amountype_submit"><?php echo lang('search');?>
</button>
                </div>
                </div>
            <?php echo form_close();?>

        </div>
    </div>
    <div class="panel panel-default table-responsive">
 
    <div class="panel-body">
        
        <div class = "panel-tools-filter pull-left" style="text-align: right;margin: 5px;">
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
        
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <thead class="table-bordered">
                <tr class="th">
                    <th><?php echo lang('sl_no');?>
</th>
                    <th><?php echo lang('from');?>
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
            <div class="button_back pull-righ">
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/excel/create_excel_earnings_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-excel-o"></i><?php echo lang('create_excel');?>
</button></a>
                <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/excel/create_csv_earnings_report"> <button class="btn m-b-xs btn-sm btn-primary btn-addon"><i class="fa fa-file-text-o"></i><?php echo lang('create_csv');?>
</button></a>
            </div>
                <tbody>
                    <?php $_smarty_tpl->_assignInScope('i', "0");
?>
                    <?php $_smarty_tpl->_assignInScope('total_amount', 0);
?>
                    <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['amount']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
                        <?php $_smarty_tpl->_assignInScope('total_amount', $_smarty_tpl->tpl_vars['total_amount']->value+$_smarty_tpl->tpl_vars['v']->value['amount_payable']);
?>
                        <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->tpl_vars['i']->value+$_smarty_tpl->tpl_vars['page_id']->value;?>
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
                            <td><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['v']->value['amount_payable']*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</td>
                        </tr>
                    <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

                    <tr>
                        <td colspan="4" class="text-right"><b><?php echo lang('amount_total');?>
</b></td>
                        
                        <td><b><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo number_format($_smarty_tpl->tpl_vars['total_amount']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value,$_smarty_tpl->tpl_vars['PRECISION']->value);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</b></td>
                    </tr>
                </tbody>
            <?php } else { ?>
                <tbody>
                    <tr>
                        <td colspan="8">
                            <h4><?php echo lang('no_income_details_were_found');?>
</h4>
                        </td>
                    </tr>
                </tbody>
            <?php }?>
        </table>
        </div>
    </div>
    <?php echo $_smarty_tpl->tpl_vars['result_per_page']->value;?>

<?php }?>


<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'script'} */
class Block_2560359005f2a7423ab5bc5_86247919 extends Smarty_Internal_Block
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
