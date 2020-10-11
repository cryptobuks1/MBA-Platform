
<div style="height:5px; width:100%;float:left;"></div>
<table align="center">
    <tr>
        <td>
            {form_open('admin/select_report/admin_profile_report', 'class="niceform" name="profile_form" method="POST"')}
                <input  type="submit" value="{$tran_profile_report}" name="prof_report">
            {form_close()}
        </td>
        <td>
            {form_open('admin/select_report/total_joining_report', 'class="niceform" name="JoiningReport_form" method="POST"')}
                <input  type="submit" value="{$tran_joining_report}" name="join_report">
            {form_close()}
        </td>
        <td>
            {form_open('admin/select_report/total_payout_report', 'class="niceform" name="TotalPayoutReport_form" method="POST"')}
                <input  type="submit" value="{$tran_total_payout_report}" name="tot_pay_report">
            {form_close()}
        </td>
        <td>
            {form_open('admin/select_report/bank_statement_report', 'class="niceform" name="BankStatementReport" method="POST"')}
                <input  type="submit" value="{$tran_bank_statement}" name="ban_stat_report">
            {form_close()}
        </td>
        <td>
            {form_open('admin/select_report/payout_release_report', 'class="niceform" name="TotalPayoutReleaseReport_form" method="POST"')}
                <input type="submit" value="{$tran_payout_release_report}" name="tot_pay_report">
            {form_close()}
        </td>
    </tr>
</table>