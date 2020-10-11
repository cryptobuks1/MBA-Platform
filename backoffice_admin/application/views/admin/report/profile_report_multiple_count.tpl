{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK} {assign var="report_name" value="{lang('profile_report')}"} {assign var="excel_url" value="{$BASE_URL}admin/excel/user_profiles_excel"} {assign var="csv_url" value="{$BASE_URL}admin/excel/user_profiles_csv"}
{include file="admin/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
{include file="admin/report/header.tpl" name=""}
  <div class="panel panel-default  ng-scope">
  <div class="table-responsive">
    <table st-table="rowCollectionBasic" class="table table-bordered table-striped">{if count($profile_arr)!=0}

      <thead>
        <tr class="th">
            <th>{lang('sl_no')}</th>
            <th>{lang('full_name')}</th>
            <th>{lang('user_name')}</th>
            <th>{lang('sponser_name')}</th>
            <th>{lang('address')}</th>
            <th>{lang('pincode')}</th>
            <th>{lang('mobile_no')}</th>
            <th>{lang('email')}</th>
            <th>{lang('bank')}</th>
            <th>{lang('branch')}</th>
            <th>{lang('account_number')}</th>
            <th>{lang('pan_no')}</th>
            <th>{lang('ifsc')}</th>
            <th>{lang('date_of_joining')}</th>
        </tr>
      </thead>
      <tbody>
      {foreach  from= $profile_arr item=v}
        {assign var="tr_class" value=""}
        {assign var="i" value="0"}
      {assign var="name" value="{$v.user_detail_name}"}
        {assign var="address" value="{$v.user_detail_address}"}
        {assign var="pincode" value="{$v.user_detail_pin}"}
        {assign var="mobile" value="{$v.user_detail_mobile}"}
        {assign var="land" value="{$v.user_detail_land}"}
        {assign var="email" value="{$v.user_detail_email}"}
        {assign var="bank" value="{$v.user_detail_nbank}"}
        {assign var="branch" value="{$v.user_detail_nbranch}"}
        {assign var="acc" value="{$v.user_detail_acnumber}"}
        {assign var="pan" value="{$v.user_detail_pan}"}
        {assign var="ifsc" value="{$v.user_detail_ifsc}"}
        {assign var="date" value="{$v.join_date}"}
        {assign var="uname" value="{$v.uname}"}
        {assign var="sponser_name" value="{$v.sponser_name}"}
        {assign var="sponser_id" value="{$v.sponser_id}"}
        <tr>
            <td>{counter}</td>
            <td>{$name}</td>
            <td>{$uname}</td>
            <td>{$sponser_name}</td>
            <td>{$address}</td>
            <td>{$pincode}</td>
            <td>{$mobile}</td>
            <td>{$email}</td>
            <td>{$bank}</td>
            <td>{$branch}</td>
            <td>{$acc}</td>
            <td>{$pan}</td>
            <td>{$ifsc}</td>
            <td>{$date}</td>
        </tr>
        {/foreach}
        </tbody>
        {else}
        <h4 align="center">{lang('no_data')}</h4>
    {/if}
    </table>
  </div>
  </div>
</div>
{/block}