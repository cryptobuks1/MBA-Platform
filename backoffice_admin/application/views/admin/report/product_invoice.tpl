	{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}
	{assign var="report_name" value="{lang('invoice_details')}"}

	{$total=0}
	<input type="hidden" name="{$CSRF_TOKEN_NAME}" value="{$CSRF_TOKEN_VALUE}" />
	<div class="row">
		<div class="col-sm-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-external-link-square"></i> Invoice Report
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
				<div  id="print_area" class="panel-body" style="overflow: auto; max-height:1000px;">
					{include file="admin/report/header.tpl" name=""}
					{if $count >=1}
					<br><br><table border='2' cellpadding='5px' cellspacing='0' align='center' width="100%" >
					<tr class='th'>

						<tr class="th" align="center">
							<th>{lang('slno')}</th>
							<th>{lang('invoice_no')}</th>
							<th>{lang('product_name')}</th>
							<th>{lang('quantity')}</th>
							<th>{lang('amount')}</th>
						</tr>

					</tr>
					{assign var="i" value=0}
					{assign var="total_quantity" value=0}
					{assign var="total_amount" value=0}

					{foreach from=$invoice_details item=v}
					{if $i%2==0}
					{assign var="class" value="tr1"}
					{else}
					{assign var="class" value="tr2"}
					{/if}
					{$i=$i+1}
					<tr{$class}>
					<td>{counter}</td>
					<td>{$v.invoice_no}</td>
					<td>{$v.product_name}</td>
					<td>{$v.quantity}</td>
					<td style="text-align: center;">{$DEFAULT_SYMBOL_LEFT} {$v.amount} {$DEFAULT_SYMBOL_RIGHT}</td>
					{$total_amount = $total_amount + $v.amount}
				</tr>
				{/foreach}
				<tr> 
					<td colspan="4" style="text-align: center;"> <b>{lang('total_amount')}</b></td>
					<td style="text-align: center;"><b>{$DEFAULT_SYMBOL_LEFT} {$total_amount} {$DEFAULT_SYMBOL_RIGHT}</b></td>
				</tr>
			</table>
			<br>
			<br>
			{else}
			<h4 align='center'>  <font size="6">{lang('no_data')}</font ></h4>
			{/if}

			{include file="admin/report/footer.tpl" name=""}
		</div>

		{if $count >= 1}
		<div class="row"  >
                    <div id = "frame" style="margin-left: 350px;">
                        <a href="" onClick="print_report();
                            return false;"><img src="{$PUBLIC_URL}images/1335779082_document-print.png" alt="Print" height="20" width="20" border="none" align="center" >{lang('Print')}</a>

                        <i class="fa fa-file-excel-o" style="margin-left: 140px;"></i><a href={$BASE_URL}admin/excel/create_excel_product_sales_report>{lang('create_excel')}</a>
                    </div>
		</div>
		{/if}
	</div>
</div>
</div>

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
