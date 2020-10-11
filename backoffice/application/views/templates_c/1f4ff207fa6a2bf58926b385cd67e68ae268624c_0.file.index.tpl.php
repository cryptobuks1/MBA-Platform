<?php
/* Smarty version 3.1.30, created on 2020-09-25 18:52:08
  from "/home/mbatradingacadem/public_html/office/backoffice/application/views/user/home/index.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5f6dafb8699777_39571317',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1f4ff207fa6a2bf58926b385cd67e68ae268624c' => 
    array (
      0 => '/home/mbatradingacadem/public_html/office/backoffice/application/views/user/home/index.tpl',
      1 => 1601023926,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:user/home/rank_popup.tpl' => 2,
    'file:layout/demo_footer.tpl' => 1,
  ),
),false)) {
function content_5f6dafb8699777_39571317 (Smarty_Internal_Template $_smarty_tpl) {
if (!is_callable('smarty_modifier_truncate')) require_once '/home/mbatradingacadem/public_html/office/backoffice/application/third_party/Smarty/plugins/modifier.truncate.php';
if (!is_callable('smarty_modifier_capitalize')) require_once '/home/mbatradingacadem/public_html/office/backoffice/application/third_party/Smarty/plugins/modifier.capitalize.php';
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_42848445f6dafb861c127_93134262', 'script');
?>

<?php if ($_smarty_tpl->tpl_vars['join_type']->value == 'affiliate') {
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_625984235f6dafb8654709_39619110', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>



  <?php } else {
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2138537575f6dafb868c633_24392406', $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value);
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_3092016075f6dafb8698237_73474697', 'right_content');
?>

<?php }
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_13492758095f6dafb8699430_97569650', 'home_wrapper_out');
$_smarty_tpl->inheritance->endChild();
$_smarty_tpl->_subTemplateRender($_smarty_tpl->tpl_vars['BASE_TEMPLATE']->value, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 2, true);
}
/* {block 'script'} */
class Block_42848445f6dafb861c127_93134262 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<?php 
$_smarty_tpl->inheritance->callParent($_smarty_tpl, $this);
?>

<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
plugins/clipboard.min.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->tpl_vars['PUBLIC_URL']->value;?>
javascript/todo_config.js" type="text/javascript"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
  country_map_data = {
    $map_data
  };
<?php echo '</script'; ?>
>
<?php
}
}
/* {/block 'script'} */
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_625984235f6dafb8654709_39619110 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<style>
  .demo_section {

    display: none;
  }

  .setting_margin_top {

    margin-top: -50px;
  }

  .setting_margin {
    margin-left: 230px;
  }

  .wrapper_index {

    padding: 15px
  }

  .demo_margin_top {

    margin-top: -30px;
  }

  .demo_footer_user {
    margin-top: -50px;
  }

  < !--opoup-->.demo_margin_top {

    margin-top: -30px;
  }

  .modal-content_1 {
    background-color: #fff;

  }

  .pager {

    margin: 0px 0;
    box-shadow: 0px 2px 17px 0px #19191942;
  }

  .modal-content_1 {
    position: relative;

    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid #999;
    border: 1px solid rgba(255, 255, 255, 0.58);
    outline: 0;
    -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, .5);
    box-shadow: 0 3px 9px rgba(0, 0, 0, .5);
  }

  .modal-dialog.modal-md.index {
    width: 35%;
    top: 7%;
    margin: 0 auto;
    position: relative;
    right: 0;
  }

  div#subscribeModal {
    padding-right: 0px !important;
  }





  @media (max-width:767px) {
    .demo_section {

      display: block;
    }

    .moblie_demo {

      display: none;

    }

    .setting_margin {
      margin-left: 0px;
    }

    .setting_margin_top {
      margin-top: -49px !important;
    }

    .demo_margin_top {
      margin-top: -27px !important;
    }

    .modal-content_1 {
      background-color: #fff !important;

    }
  }
</style>
<?php $_smarty_tpl->_subTemplateRender("file:user/home/rank_popup.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>

<div id="span_js_messages" style="display: none;"> <span id="left_join"><?php echo lang('left_join');?>
</span> <span
    id="right_join"><?php echo lang('right_join');?>
</span> <span id="join"><?php echo lang('joinings');?>
</span> <span
    id="confirm_msg"><?php echo lang('are_you_sure_want_delete');?>
</span> </div>
<input name="mlm_plan" id="mlm_plan" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;?>
" />
<div class="col-sm-12">
  <div class="row">
    <div class="row row-sm text-center"> <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['roi_status'] == "yes") {?>
      <div class="col-sm-4">
        <div class="panel padder-v item">
          <div class="h1 text-info font-thin h1">
            <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round(($_smarty_tpl->tpl_vars['roi_details']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value),2);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</div>
          <span class="text-muted text-xs"><?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] == "yes") {
echo lang('total_deposit');
} else {
echo lang('Hyip');
}?></span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
              <ul class="dropdown-menu dropdown-menu_right">
                <li class="text-center"><a href=""><?php echo lang('view_more');?>
</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <?php }?>
      <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['ewallet_status'] == "yes" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['roi_status'] == "no") {?>
      <div class="col-sm-4" id="section_tile1">
        <div class="panel padder-v item">
          <div class="h1 text-info font-thin h1"> <?php echo $_smarty_tpl->tpl_vars['total_amount']->value;?>
 </div>
          <span class="text-muted text-xs"><?php echo lang('commission_earned');?>
</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
            </div>
          </div>
        </div>
      </div>
      <?php }?>
      <?php ob_start();
echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;
$_prefixVariable1=ob_get_clean();
if ($_prefixVariable1 != "Donation" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] != "yes") {?>
      <div class="col-sm-4" id="section_tile2">
        <div class="panel padder-v item bg-primary">
          <div class="text-white font-thin h1 block1" id="sales_total"><?php echo $_smarty_tpl->tpl_vars['total_payout']->value;?>
</div>
          <span class="text-muted text-xs"><?php echo lang('payout_released');?>
</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>

            </div>
          </div>
        </div>
      </div>
      <?php }?>
      <div class="col-sm-4" id="section_tile2">
        <div class="panel padder-v item bg-primary">
          <span class="text-muted text-xs"><?php echo lang('left_team');?>
</span>
          <div class="text-white font-thin  block1" id="sales_total">USERS : <?php echo $_smarty_tpl->tpl_vars['total_left_user_count']->value;?>
</div>
          <div class="text-white font-thin  block1" id="sales_total">BV : <?php echo $_smarty_tpl->tpl_vars['total_left_user_pv']->value;?>
</div>

          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>

            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4" id="section_tile3">
        <div class="panel padder-v item bg-info">
          <div class="text-white font-thin h1 block1" id="total_payout"> <?php echo $_smarty_tpl->tpl_vars['requested_amount']->value;?>
 </div>
          <span class="text-muted text-xs"><?php echo lang('payout_pending');?>
</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
              <ul class="dropdown-menu dropdown-menu_right" id="payout_dash">
                <li class="active"><a href="javascript:void(0);" id="all_payout"><i class="fa fa-list margin-r-5"></i>
                    <?php echo lang('all');?>
</a></li>
                <li><a href="javascript:void(0);" id="yearly_payout"><i class="fa fa-calendar margin-r-5"></i>
                    <?php echo lang('this_year');?>
</a></li>
                <li><a href="javascript:void(0);" id="monthly_payout"><i class="fa fa-calendar margin-r-5"></i>
                    <?php echo lang('this_month');?>
</a></li>
                <li><a href="javascript:void(0);" id="weekly_payout"><i class="fa fa-calendar margin-r-5"></i>
                    <?php echo lang('this_week');?>
</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-2" id="section_tile2">
        <div class="panel padder-v item bg-primary">
          <div class="text-white font-thin h1 block1" id="sales_total"><?php echo $_smarty_tpl->tpl_vars['total_sales']->value;?>
</div>
          <span class="text-muted text-xs"><?php echo lang('total_sales');?>
</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>

            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-2" id="section_tile2">
        <div class="panel padder-v item bg-info">
          <div class="text-white font-thin h1 block1" id="sales_total"><?php echo $_smarty_tpl->tpl_vars['total_users']->value;?>
</div>
          <span class="text-muted text-xs"><?php echo lang('total_users');?>
</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>

            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-4" id="section_tile2">
        <div class="panel padder-v item bg-primary">

          <span class="text-muted text-xs"><?php echo lang('right_team');?>
</span>
          <div class="text-white font-thin block1" id="sales_total">USERS : <?php echo $_smarty_tpl->tpl_vars['total_right_user_count']->value;?>
</div>
          <div class="text-white font-thin  block1" id="sales_total">BV : <?php echo $_smarty_tpl->tpl_vars['total_right_user_pv']->value;?>
</div>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>

            </div>
          </div>
        </div>
      </div>
      <!---hyip section-->
      <?php ob_start();
echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;
$_prefixVariable2=ob_get_clean();
if ($_prefixVariable2 == "Unilevel" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] == "yes") {?>

      <div class="col-xs-6">
        <div class="panel padder-v item bg-info">
          <div class="text-info font-thin h1 block1">
            <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round(($_smarty_tpl->tpl_vars['total_matured_deposit']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value),2);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>

          </div>
          <span class="text-muted text-xs"> <?php echo lang('matured_deposit');?>
</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
              <ul class="dropdown-menu dropdown-menu_right">
                <li class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/matured_deposit"> <?php echo lang('view_more');?>
</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <?php }?>
      <!---end hyip section-->

      <!---DONATION TILE-->
      <?php ob_start();
echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;
$_prefixVariable3=ob_get_clean();
if ($_prefixVariable3 == "Donation") {?>
      <div class="col-xs-6">
        <div class="panel padder-v item bg-primary">
          <div class="text-white font-thin h1 block1"><?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo $_smarty_tpl->tpl_vars['given_commission']->value;
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>

          </div>
          <span class="text-muted text-xs"><?php echo lang('given_donation');?>
</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
              <ul class="dropdown-menu dropdown-menu_right">
                <li class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/donation/sent_donation_report"> View More</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <div class="col-xs-6">
        <div class="panel padder-v item bg-info">
          <div class="text-white font-thin h1 block1">
            <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo $_smarty_tpl->tpl_vars['recieved_commission']->value;
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</div>
          <span class="text-muted text-xs"><?php echo lang('received_donation');?>
</span>
          <div class="top text-right w-full">
            <div class="dropdown">
              <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
              <ul class="dropdown-menu dropdown-menu_right">
                <li class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/donation/recieve_donation_report"> View More</a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>

      <!--END DONATION TILE-->

      <div class="col-xs-12 m-b-md">
        <div class="r bg-light dker item hbox no-border">
          <div class="col w-xs v-middle hidden-md">
            <div class="sparkline inline">
              <button class="btn btn-sm btn-primary" type="submit">
                <a class="btn1 btn-4 btn-4a icon-arrow"
                  href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/donation/donation_view"><?php echo lang('donate');?>
</a>
              </button>
            </div>
          </div>
          <div class="col dk padder-v r-r">
            <div class="text-primary-dk font-thin h1"><span><?php echo $_smarty_tpl->tpl_vars['level_name']->value;?>
</span></div>
            <span class="text-muted text-xs"><?php echo lang('your_current_status');?>
</span>
          </div>
        </div>
      </div>
      <?php }?>
    </div>


  </div>

  <div class="row">
    <div class="col-sm-4" style="font-size:12px !important;">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted"><?php echo lang('personal_data');?>
</h4>
        </div>
        <div class="row" style="margin:1px;min-height:210px !important;">
          <div class="col-sm-8" style="margin-top:10px;">
            <label>Username</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label><?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
</label>
          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label>Total Personal Volume</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label><?php echo $_smarty_tpl->tpl_vars['personal_pv']->value;?>
</label>
          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label>Current Rank</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label><?php echo $_smarty_tpl->tpl_vars['rank_name']->value;?>
</label>
          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label>Highest Rank Achieved</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label><?php echo $_smarty_tpl->tpl_vars['highest_rank']->value;?>
</label>
          </div>
        </div>
      </div>
    </div>


    <div class="col-sm-4" style="font-size:12px !important;">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted"><?php echo lang('earnings');?>
</h4>
        </div>
        <div class="row" style="margin:1px;min-height:210px;">
          <div class="col-sm-8" style="margin-top:10px;">
            <label><?php echo lang('last_7_days');?>
</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <?php if ($_smarty_tpl->tpl_vars['last_week_earnings']->value == NULL) {?>
            <label>00</label>
            <?php } else { ?>
            <label><?php echo $_smarty_tpl->tpl_vars['last_week_earnings']->value;?>
</label>
            <?php }?>
          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label><?php echo lang('last_30_days');?>
</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <?php if ($_smarty_tpl->tpl_vars['last_month_earnings']->value == NULL) {?>
            <label>00</label>
            <?php } else { ?>
            <label><?php echo $_smarty_tpl->tpl_vars['last_month_earnings']->value;?>
</label>
            <?php }?>

          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label><?php echo lang('avg_earnings');?>
</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <?php if ($_smarty_tpl->tpl_vars['avg_earnings']->value == NULL) {?>
            <label>00</label>
            <?php } else { ?>
            <label><?php echo $_smarty_tpl->tpl_vars['avg_earnings']->value;?>
</label>
            <?php }?>

          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label><?php echo lang('year_earnings');?>
</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <?php if ($_smarty_tpl->tpl_vars['year_earnings']->value == NULL) {?>
            <label>00</label>
            <?php } else { ?>
            <label><?php echo $_smarty_tpl->tpl_vars['year_earnings']->value;?>
</label>
            <?php }?>
          </div>

        </div>
      </div>
    </div>
    
    <div class="col-sm-4" style="font-size:12px !important;">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted"><?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
</h4>
          <div><?php echo lang('package');?>
 : <b><?php echo $_smarty_tpl->tpl_vars['current_product']->value;?>
</b></div>
          <a href="profile_view"><?php echo lang('view_profile');?>
</a>
        </div>
        <div class="row" style="margin:1px;min-height:175px;">
          <div class="col-sm-5" style="margin-top:10px;">
            <label><?php echo lang('sponsor_name');?>
</label>
          </div>
          <div class="col-sm-5" style="margin-top:10px;">
            <label><?php echo $_smarty_tpl->tpl_vars['sponsor_name']->value;?>
</label>
          </div>
          <div class="col-sm-5" style="margin-top:10px;">
            <label><?php echo lang('placement_user_name');?>
</label>
          </div>
          <div class="col-sm-5" style="margin-top:10px;">
            <label><?php echo $_smarty_tpl->tpl_vars['placement_name']->value;?>
</label>
          </div>
          <div class="col-sm-8" style="margin-top:10px;">
            <label><?php echo lang('gpv');?>
</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label><?php echo $_smarty_tpl->tpl_vars['group_pv']->value;?>
</label>
          </div>

        </div>
      </div>
    </div>

     
    <div class="col-sm-4" style="font-size:12px !important;">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted"><?php echo lang('next_rank_achievement');?>
</h4>
        </div>
        <div class="row" style="margin:1px;min-height:210px;">
          <div class="col-sm-8" style="margin-top:10px;">
            <label><?php echo lang('nex_rank');?>
</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label><?php echo $_smarty_tpl->tpl_vars['next_rank']->value;?>
</label>
          </div>

  <div class="col-sm-8" style="margin-top:10px;">
            <label>Current Referral Count</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label><?php echo $_smarty_tpl->tpl_vars['total_users']->value;?>
 </label>
          </div>
            <div class="col-sm-8" style="margin-top:10px;">
            <label>Referral count required for <?php echo $_smarty_tpl->tpl_vars['next_rank']->value;?>
</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label><?php echo $_smarty_tpl->tpl_vars['rankCriteria']->value["next_rank"]["referral_count"];?>
</label>
          </div>

                <div class="col-sm-8" style="margin-top:10px;">
            <label>Referral count still required</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label><?php echo max($_smarty_tpl->tpl_vars['rankCriteria']->value['next_rank']['referral_count']-$_smarty_tpl->tpl_vars['rankCriteria']->value['current_rank']['referral_count'],0);?>
</label>
          </div>


          <div class="col-sm-8" style="margin-top:10px;">
            <label>Total Personal Volume</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label><?php echo $_smarty_tpl->tpl_vars['personal_pv']->value;?>
</label>
          </div>

            <div class="col-sm-8" style="margin-top:10px;">
            <label>Personal PV required for <?php echo $_smarty_tpl->tpl_vars['next_rank']->value;?>
</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label><?php echo $_smarty_tpl->tpl_vars['rankCriteria']->value["next_rank"]["personal_pv"];?>
</label>
          </div>

          <div class="col-sm-8" style="margin-top:10px;">
            <label>PV still required</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label><?php echo max($_smarty_tpl->tpl_vars['rankCriteria']->value['next_rank']['personal_pv']-$_smarty_tpl->tpl_vars['rankCriteria']->value['current_rank']['personal_pv'],0);?>
</label>
          </div>
        
        
          
        
          <div class="col-sm-8" style="margin-top:10px;">
            <label>Weak leg BV required to rank up to <?php echo $_smarty_tpl->tpl_vars['next_rank']->value;?>
</label>
          </div>
          <div class="col-sm-2" style="margin-top:10px;">
            <label><?php echo $_smarty_tpl->tpl_vars['rankCriteria']->value["next_rank"]["group_pv"];?>
 </label>
          </div>
          
        </div>
      </div>
    </div>
    

    
    
    


  </div>

  <div class="row">
    <div class="col-sm-4">
      <div class="panel no-border" id="section_top_earners" style="min-height:640px;">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted"><?php echo lang('top_earners');?>
</h4>
        </div>
        <ul class="list-group list-group-lg m-b-none">
          <?php $_smarty_tpl->_assignInScope('i', 0);
?>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['top_earners']->value, 'j');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['j']->value) {
?>
          <li class="list-group-item"> <a href="javascript:void(0);" class="thumb-sm m-r"> <img
                src="<?php echo $_smarty_tpl->tpl_vars['j']->value['profile_picture_full'];?>
" class="r r-2x"> </a>
            <span class="pull-right text-muted inline m-t-sm"><?php echo $_smarty_tpl->tpl_vars['j']->value['place'];?>
</span>
            <!--balance_amount-->
            <a href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['j']->value['user_name'];?>
</a> </li>
          <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

          <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>
          <li class="list-group-item"><?php echo lang('no_data_found');?>
</li>
          <?php }?>
        </ul>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted"><?php echo lang('top_recruiters');?>
</h4>
        </div>
        <ul class="list-group list-group-lg m-b-none">
          <?php $_smarty_tpl->_assignInScope('i', 0);
?>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['top_recruters']->value, 'j');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['j']->value) {
?>
          <li class="list-group-item"><a href="javascript:void(0);"> <?php echo $_smarty_tpl->tpl_vars['j']->value['user_name'];?>
</a>
            <span class="pull-right"><?php echo $_smarty_tpl->tpl_vars['j']->value['count'];?>
</span></li>
          <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

          <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>
          <li class="list-group-item"><?php echo lang('no_data_found');?>
</li>
          <?php }?>
        </ul>
      </div>
    </div>
    <div class="col-sm-4">
      <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['replicated_site_status'] == "yes") {?>
      <div class="col-xs-12" id="section_tile5">
        <div class="panel item">
          <div class="panel-body">
            <div class="pull-right icon_margin_top">
              <button title="<?php echo lang('share_link');?>
" onClick="twittershare('<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/replica/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
');"
                class="btn btn-lg btn-icon btn-link text-info"><i class="fa fa-twitter"></i></button>
              
              <button title="<?php echo lang('share_link');?>
"
                onClick="facebookShare('https://www.facebook.com/sharer/sharer.php?u=<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/replica/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
');"
                class="btn btn-lg btn-icon btn-link text-fb"><i class="fa fa-facebook"></i></button>
            </div>
            <div class="clear pull-left">
              <div class="text-left m-b-xs block"><?php echo lang('Your_Replicated_Website_Link');?>
<i class="icon-twitter"></i>
              </div>
              <div
                data-clipboard-text="<?php if (DEMO_STATUS == 'yes') {
echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/replica/<?php echo $_smarty_tpl->tpl_vars['ADMIN_USER_NAME']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;
} else {
echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/replica/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;
}?>"
                id="copy_link_replica" class=" b-info b-l-4x btn btn-addon btn-default btn-sm has-tooltip"><i
                  class="fa fa-copy text-info"></i><?php echo lang('copy_link');?>
</div>
            </div>
          </div>
        </div>
      </div>
      <?php }?>
    </div>

    <!--<div class="col-sm-4">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted"><?php echo lang('package_overview');?>
</h4>
        </div>-->
    <!-- <ul class="list-group list-group-lg m-b-none">
          <?php $_smarty_tpl->_assignInScope('i', 0);
?>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['top_recruters']->value, 'j');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['j']->value) {
?>
           
          <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

          <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>
          <li class="list-group-item"><?php echo lang('no_data_found');?>
</li>
          <?php }?>
        </ul>-->
    <!-- <?php if (count($_smarty_tpl->tpl_vars['prgrsbar_data']->value) > 0 && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['product_status'] == 'yes') {?>
    <div class="col wrapper-lg w-lg bg-light dk r-r">
     
      <?php $_smarty_tpl->_assignInScope('j', 0);
?>
      <div class=""> <?php $_smarty_tpl->_assignInScope('text_class', array('text-primary','text-primary','text-primary','text-primary'));
?>
        <?php $_smarty_tpl->_assignInScope('bg_class', array('bg-primary','bg-primary','bg-primary','bg-primary'));
?>
        <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['prgrsbar_data']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
        <div class=""> <span class="pull-right <?php echo $_smarty_tpl->tpl_vars['text_class']->value[$_smarty_tpl->tpl_vars['j']->value];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['joining_count'];?>
</span> <span><?php echo $_smarty_tpl->tpl_vars['v']->value['package_name'];?>
</span> </div>
        <div class="progress progress-xs m-t-sm bg-white">
          <div class="progress-bar <?php echo $_smarty_tpl->tpl_vars['bg_class']->value[$_smarty_tpl->tpl_vars['j']->value];?>
" data-toggle="tooltip" data-original-title="<?php echo $_smarty_tpl->tpl_vars['prgrsbar_data']->value[0]['perc']*$_smarty_tpl->tpl_vars['v']->value['joining_count'];?>
%" style="width: <?php echo $_smarty_tpl->tpl_vars['prgrsbar_data']->value[0]['perc']*$_smarty_tpl->tpl_vars['v']->value['joining_count'];?>
%"></div>
        </div>
        <?php $_smarty_tpl->_assignInScope('j', $_smarty_tpl->tpl_vars['j']->value+1);
?>
        <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>
 </div>
      <?php if ($_smarty_tpl->tpl_vars['j']->value > 3) {?>
      <div class="pull-right read_more_button-top"> <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/home/package_list" class="read_more bg-primary"><?php echo lang('view_more');?>
</a> </div>
      <?php }?> </div>
    <?php }?>
      </div>
    
   
  </div>-->

  </div>
  <br>
  <div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" id="reservation_detail_model"
    data-backdrop="static" class="modal fade" style="display: none;">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">
          <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
          <h4 class="modal-title" id="modaltitle"></h4>
        </div>
        <div class="modal-body" id="reservation_detail_model_body"> </div>
      </div>
    </div>
  </div>

  <?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
class Block_2138537575f6dafb868c633_24392406 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <div id="span_js_messages" style="display: none;"> <span id="left_join"><?php echo lang('left_join');?>
</span> <span
      id="right_join"><?php echo lang('right_join');?>
</span> <span id="join"><?php echo lang('joinings');?>
</span> <span
      id="confirm_msg"><?php echo lang('are_you_sure_want_delete');?>
</span> </div>
  <input name="mlm_plan" id="mlm_plan" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;?>
" />
  <div class="col">
    <div class="row">
      <div class="col-lg-6 col-md-12" id="section_tile">
        <div class="row row-sm text-center"> <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['roi_status'] == "yes") {?>
          <div class="col-xs-6">
            <div class="panel padder-v item">
              <div class="h1 text-info font-thin h1">
                <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round(($_smarty_tpl->tpl_vars['roi_details']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value),2);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</div>
              <span class="text-muted text-xs"><?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] == "yes") {
echo lang('total_deposit');
} else {
echo lang('Hyip');
}?></span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right">
                    <li class="text-center"><a href=""><?php echo lang('view_more');?>
</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <?php }?>
          <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['ewallet_status'] == "yes" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['roi_status'] == "no") {?>
          <div class="col-xs-6" id="section_tile1">
            <div class="panel padder-v item">
              <div class="h1 text-info font-thin h1"> <?php echo $_smarty_tpl->tpl_vars['total_amount']->value;?>
 </div>
              <span class="text-muted text-xs"><?php echo lang('e_wallet');?>
</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                </div>
              </div>
            </div>
          </div>
          <?php }?>
          <?php ob_start();
echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;
$_prefixVariable4=ob_get_clean();
if ($_prefixVariable4 != "Donation" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] != "yes") {?>
          <div class="col-xs-6" id="section_tile2">
            <div class="panel padder-v item bg-primary">
              <div class="text-white font-thin h1 block1" id="sales_total"><?php echo $_smarty_tpl->tpl_vars['total_sales']->value;?>
</div>
              <span class="text-muted text-xs"><?php echo lang('sales');?>
</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right" id="sales_dash">
                    <li class="active"><a href="javascript:void(0);" id="all_sales"><i
                          class="fa fa-list margin-r-5"></i> <?php echo lang('all');?>
</a></li>
                    <li><a href="javascript:void(0);" id="yearly_sales"><i class="fa fa-calendar margin-r-5"></i>
                        <?php echo lang('this_year');?>
</a></li>
                    <li><a href="javascript:void(0);" id="monthly_sales"><i class="fa fa-calendar margin-r-5"></i>
                        <?php echo lang('this_month');?>
</a></li>
                    <li><a href="javascript:void(0);" id="weekly_sales"><i class="fa fa-calendar margin-r-5"></i>
                        <?php echo lang('this_week');?>
</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <?php }?>
          <div class="col-xs-6" id="section_tile3">
            <div class="panel padder-v item bg-info">
              <div class="text-white font-thin h1 block1" id="total_payout"> <?php echo $_smarty_tpl->tpl_vars['total_payout']->value;?>
 </div>
              <span class="text-muted text-xs"><?php echo lang('payout');?>
</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right" id="payout_dash">
                    <li class="active"><a href="javascript:void(0);" id="all_payout"><i
                          class="fa fa-list margin-r-5"></i> <?php echo lang('all');?>
</a></li>
                    <li><a href="javascript:void(0);" id="yearly_payout"><i class="fa fa-calendar margin-r-5"></i>
                        <?php echo lang('this_year');?>
</a></li>
                    <li><a href="javascript:void(0);" id="monthly_payout"><i class="fa fa-calendar margin-r-5"></i>
                        <?php echo lang('this_month');?>
</a></li>
                    <li><a href="javascript:void(0);" id="weekly_payout"><i class="fa fa-calendar margin-r-5"></i>
                        <?php echo lang('this_week');?>
</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <?php ob_start();
echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;
$_prefixVariable5=ob_get_clean();
if ($_prefixVariable5 != "Donation" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] != "yes") {?>
          <div class="col-xs-6" id="section_tile4">
            <div class="panel padder-v item">
              <div class="font-thin text-info h1" id="mail_total"><?php echo $_smarty_tpl->tpl_vars['read_mail']->value;?>
</div>
              <span class="text-muted text-xs"><?php echo lang('mail');?>
</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right" id="mail_dash">
                    <li class="active"><a href="javascript:void(0);" id="all_mail"><i class="fa fa-list margin-r-5"></i>
                        <?php echo lang('all');?>
</a></li>
                    <li><a href="javascript:void(0);" id="yearly_mail"><i class="fa fa-calendar margin-r-5"></i>
                        <?php echo lang('this_year');?>
</a></li>
                    <li><a href="javascript:void(0);" id="monthly_mail"><i class="fa fa-calendar margin-r-5"></i>
                        <?php echo lang('this_month');?>
</a></li>
                    <li><a href="javascript:void(0);" id="weekly_mail"><i class="fa fa-calendar margin-r-5"></i>
                        <?php echo lang('this_week');?>
</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <?php }?>
          <!---hyip section-->
          <?php ob_start();
echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;
$_prefixVariable6=ob_get_clean();
if ($_prefixVariable6 == "Unilevel" && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['hyip_status'] == "yes") {?>
          <div class="col-xs-6">
            <div class="panel padder-v item bg-primary">
              <div class="text-white font-thin h1 block1">
                <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round(($_smarty_tpl->tpl_vars['total_active_deposit']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value),2);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>

              </div>
              <span class="text-muted text-xs"> <?php echo lang('active_deposit');?>
</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right">
                    <li class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/active_deposit"> <?php echo lang('view_more');?>
</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="panel padder-v item bg-info">
              <div class="text-info font-thin h1 block1">
                <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo round(($_smarty_tpl->tpl_vars['total_matured_deposit']->value*$_smarty_tpl->tpl_vars['DEFAULT_CURRENCY_VALUE']->value),2);
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>

              </div>
              <span class="text-muted text-xs"> <?php echo lang('matured_deposit');?>
</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right">
                    <li class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/matured_deposit"> <?php echo lang('view_more');?>
</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <?php }?>
          <!---end hyip section-->

          <!---DONATION TILE-->
          <?php ob_start();
echo $_smarty_tpl->tpl_vars['MLM_PLAN']->value;
$_prefixVariable7=ob_get_clean();
if ($_prefixVariable7 == "Donation") {?>
          <div class="col-xs-6">
            <div class="panel padder-v item bg-primary">
              <div class="text-white font-thin h1 block1">
                <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo $_smarty_tpl->tpl_vars['given_commission']->value;
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</div>
              <span class="text-muted text-xs"><?php echo lang('given_donation');?>
</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right">
                    <li class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/donation/sent_donation_report"> View More</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xs-6">
            <div class="panel padder-v item bg-info">
              <div class="text-white font-thin h1 block1">
                <?php echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_LEFT']->value;
echo $_smarty_tpl->tpl_vars['recieved_commission']->value;
echo $_smarty_tpl->tpl_vars['DEFAULT_SYMBOL_RIGHT']->value;?>
</div>
              <span class="text-muted text-xs"><?php echo lang('received_donation');?>
</span>
              <div class="top text-right w-full">
                <div class="dropdown">
                  <div data-toggle="dropdown" aria-expanded="false"> <i class="fas fa fa-cog fa-spin"></i> </div>
                  <ul class="dropdown-menu dropdown-menu_right">
                    <li class="text-center"><a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/donation/recieve_donation_report"> View More</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <!--END DONATION TILE-->

          <div class="col-xs-12 m-b-md">
            <div class="r bg-light dker item hbox no-border">
              <div class="col w-xs v-middle hidden-md">
                <div class="sparkline inline">
                  <button class="btn btn-sm btn-primary" type="submit">
                    <a class="btn1 btn-4 btn-4a icon-arrow"
                      href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/donation/donation_view"><?php echo lang('donate');?>
</a>
                  </button>
                </div>
              </div>
              <div class="col dk padder-v r-r">
                <div class="text-primary-dk font-thin h1"><span><?php echo $_smarty_tpl->tpl_vars['level_name']->value;?>
</span></div>
                <span class="text-muted text-xs"><?php echo lang('your_current_status');?>
</span>
              </div>
            </div>
          </div>
          <?php }?>
          <?php if ($_smarty_tpl->tpl_vars['is_app']->value) {?>
          <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['replicated_site_status'] == "yes") {?>
          <div class="col-xs-12" id="section_tile5">
            <div class="panel item">
              <div class="panel-body">
                <div class="pull-right icon_margin_top">
                  <button title="<?php echo lang('share_link');?>
" onClick="twittershare('<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/replica/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
');"
                    class="btn btn-lg btn-icon btn-link text-info"><i class="fa fa-twitter"></i></button>
                  
                  <button title="<?php echo lang('share_link');?>
"
                    onClick="facebookShare('https://www.facebook.com/sharer/sharer.php?u=<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/replica/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
');"
                    class="btn btn-lg btn-icon btn-link text-fb"><i class="fa fa-facebook"></i></button>
                </div>
                <div class="clear pull-left">
                  <div class="text-left m-b-xs block"><?php echo lang('Your_Replicated_Website_Link');?>
<i class="icon-twitter"></i>
                  </div>
                  <div
                    data-clipboard-text="<?php if (DEMO_STATUS == 'yes') {
echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/replica/<?php echo $_smarty_tpl->tpl_vars['ADMIN_USER_NAME']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;
} else {
echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/replica/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;
}?>"
                    id="copy_link_replica" class=" b-info b-l-4x btn btn-addon btn-default btn-sm has-tooltip"><i
                      class="fa fa-copy text-info"></i><?php echo lang('copy_link');?>
</div>
                </div>
              </div>
            </div>
          </div>
          <?php }?>
          <?php if ($_smarty_tpl->tpl_vars['MODULE_STATUS']->value['lead_capture_status'] == "yes") {?>
          <div class="col-xs-12" id="section_tile6">
            <div class="panel item">
              <div class="panel-body">
                <div class="pull-right icon_margin_top">
                  <button title="<?php echo lang('share_link');?>
" onClick="twittershare('<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/lcp/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
');"
                    class="btn btn-lg btn-icon btn-link text-info"><i class="fa fa-twitter"></i></button>
                  
                  <button title="<?php echo lang('share_link');?>
"
                    onClick="facebookShare('https://www.facebook.com/sharer/sharer.php?u=<?php echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/lcp/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;?>
');"
                    class="btn btn-lg btn-icon btn-link text-fb"><i class="fa fa-facebook"></i></button>
                </div>
                <div class="clear pull-left">
                  <div class="text-left block m-b-xs"><?php echo lang('Your_Lead_Capture_Page');?>
<i class="icon-twitter"></i>
                  </div>
                  <div
                    data-clipboard-text="<?php if (DEMO_STATUS == 'yes') {
echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/lcp/<?php echo $_smarty_tpl->tpl_vars['ADMIN_USER_NAME']->value;?>
/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;
} else {
echo $_smarty_tpl->tpl_vars['site_url']->value;?>
/lcp/<?php echo $_smarty_tpl->tpl_vars['LOG_USER_NAME']->value;
}?>"
                    id="copy_link_lcp" class="  b-info b-l-4x btn btn-addon btn-default btn-sm has-tooltip"><i
                      class="fa fa-copy text-info"></i><?php echo lang('copy_link');?>
</div>
                </div>
              </div>
            </div>
          </div>
          <?php }?>
          <?php }?>
        </div>
      </div>
      <div class="col-lg-6 col-md-12">
        <div class="panel wrapper" id="section_country_graph">
          <h4 class="font-thin m-t-none m-b text-muted hidden"></h4>
          <div id="country_graph"></div>
        </div>
      </div>
    </div>
    <div class="panel hbox hbox-auto-xs no-border">
      <div class="col wrapper">
        <div class="dropdown pull-right">
          <div data-toggle="dropdown" aria-expanded="false"><i class="fas fa fa-cog fa-spin"></i></div>
          <ul class="dropdown-menu dropdown-menu_right" id="joinings_graph">
            <li class=""><a id="yearly_joining_graph" href="javascript:void(0);"><i
                  class="fa fa-calendar margin-r-5"></i> <?php echo lang('year');?>
</a></li>
            <li class="active"><a id="monthly_joining_graph" href="javascript:void(0);"><i
                  class="fa fa-calendar margin-r-5"></i> <?php echo lang('month');?>
</a></li>
            <li><a id="daily_joining_graph" href="javascript:void(0);"><i class="fa fa-calendar margin-r-5"></i>
                <?php echo lang('day');?>
</a></li>
          </ul>
        </div>
        <h4 class="font-thin m-t-none m-b-none text-primary-lt"><?php echo lang('joinings');?>
</h4>
        <span class="m-b block text-sm text-muted"></span>
        <div id="joining_graph_div" style="height: 240px;"></div>
      </div>
      <?php if (count($_smarty_tpl->tpl_vars['prgrsbar_data']->value) > 0 && $_smarty_tpl->tpl_vars['MODULE_STATUS']->value['product_status'] == 'yes') {?>
      <div class="col wrapper-lg w-lg bg-light dk r-r">
        <h4 class="font-thin m-t-none m-b"><?php echo lang('membership');?>
</h4>
        <?php $_smarty_tpl->_assignInScope('j', 0);
?>
        <div class=""> <?php $_smarty_tpl->_assignInScope('text_class', array('text-primary','text-primary','text-primary','text-primary'));
?>
          <?php $_smarty_tpl->_assignInScope('bg_class', array('bg-primary','bg-primary','bg-primary','bg-primary'));
?>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['prgrsbar_data']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
          <div class=""> <span class="pull-right <?php echo $_smarty_tpl->tpl_vars['text_class']->value[$_smarty_tpl->tpl_vars['j']->value];?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value['joining_count'];?>
</span>
            <span><?php echo $_smarty_tpl->tpl_vars['v']->value['package_name'];?>
</span> </div>
          <div class="progress progress-xs m-t-sm bg-white">
            <div class="progress-bar <?php echo $_smarty_tpl->tpl_vars['bg_class']->value[$_smarty_tpl->tpl_vars['j']->value];?>
" data-toggle="tooltip"
              data-original-title="<?php echo $_smarty_tpl->tpl_vars['prgrsbar_data']->value[0]['perc']*$_smarty_tpl->tpl_vars['v']->value['joining_count'];?>
%"
              style="width: <?php echo $_smarty_tpl->tpl_vars['prgrsbar_data']->value[0]['perc']*$_smarty_tpl->tpl_vars['v']->value['joining_count'];?>
%"></div>
          </div>
          <?php $_smarty_tpl->_assignInScope('j', $_smarty_tpl->tpl_vars['j']->value+1);
?>
          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

        </div>
        <?php if ($_smarty_tpl->tpl_vars['j']->value > 3) {?>
        <div class="pull-right read_more_button-top"> <a href="<?php echo $_smarty_tpl->tpl_vars['BASE_URL']->value;?>
user/home/package_list"
            class="read_more bg-primary"><?php echo lang('view_more');?>
</a> </div>
        <?php }?>
      </div>
      <?php }?>
    </div>
    <div class="panel wrapper">
      <div class="row">
        <div class="col-md-6 b-r b-light no-border-xs"> <a
            href="javascript:loadModal(1, '<?php echo lang('to_do_list');?>
', 'user/home/add_todo');" data-toggle="modal"
            class="text-muted pull-right text-lg" title="<?php echo lang('add_task');?>
"><i class="icon-plus"></i></a>
          <h4 class="font-thin m-t-none m-b-md text-muted"><?php echo lang('to_do_list');?>
</h4>
          <div class=" m-b todo_list_height"> <?php $_smarty_tpl->_assignInScope('i', 0);
?>
            <?php $_smarty_tpl->_assignInScope('todo_pending', 0);
?>
            <?php $_smarty_tpl->_assignInScope('todo_done', 0);
?>
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['todo_list']->value, 'v');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['v']->value) {
?>
            <?php if ($_smarty_tpl->tpl_vars['v']->value['status'] == 'completed') {?>
            <?php $_smarty_tpl->_assignInScope('todo_done', $_smarty_tpl->tpl_vars['todo_done']->value+1);
?>
            <?php } else { ?>
            <?php $_smarty_tpl->_assignInScope('todo_pending', $_smarty_tpl->tpl_vars['todo_pending']->value+1);
?>
            <?php }?>
            <?php echo form_open('user/home/delete_todo','role="form" class="" method="post" name="todo_register"
            id="todo_form"');?>

            <input type='hidden' name="tsk_id" id="tsk_id" value="<?php echo $_smarty_tpl->tpl_vars['v']->value['task_id'];?>
">
            <div class="m-b">
              <div class="pull-right m-l"> <span class="label text-base bg-light pos-rlt m-r"> <i
                    class="arrow right arrow-light"></i> <?php echo $_smarty_tpl->tpl_vars['v']->value['time'];?>
 </span>
                <button type="submit" class="btn-link h4 text-danger" onClick="return deleteTask();"
                  title=<?php echo lang('delete');?>
><i class="fa fa-trash-o"></i></button>
                <button type="button" class="btn-link h4 text-info"
                  onClick="loadModal(<?php echo $_smarty_tpl->tpl_vars['v']->value['task_id'];?>
, '<?php echo lang('to_do_list');?>
', 'user/home/edit_todo');"
                  title="<?php echo lang('edit_list');?>
"><i class="fa fa-edit"></i></button>
              </div>
              <div class="clear"> <a href="javascript:void(0);" class=" block m-b-sm">
                  <div class="checkbox">
                    <label class="i-checks">
                      <input type="checkbox" onClick="statusChange(<?php echo $_smarty_tpl->tpl_vars['v']->value['task_id'];?>
, $(this));" <?php if ($_smarty_tpl->tpl_vars['v']->value['status'] == 'completed') {?>
                        checked <?php }?>> <i></i><?php echo smarty_modifier_truncate($_smarty_tpl->tpl_vars['v']->value['task'],15);?>
 </label>
                  </div>
                  <i class="icon-twitter"></i>
                </a> </div>
            </div>
            <?php echo form_close();?>

            <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value++);
?>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

            <?php if (count($_smarty_tpl->tpl_vars['todo_list']->value) <= 0) {?> <div><?php echo lang('no_data_found');?>

          </div>
          <?php }?>
        </div>
      </div>
      <?php $_smarty_tpl->_assignInScope('todo_done_percent', 0);
?>
      <?php $_smarty_tpl->_assignInScope('todo_pending_percent', 0);
?>
      <?php if (count($_smarty_tpl->tpl_vars['todo_list']->value) > 0) {?>
      <?php $_smarty_tpl->_assignInScope('todo_done_percent', ($_smarty_tpl->tpl_vars['todo_done']->value/count($_smarty_tpl->tpl_vars['todo_list']->value))*100);
?>
      <?php $_smarty_tpl->_assignInScope('todo_pending_percent', ($_smarty_tpl->tpl_vars['todo_pending']->value/count($_smarty_tpl->tpl_vars['todo_list']->value))*100);
?>
      <?php }?>
      <input type="hidden" id="todo_done_percent" value="<?php echo $_smarty_tpl->tpl_vars['todo_done_percent']->value;?>
">
      <input type="hidden" id="todo_pending_percent" value="<?php echo $_smarty_tpl->tpl_vars['todo_pending_percent']->value;?>
">
      <div class="col-md-6">
        <div class="row row-sm">
          <div class="col-xs-6 text-center">
            <div id="todo_done" class="inline m-t">
              <div><span class="text-primary h4"><?php echo round($_smarty_tpl->tpl_vars['todo_done_percent']->value);?>
%</span></div>
            </div>
            <div class="text-muted font-bold text-xs m-t m-b"><?php echo lang('done');?>
</div>
          </div>
          <div class="col-xs-6 text-center">
            <div id="todo_pending" class="inline m-t">
              <div> <span class="text-info h4"><?php echo round($_smarty_tpl->tpl_vars['todo_pending_percent']->value);?>
%</span> </div>
            </div>
            <div class="text-muted font-bold text-xs m-t m-b"><?php echo lang('pending');?>
</div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="panel no-border" id="section_top_earners">
        <div class="panel-heading wrapper b-b b-light">
          <h4 class="font-thin m-t-none m-b-none text-muted"><?php echo lang('top_earners');?>
</h4>
        </div>
        <ul class="list-group list-group-lg m-b-none">
          <?php $_smarty_tpl->_assignInScope('i', 0);
?>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['top_earners']->value, 'j');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['j']->value) {
?>
          <li class="list-group-item"> <a href="javascript:void(0);" class="thumb-sm m-r"> <img
                src="<?php echo $_smarty_tpl->tpl_vars['j']->value['profile_picture_full'];?>
" class="r r-2x"> </a> <span
              class="pull-right text-muted inline m-t-sm"><?php echo $_smarty_tpl->tpl_vars['j']->value['balance_amount'];?>
</span> <a
              href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['j']->value['user_name'];?>
</a> </li>
          <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

          <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>
          <li class="list-group-item"><?php echo lang('no_data_found');?>
</li>
          <?php }?>
        </ul>
      </div>
    </div>
    <div class="col-md-6">
      <div class="list-group list-group-lg list-group-sp" id="section_social_media"> <a <?php if ($_smarty_tpl->tpl_vars['is_app']->value) {?>
          href="<?php echo $_smarty_tpl->tpl_vars['social_media_info']->value['fb_link'];?>
" target="_blank" <?php } else { ?> href="#" target="" <?php }?>
          class="list-group-item clearfix"> <span class="pull-left m-r">
            <button class="btn btn-rounded btn-lg btn-icon btn-facebook"> <i class="fa fa-facebook"></i> </button>
          </span> <span class="clear"> <span><?php echo lang('facebook_users');?>
</span> <span
              class="social_iocs pull-center hidden-xs"><?php echo lang('facebook');?>
</span> <small
              class="text-muted clear text-ellipsis"><?php echo $_smarty_tpl->tpl_vars['social_media_info']->value['fb_count'];?>
 +</small> </span> </a>  <a
          <?php if ($_smarty_tpl->tpl_vars['is_app']->value) {?> href="<?php echo $_smarty_tpl->tpl_vars['social_media_info']->value['twitter_link'];?>
" target="_blank" <?php } else { ?> href="#" target="" <?php }?>
          class="list-group-item clearfix"> <span class="pull-left m-r">
            <button class="btn btn-rounded btn-lg btn-icon btn-info"> <i class="fa fa-twitter"></i> </button>
          </span> <span class="clear"> <span><?php echo lang('twitter_users');?>
</span> <span
              class="social_iocs pull-center hidden-xs"><?php echo lang('twitter');?>
</span> <small
              class="text-muted clear text-ellipsis"><?php echo $_smarty_tpl->tpl_vars['social_media_info']->value['twitter_count'];?>
 +</small> </span> </a> <a <?php if ($_smarty_tpl->tpl_vars['is_app']->value) {?> href="<?php echo $_smarty_tpl->tpl_vars['social_media_info']->value['inst_link'];?>
" target="_blank" <?php } else { ?> href="#" target="" <?php }?>
          class="list-group-item clearfix"> <span class="pull-left m-r">
            <button class="btn btn-rounded btn-lg btn-icon btn-instagarm"> <i class="fa fa-instagram"></i> </button>
          </span> <span class="clear"> <span><?php echo lang('instagram_users');?>
</span> <span
              class="social_iocs pull-center hidden-xs"><?php echo lang('instagram');?>
</span> <small
              class="text-muted clear text-ellipsis"><?php echo $_smarty_tpl->tpl_vars['social_media_info']->value['inst_count'];?>
 +</small> </span> </a> </div>
    </div>
  </div>
</div>
<br>
<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" id="reservation_detail_model"
  data-backdrop="static" class="modal fade" style="display: none;">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button">x</button>
        <h4 class="modal-title" id="modaltitle"></h4>
      </div>
      <div class="modal-body" id="reservation_detail_model_body"> </div>
    </div>
  </div>
</div>
<?php
}
}
/* {/block $_smarty_tpl->tpl_vars['CONTENT_BLOCK']->value} */
/* {block 'right_content'} */
class Block_3092016075f6dafb8698237_73474697 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="col w-md  bg-auto no-border-xs" id="right_section">
  <div class="b-l bg-white  tab-content" id="right_section_new_member">
    <div role="tabpanel" class="tab-pane active" id="tab-1">
      <div class="wrapper-md">
        <div class="bg-primary text-center wrapper-sm m-l-n-new m-r-n"><?php echo smarty_modifier_capitalize(lang('new_members'));?>
</div>
        <ul class="list-group no-bg no-borders pull-in list_link">
          <?php $_smarty_tpl->_assignInScope('i', 0);
?>
          <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['latest_joinees']->value, 'j');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['j']->value) {
?>
          <li class="list-group-item"> <a href="javascript:void(0);" class="pull-left thumb-sm m-r"> <img
                src="<?php echo $_smarty_tpl->tpl_vars['j']->value['profile_picture_full'];?>
"> </a>
            <div class="clear">
              <div><a href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['j']->value['user_name'];?>
</a></div>
              <span class="text-muted"><?php echo $_smarty_tpl->tpl_vars['j']->value['date_of_joining'];?>
</span>
            </div>
          </li>
          <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
          <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

          <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>
          <li class="list-group-item"><?php echo lang('no_data_found');?>
</li>
          <?php }?>
        </ul>
      </div>
    </div>
  </div>
  <div class="b-l bg-white padder-md height_top_recruiters" id="right_section_top_recruiter">
    <div class="streamline b-l m-b">
      <div class="bg-primary wrapper-sm m-l-n m-r-n m-b text-center"><?php echo lang('top_recruiters');?>
</div>
      <?php $_smarty_tpl->_assignInScope('i', 0);
?>
      <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['top_recruters']->value, 'j');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['j']->value) {
?>
      <?php $_smarty_tpl->_assignInScope('i', $_smarty_tpl->tpl_vars['i']->value+1);
?>
      <?php $_smarty_tpl->_assignInScope('k', fmod($_smarty_tpl->tpl_vars['i']->value,4));
?>
      <div class="sl-item b-l <?php if ($_smarty_tpl->tpl_vars['k']->value == 1) {?>b-primary<?php } elseif ($_smarty_tpl->tpl_vars['k']->value == 2) {?>b-warning<?php } elseif ($_smarty_tpl->tpl_vars['k']->value == 3) {?>b-info<?php }?>">
        <div class="m-l margin-list-mobile">
          <li class="list-group-item"> <a href="javascript:void(0);" class="pull-left thumb-sm m-r"> <img
                src="<?php echo $_smarty_tpl->tpl_vars['j']->value['profile_picture_full'];?>
"> </a>
            <div class="clear">
              <div><a href="javascript:void(0);">Hello <?php echo $_smarty_tpl->tpl_vars['j']->value['user_name'];?>
</a></div>
              <span class="text-muted"><?php echo $_smarty_tpl->tpl_vars['j']->value['count'];?>
</span>
            </div>
          </li>
        </div>
      </div>
      <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

      <?php if ($_smarty_tpl->tpl_vars['i']->value == 0) {?>
      <div class="sl-item b-l b-primary">
        <div class="m-l  margin-list-mobile">
          <li class="list-group-item"><?php echo lang('no_data_found');?>
</li>
        </div>
      </div>
      <?php }?>
    </div>
  </div>
</div>

<?php $_smarty_tpl->_subTemplateRender("file:user/home/rank_popup.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, true);
?>


<style>
  .demo_section {

    display: none;
  }

  .setting_margin_top {

    margin-top: -50px;
  }

  .setting_margin {
    margin-left: 230px;
  }

  .wrapper_index {

    padding: 15px
  }

  .demo_margin_top {

    margin-top: -30px;
  }

  .demo_footer_user {
    margin-top: -50px;
  }

  < !--opoup-->.demo_margin_top {

    margin-top: -30px;
  }

  .modal-content_1 {
    background-color: #fff;

  }

  .pager {

    margin: 0px 0;
    box-shadow: 0px 2px 17px 0px #19191942;
  }

  .modal-content_1 {
    position: relative;

    -webkit-background-clip: padding-box;
    background-clip: padding-box;
    border: 1px solid #999;
    border: 1px solid rgba(255, 255, 255, 0.58);
    outline: 0;
    -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, .5);
    box-shadow: 0 3px 9px rgba(0, 0, 0, .5);
  }

  .modal-dialog.modal-md.index {
    width: 35%;
    top: 7%;
    margin: 0 auto;
    position: relative;
    right: 0;
  }

  div#subscribeModal {
    padding-right: 0px !important;
  }


  .modal {
    position: fixed;
    left: 50%;
  }


  @media (max-width:767px) {
    .demo_section {

      display: block;
    }

    .moblie_demo {

      display: none;

    }

    .setting_margin {
      margin-left: 0px;
    }

    .setting_margin_top {
      margin-top: -49px !important;
    }

    .demo_margin_top {
      margin-top: -27px !important;
    }

    .modal-content_1 {
      background-color: #fff !important;

    }
  }
</style>
<?php
}
}
/* {/block 'right_content'} */
/* {block 'home_wrapper_out'} */
class Block_13492758095f6dafb8699430_97569650 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<div class="demo_footer_user"> <?php $_smarty_tpl->_subTemplateRender("file:layout/demo_footer.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
 </div>
<?php
}
}
/* {/block 'home_wrapper_out'} */
}
