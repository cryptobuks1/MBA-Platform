<div id="span_js_messages" style="display:none;">
    <span id="confirm_msg">{lang('Sure_you_want_to_Delete_There_is_NO_undo')}</span>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-external-link-square"></i>{lang('mail_sent_to_downlines')}
    </div>
    <div class="panel-body">
    
        
        <div id="span_js_messages" style="display:none;">
        </div>

        <table class="table table-striped table-hover table-full-width" id="">
            <thead>
                <tr class="th">            
                    <th>{lang('from')}</th>
                    <th>{lang('subject')}</th>
                    <th>{lang('date')}</th>
                    <th>{lang('action')}</th>
                </tr>
            </thead>
            <tbody>
                {assign var=i value=1}
                {assign var=clr value=""}
                {assign var=id value=""}
                {assign var=msg_id value=""}
                {assign var=user_name value=""}
                {if $cnt_row_inbox > 0}
                    {foreach from=$row_inbox item=v}
                        {$id = $v.mailadid}                        
                        <tr>
                            <td>  {$user_name = $user_name_arr_inbox[$i-1]['user_name']}                             
                                <a class="btn btn-xs btn-link panel-configFrom" href ="#panel-configFrom{$id}"  style='color:#C48189;' data-toggle="modal"> {$user_name}</a>
                            </td>
                            <td>
                                <a class="btn btn-xs btn-link panel-configFrom" href ="#panel-configFrom{$id}"  style='color:#C48189;' data-toggle="modal"> {$v.mailadsubject}</a>
                            </td>
                            <td>
                                <a class="btn btn-xs btn-link panel-configFrom" href ="#panel-configFrom{$id}"  style='color:#C48189' data-toggle="modal"> {$v.mailadiddate}</a
                            </td> 
                       
                           <td>                                                                        
							<div class="visible-md visible-lg hidden-sm hidden-xs">
								<a href="#" onclick="deleteFromMessage({$id}, this.parentNode.parentNode.rowIndex, 'user', '{$BASE_URL}user')" class="btn btn-bricky tooltips" data-placement="top" data-original-title="Delete"><i class="fa fa-times fa fa-white"></i></a>
							</div>
							<div class="visible-xs visible-sm hidden-md hidden-lg">
								<div class="btn-group">
									<a class="dropsmalldown btn btn-bricky dropdown-toggle btn-sm" data-toggle="dropdown" href="#">
										<i class="fa fa-cog"></i> <span class="caret"></span>
									</a>
									<ul role="menu" class="dropdown-menu pull-right">
										<li role="presentation">
											<a role="menuitem" tabindex="-1" href="#" onclick="deleteFromMessage({$msg_id}, this.parentNode.parentNode.rowIndex, 'user', '{$BASE_URL}user')">
												<i class="fa fa-times"></i>  {lang('remove')}
											</a>
										</li>
									</ul>
								</div>
							</div>
						</td> 
                        
                        </tr>
                        {$i=$i+1}	
                    {/foreach}
                {else}
                <tbody><tr><td align="center" colspan="4"><b>{lang('you_have_no_sent_emails_to_downlines')}</b></td></tr></tbody>
                            {/if}
            </tbody>
        </table>
        {$result_per_page}
    </div>
</div>
