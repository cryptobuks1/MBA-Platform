<?php
/* Smarty version 3.1.30, created on 2020-08-05 10:03:00
  from "/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/compensation_settings.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f29f73451e0e9_11409777',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a8891595ef15106fe333f64bbbd23fd09c3b6f7c' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice_admin/application/views/admin/configuration/compensation_settings.tpl',
      1 => 1573035850,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:admin/configuration/system_setting_common.tpl' => 1,
  ),
),false)) {
function content_5f29f73451e0e9_11409777 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_12564639825f29f73451b260_85229894', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_18674841355f29f73451cec5_50070970', 'style');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_8624520165f29f73451db97_58104294', 'script');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_12564639825f29f73451b260_85229894 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div id="span_js_messages" style="display: none;">
    <span id="validate_msg26"><?php echo lang('field_is_required');?>
</span>
    <span id="pnt_val"><?php echo lang('point_value');?>
</span>
    <span id="pr_val"><?php echo lang('pair_value');?>
</span>
    <span id="fl_lmt"><?php echo lang('flush_out_limit');?>
</span>
</div>
<?php $_smarty_tpl->_subTemplateRender("file:admin/configuration/system_setting_common.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<div class="panel panel-default">
    <div class="panel-body">
        <legend><span class="fieldset-legend"><?php echo lang('compensation_settings');?>
</span></legend>
        <div class="table-responsive">
            <table class="table borderless table" id="compensation_page">
                <thead>
                    <tr>
                        <th><?php echo lang('type_of_compensation');?>
</th>
                        <th><?php echo lang('status');?>
</th>
                        <th><?php echo lang('configuration');?>
</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value != 'Unilevel' && $_smarty_tpl->tpl_vars['MLM_PLAN']->value != 'Matrix' && $_smarty_tpl->tpl_vars['MLM_PLAN']->value != 'Party' && $_smarty_tpl->tpl_vars['MLM_PLAN']->value != 'Stair_Step' && $_smarty_tpl->tpl_vars['MLM_PLAN']->value != 'Donation') {?>

                    <?php $_smarty_tpl->_assignInScope('commission_link', '');
?>
                    <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Binary') {?>
                        <?php $_smarty_tpl->_assignInScope('commission_link', "binary_bonus_config");
?>
                    
                    <?php } elseif ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Board') {?>
                        <?php $_smarty_tpl->_assignInScope('commission_link', "board_bonus_config");
?>
                    
                    <?php }?>

                  <!--  <tr>
                        <td> <?php if ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Binary') {?>
                                <?php echo lang('binary_commission');?>

                            
                            <?php } elseif ($_smarty_tpl->tpl_vars['MLM_PLAN']->value == 'Board') {?>
                                <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['table_status'] == 'no') {?>
                                    <?php echo lang('board_commission');?>

                                <?php } else { ?>
                                    <?php echo lang('table_commission');?>

                                <?php }?>
                            
                            <?php }?>
                        </td>
                        <td>
                            <div class="form-group-button">
                                <label class="i-switch bg-primary">
                                    <input type="checkbox" class="compensations" data-name="plan_commission_status" name="plan_commission_status" <?php if ($_smarty_tpl->tpl_vars['plan_commission']->value == 'yes') {?> checked <?php }?>>
                                    <i></i>
                                </label>
                            </div>
                        </td>
                        <td><a href="<?php if ($_smarty_tpl->tpl_vars['plan_commission']->value == 'yes') {?> <?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/<?php echo $_smarty_tpl->tpl_vars['commission_link']->value;?>
 <?php } else { ?> javascript:void(0); <?php }?>"class="btn btn-sm btn-icon <?php if ($_smarty_tpl->tpl_vars['plan_commission']->value == 'yes') {?> btn-rounded btn-default <?php } else { ?> btn-disabled btn-muted<?php }?>"> <i class="fa fa-cog"></i></a></td>
                    </tr>-->
                    <?php }?>

                    <?php if (($_smarty_tpl->tpl_vars['MLM_PLAN']->value == "Party" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['sponsor_commission_status'] == "yes") || ($_smarty_tpl->tpl_vars['MLM_PLAN']->value != "Party")) {?>
                       <!-- <tr>
                            <td><?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['xup_status'] == 'yes') {?> <?php echo lang('xup_commission');?>
 <?php } else { ?> <?php echo lang('level_commission');?>
 <?php }?></td>
                            <td>
                                <div class="form-group-button">
                                    <label class="i-switch bg-primary">
                                        <input type="checkbox" class="compensations" data-name="sponsor_commission_status" name="sponsor_commission_status" <?php if ($_smarty_tpl->tpl_vars['sponsor_commission']->value == 'yes') {?> checked <?php }?>>
                                        <i></i>
                                    </label>
                                </div>
                            </td>
                            <td><a href="<?php if ($_smarty_tpl->tpl_vars['sponsor_commission']->value == 'yes') {?> <?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/level_commissions <?php } else { ?> javascript:void(0); <?php }?>" class="btn btn-sm btn-icon<?php if ($_smarty_tpl->tpl_vars['sponsor_commission']->value == 'yes') {?> btn-rounded btn-default <?php } else { ?> btn-disabled btn-muted<?php }?>" data-name="level_commission" name="level_commission"> <i class="fa fa-cog"></i></span></td>
                        </tr>-->
                    <?php }?>

                    <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['rank_status'] == 'yes') {?>
                        <tr>
                            <td><?php echo lang('rank_commission');?>
</td>
                            <td>
                                <div class="form-group-button">
                                <label class="i-switch bg-primary">
                                    <input type="checkbox" class="compensations" data-name="rank_commission_status" name="rank_commission_status" <?php if ($_smarty_tpl->tpl_vars['rank_commission']->value == 'yes') {?> checked <?php }?>>
                                    <i></i>
                                </label>
                            </div>
                            </td>
                            <td><a href="<?php if ($_smarty_tpl->tpl_vars['rank_commission']->value == 'yes') {?> <?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/rank_configuration <?php } else { ?> javascript:void(0); <?php }?>"class="btn btn-sm btn-icon <?php if ($_smarty_tpl->tpl_vars['rank_commission']->value == 'yes') {?> btn-rounded btn-default <?php } else { ?> btn-disabled btn-muted<?php }?>"> <i class="fa fa-cog"></i></a></td>
                        </tr>
                    <?php }?>

                   <!-- <tr>
                        <td><?php echo lang('referal_commission');?>
</td>
                        <td>
                            <div class="form-group-button">
                                <label class="i-switch bg-primary">
                                    <input type="checkbox" class="compensations" data-name="referal_commission_status" name="referal_commission_status" <?php if ($_smarty_tpl->tpl_vars['referal_commission']->value == 'yes') {?> checked <?php }?>>
                                    <i></i>
                                </label>
                            </div>
                        </td>
                        <td><a href="<?php if ($_smarty_tpl->tpl_vars['referal_commission']->value == 'yes') {?> <?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/configuration/referal_commissions <?php } else { ?> javascript:void(0); <?php }?>"class="btn btn-sm btn-icon <?php if ($_smarty_tpl->tpl_vars['referal_commission']->value == 'yes') {?> btn-rounded btn-default<?php } else { ?> btn-disabled btn-muted<?php }?>"> <i class="fa fa-cog"></i></a></td>
                    </tr>-->

                    <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['roi_status'] == 'yes') {?>
                        <tr>
                            <td><?php echo lang('hyip_commission');?>
</td>
                            <td>
                                <div class="form-group-button">
                                <label class="i-switch bg-primary">
                                    <input type="checkbox" class="compensations" data-name="roi_commission_status" name="roi_commission_status" <?php if ($_smarty_tpl->tpl_vars['roi_commission']->value == 'yes') {?> checked <?php }?>>
                                    <i></i>
                                </label>
                            </div>
                            </td>
                            <td><a href="<?php if ($_smarty_tpl->tpl_vars['roi_commission']->value == 'yes') {?> <?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/configuration/roi_commission <?php } else { ?> javascript:void(0); <?php }?>"class="btn btn-sm btn-icon <?php if ($_smarty_tpl->tpl_vars['roi_commission']->value == 'yes') {?> btn-rounded btn-default <?php } else { ?> btn-disabled btn-muted<?php }?>"> <i class="fa fa-cog"></i></a></td>
                        </tr>
                    <?php }?>

                    <?php if ($_smarty_tpl->tpl_vars['bonus']->value['matching_bonus'] == 'yes') {?>
                        <tr>
                            <td><?php echo lang('matching_bonus');?>
</td>
                            <td>
                                <div class="form-group-button">
                                    <label class="i-switch bg-primary">
                                        <input type="checkbox" class="compensations" data-name="matching_bonus" name="matching_bonus_status" <?php if ($_smarty_tpl->tpl_vars['matching_bonus_status']->value == 'yes') {?> checked <?php }?>>
                                        <i></i>
                                    </label>
                                </div>
                            </td>
                            <td><a href="<?php if ($_smarty_tpl->tpl_vars['matching_bonus_status']->value == 'yes') {?> <?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/configuration/matching_bonus <?php } else { ?> javascript:void(0); <?php }?>"class="btn btn-sm btn-icon <?php if ($_smarty_tpl->tpl_vars['matching_bonus_status']->value == 'yes') {?> btn-rounded btn-default <?php } else { ?> btn-disabled btn-muted<?php }?>"> <i class="fa fa-cog"></i></a></td>
                        </tr>
                    <?php }?>

                    <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['rank_status'] == 'yes' && $_smarty_tpl->tpl_vars['bonus']->value['pool_bonus'] == 'yes') {?>
                        <tr>
                            <td><?php echo lang('pool_bonus');?>
</td>
                            <td>
                                <div class="form-group-button">
                                    <label class="i-switch bg-primary">
                                        <input type="checkbox" class="compensations" data-name="pool_bonus" name="pool_bonus_status" <?php if ($_smarty_tpl->tpl_vars['pool_bonus_status']->value == 'yes') {?> checked <?php }?>>
                                        <i></i>
                                    </label>
                                </div>
                            </td>
                            <td><a href="<?php if ($_smarty_tpl->tpl_vars['pool_bonus_status']->value == 'yes') {?> <?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/pool_bonus_config <?php } else { ?> javascript:void(0); <?php }?>"class="btn btn-sm btn-icon <?php if ($_smarty_tpl->tpl_vars['pool_bonus_status']->value == 'yes') {?> btn-rounded btn-default <?php } else { ?> btn-disabled btn-muted<?php }?>"> <i class="fa fa-cog"></i></a></td>
                        </tr>
                    <?php }?>

                    <?php if ($_smarty_tpl->tpl_vars['bonus']->value['fast_start_bonus'] == 'yes') {?>
                        <tr>
                            <td><?php echo lang('fast_start_bonus');?>
</td>
                            <td>
                                <div class="form-group-button">
                                    <label class="i-switch bg-primary">
                                        <input type="checkbox" class="compensations" data-name="fast_start_bonus" name="fast_start_bonus_status" <?php if ($_smarty_tpl->tpl_vars['fast_start_bonus_status']->value == 'yes') {?> checked <?php }?>>
                                        <i></i>
                                    </label>
                                </div>
                            </td>
                            <td><a href="<?php if ($_smarty_tpl->tpl_vars['fast_start_bonus_status']->value == 'yes') {?> <?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/fast_start_bonus_config <?php } else { ?> javascript:void(0); <?php }?>"class="btn btn-sm btn-icon <?php if ($_smarty_tpl->tpl_vars['fast_start_bonus_status']->value == 'yes') {?> btn-rounded btn-default <?php } else { ?> btn-disabled btn-muted<?php }?>"> <i class="fa fa-cog"></i></a></td>
                        </tr>
                    <?php }?>

                    <?php if ($_smarty_tpl->tpl_vars['bonus']->value['performance_bonus'] == 'yes') {?>
                        <tr>
                            <td><?php echo lang('performance_bonus');?>
</td>
                            <td>
                                <div class="form-group-button">
                                    <label class="i-switch bg-primary">
                                        <input type="checkbox" class="compensations" data-name="performance_bonus" name="performance_bonus_status" <?php if ($_smarty_tpl->tpl_vars['performance_bonus_status']->value == 'yes') {?> checked <?php }?>>
                                        <i></i>
                                    </label>
                                </div>
                            </td>
                            <td><a href="<?php if ($_smarty_tpl->tpl_vars['performance_bonus_status']->value == 'yes') {?> <?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/configuration/performance_bonus <?php } else { ?> javascript:void(0); <?php }?>"class="btn btn-sm btn-icon <?php if ($_smarty_tpl->tpl_vars['performance_bonus_status']->value == 'yes') {?> btn-rounded btn-default <?php } else { ?> btn-disabled btn-muted<?php }?>"> <i class="fa fa-cog"></i></a></td>
                        </tr>
                    <?php }?>

                    <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['repurchase_status'] == 'yes' || ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['opencart_status'] == "yes" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['opencart_status_demo'] == "yes")) {?>
                       <!-- <tr>
                            <td><?php echo lang('sales_commission');?>
</td>
                            <td>
                                <div class="form-group-button">
                                    <label class="i-switch bg-primary">
                                        <input type="checkbox" class="compensations" data-name="sales_commission" name="sales_commission" <?php if ($_smarty_tpl->tpl_vars['sales_commission_status']->value == 'yes') {?> checked <?php }?>>
                                        <i></i>
                                    </label>
                                </div>
                            </td>
                            <td><a href="<?php if ($_smarty_tpl->tpl_vars['sales_commission_status']->value == 'yes') {?> <?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/configuration/sales_commission <?php } else { ?> javascript:void(0); <?php }?>"class="btn btn-sm btn-icon <?php if ($_smarty_tpl->tpl_vars['sales_commission_status']->value == 'yes') {?> btn-rounded btn-default <?php } else { ?> btn-disabled btn-muted<?php }?>"> <i class="fa fa-cog"></i></a></td>
                        </tr>-->
                    <?php }?>
                    
                    <tr>
                        <td><?php echo lang('car_bonus_config');?>
</td>
                        <td>
                            <div class="form-group-button">
                                <label class="i-switch bg-primary">
                                    <input type="checkbox" class="compensations" data-name="car_bonus" name="car_bonus" <?php if ($_smarty_tpl->tpl_vars['car_bonus_status']->value == 'yes') {?> checked <?php }?>>
                                    <i></i>
                                </label>
                            </div>
                        </td>
                        <td><a href="<?php if ($_smarty_tpl->tpl_vars['car_bonus_status']->value == 'yes') {?> <?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/configuration/car_bonus_config <?php } else { ?> javascript:void(0); <?php }?>"class="btn btn-sm btn-icon <?php if ($_smarty_tpl->tpl_vars['car_bonus_status']->value == 'yes') {?> btn-rounded btn-default <?php } else { ?> btn-disabled btn-muted <?php }?>"> <i class="fa fa-cog"></i></a></td>
                    </tr>
                     <tr>
                        <td><?php echo lang('global_bonus_config');?>
</td>
                        <td>
                            <div class="form-group-button">
                                <label class="i-switch bg-primary">
                                    <input type="checkbox" class="compensations" data-name="global_bonus" name="global_bonus" <?php if ($_smarty_tpl->tpl_vars['global_bonus_status']->value == 'yes') {?> checked <?php }?>>
                                    <i></i>
                                </label>
                            </div>
                        </td>
                        <td><a href="<?php if ($_smarty_tpl->tpl_vars['global_bonus_status']->value == 'yes') {?> <?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
admin/configuration/global_bonus_config <?php } else { ?> javascript:void(0); <?php }?>"class="btn btn-sm btn-icon <?php if ($_smarty_tpl->tpl_vars['global_bonus_status']->value == 'yes') {?> btn-rounded btn-default <?php } else { ?> btn-disabled btn-muted <?php }?>"> <i class="fa fa-cog"></i></a></td>
                    </tr>

                </tbody>
            </table>

            <div id='compensation_div'> </div>

        </div>
    </div>
</div>

<div class="alert alert-success alert-dismissable" style="display: none;" id="success-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?php echo lang('configuration_success');?>
 </div>
<div class="alert alert-danger alert-dismissable" style="display: none;" id="error-box"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> <?php echo lang('configuration_error');?>
 </div>

<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'style'} */
class Block_18674841355f29f73451cec5_50070970 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

     <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

<style>
    .table>tbody>tr>td {
        text-align: left;
        border-bottom:0;
        border-top: 0;
    }

    table.table thead {
        background-color: white;
    }
     </style>
<?php
}
}
/* {/block 'style'} */
/* {block 'script'} */
class Block_8624520165f29f73451db97_58104294 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

     <?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

         <?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/plan_settings.js"><?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
}
