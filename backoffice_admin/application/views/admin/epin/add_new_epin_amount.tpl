{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl" name=""}
<div id="span_js_messages" style="display:none;">
    <span id="row_msg">{$LANG['rows']}</span>
    <span id="show_msg">{$LANG['shows']}</span>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>
                {$LANG['add_new_epin_amount']}
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                {form_open('', 'method="post" id="epin_amount" name="epin_amount"')}
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="pin_amount">{$LANG['epin_amount']}:</label>
                        <div class="col-sm-3">
                            <input tabindex="11" type="text" name ="pin_amount"  id ="reg_amount" value="" title="" required="true" data-rule-number="true" ><span class="val-error">{form_error('pin_amount')}</span>
                            <span id="errmsg3"></span>
                        </div>
                    </div>
                    <div class="form-group">

                        <button class="btn btn-blue"  type="submit" value="add_amount" tabindex="12" name="add_amount" id="add_amount"  >{$LANG['add']}</button>

                        {* <button class="btn btn-bricky"  type="submit" value="delete_amount" tabindex="12" name="delete_amount" id="delete_amount"  >{$delete}</button>*}
                    </div>

                </form>
                {if $pin_amounts!=""}

                    <table class="table table-striped table-hover table-full-width table-bordered" id="sample_1">
                        <thead class="table-bordered">
                            <tr class="th">
                                <th>{$LANG['no']}</th>

                                <th>{$LANG['amount']}</th>

                                <th width="40%">action</th>
                            </tr>
                        </thead>
                        <tbody>                       
                            {assign var="i" value=0}
                            {assign var="pin" value=""}
                            {assign var="tr_class" value=""}
                            {assign var="root" value="{$BASE_URL}admin/"}
                            {foreach from=$pin_amounts item=v}                        

                                {if $i%2 == 0}
                                    {$tr_class="tr1"}	 
                                {else}
                                    {$tr_class="tr2"}
                                {/if}
                                {$i=$i+1}
                                <tr class="{$tr_class}">
                                    <td>{counter}</td>
                                    <td>{$v.amount}</td>
                                    <td>
                                        {form_open('', 'method="post"')}
                                            <input type="hidden" value='{$v.id}' id="pin_id" name="pin_id">
                                            <button class="btn btn-bricky"  type="submit" value="delete_amount" tabindex="12" name="delete_amount" id="delete_amount"  >{$LANG['delete']}</button>
                                        {form_close()}
                                    </td></tr>

                            {/foreach}   
                        </tbody>
                    </table>
                {else}
                    <div align="center">{$LANG['there_is_no_epint']}</div>
                {/if}



            </div>
        </div>
    </div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{*{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}*}