<div class="box">
    <table><tr>
<td>
    {form_open('user/epin/generate_epin', 'class="niceform" name="GeneratePasscod" method="POST"')}
    <input  type="submit" value="{$tran_add_epin}" name="GeneratePasscod">
    {form_close()}
</td>
<td>
    {form_open('user/epin/delete_epin', 'class="niceform" name="DeletePasscod" method="POST"')}
    <input  type="submit" value="{$tran_delete_epin}" name="DeletePasscod">
    {form_close()}
</td>

<td>
    {form_open('user/epin/search_epin', 'class="niceform" name="SearchPasscod" method="POST"')}
    <input  type="submit" value="{$tran_search_epin}" name="SearchPasscod">
    {form_close()}
</td>

<td>
    {form_open('user/epin/inactive_epin', 'class="niceform" name="InactivePasscod" method="POST"')}
    <input  type="submit" value="{$tran_inactive_epin}" name="InactivePasscod">
    {form_close()}
</td>

<td>
    {form_open('user/epin/active_epin', 'class="niceform" name="ActivePasscod" method="POST"')}
    <input  type="submit" value="{$tran_active_epin}" name="ActivePasscod">
    {form_close()}
</td>


</tr></table>
</div>
<style>
 
             @media only screen and (min-width: 768px) and (max-width: 1024px) {
 .main-content > .container {
	height: -webkit-fill-available;
}
    .spacer-xs {
    
    height: -webkit-fill-available !important;
}
}
</style>