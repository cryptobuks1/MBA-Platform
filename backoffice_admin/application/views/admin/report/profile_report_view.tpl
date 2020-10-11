{extends file=$BASE_TEMPLATE} {block name=$CONTENT_BLOCK} {assign var="report_name" value="{lang('profile_report')}"} {assign var="excel_url" value="{$BASE_URL}admin/excel/create_excel_profile_view_report"} {assign var="csv_url" value="{$BASE_URL}admin/excel/create_csv_profile_view_report"}
{include file="admin/report/report_nav.tpl" name=""}
<div id="print_area" class="img panel-body panel">
<div class="">

 
    {include file="admin/report/header.tpl" name=""}
    <div class="panel panel-default  ng-scope">
    <div class="table-responsive">
        <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
            <tbody>
            {foreach from=$details item=v}
                <tr class="text">
                    <td><strong>{lang('full_name')}</strong></td>
                    <td>{$v.user_detail_name} {$v.user_detail_second_name}</td>
                </tr>
                <tr>
                    <td><strong>{lang('user_name')}</strong></td>
                    <td>{$user_name}</td>
                </tr>
                <tr>
                    <td><strong>{lang('sponser_name')}</strong></td>
                    <td>{if $user_name ==$v.user_name}{lang('NA')}{else}{$v.user_name}{/if}</td>
                </tr>
                <tr>
                    <td><strong>{lang('address')}</strong></td>
                    <td>{$v.user_detail_address}</td>
                </tr>
                <tr>
                    <td><strong>{lang('pincode')}</strong></td>
                    <td>{$v.user_detail_pin}</td>
                </tr>
                <tr>
                    <td><strong>{lang('country')}</strong></td>
                    <td>{$v.user_detail_country}</td>
                </tr>
                <tr>
                    <td><strong>{lang('state')}</strong></td>
                    <td>{$v.user_detail_state}</td>
                </tr>
                <tr>
                    <td><strong>{lang('mobile_no')}</strong></td>
                    <td>{$v.user_detail_mobile}</td>
                </tr>
                <tr>
                    <td><strong>{lang('land_line_no')}</strong></td>
                    <td>{$v.user_detail_land}</td>
                </tr>
                <tr>
                    <td><strong>{lang('email')}</strong></td>
                    <td>{$v.user_detail_email}</td>
                </tr>
                <tr>
                    <td><strong>{lang('date_of_birth')}</strong></td>
                    <td>{$v.user_detail_dob}</td>
                </tr>
                <tr>
                    <td><strong>{lang('gender')}</strong></td>
                    <td>{if $v.user_detail_gender=='M'}
                                    {lang('male')}
                                {else}
                                    {lang('female')}
                                {/if}</td>
                </tr>
                {/foreach}
            </tbody>
        </table>
        </div>
    </div>
</div>
 </div>
{/block}