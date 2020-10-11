{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}
<div id="span_js_messages" style="display:none;">
</div>
<div class="row">
    <div class="col-sm-12">
        {assign var=i value=1}
        {assign var=j value=1}
        {assign var=id value=""}
        {assign var=user_name value=""}
        {foreach from=$row_send item=v}
            {$id = $v.mailadid}
            {$user_name = $user_name_arr_send[$i-1]['user_name']}
            <div class="modal fade" id="panel-config{$id}"  tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title">{lang('mail_details')}</h4>
                        </div>
                        <div class="modal-body">
                            <table cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td>
                                        <b>{lang('subject')}</b> {$v.mailadsubject}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="th">

                                        <b>To:</b>  {if $v.type == 'team'}My Team{else}{$user_name}{/if}

                                    </td>
                                </tr>
                                <tr>
                                    <td width="80%"  style="padding-top: 10px;">
                                        <b>{lang('message')}:</b> <h6><p style="text-align: justify;line-height: 20px;"> {$v.mailadidmsg}</p></h6>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {$i = $i+1}
        {/foreach}
        {foreach from=$row_inbox item=v}
            {$id = $v.mailadid}
            {$user_name = $user_name_arr_inbox[$j-1]['user_name']}
            <div class="modal fade" id="panel-configFrom{$id}"  tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4 class="modal-title">{lang('mail_details')}</h4>
                        </div>
                        <div class="modal-body">
                            <table cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td>
                                        <b>{lang('subject')}</b> {$v.mailadsubject}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="th">

                                        <b>From:</b>  {$user_name}


                                    </td>
                                </tr>
                                <tr>
                                    <td width="80%"  style="padding-top: 10px;">
                                        <b>{lang('message')}:</b> <h6><p style="text-align: justify;line-height: 20px;"> {$v.mailadidmsg}</p></h6>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            {$j = $j+1}
        {/foreach}
        <div class="tabbable ">
            <ul id="myTab3" class="nav nav-tabs tab-green">
                <li class="{$tab1}">
                    <a href="#panel_tab4_example1" data-toggle="tab">
                        <i class="pink fa fa-dashboard"></i>{lang('compose_mail_user')}
                    </a>
                </li>
                <li class="{$tab2}">
                    <a href="#panel_tab4_example2" data-toggle="tab">
                        <i class="blue fa fa-user"></i>{lang('mail_sent_to_downlines')} 
                    </a>
                </li>
                <li class="{$tab3}">
                    <a href="#panel_tab4_example3" data-toggle="tab">
                        <i class="blue fa fa-user"></i>{lang('mail_from_downlines')}
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane{$tab1}" id="panel_tab4_example1">
                    <p>
                        {include file="user/mail/compose_mail_to_downlines.tpl"  name=""}
                    </p>
                </div>
                <div class="tab-pane{$tab2}" id="panel_tab4_example2">

                    <p>
                        {include file="user/mail/mail_send_to_downlines.tpl"  name=""}
                    </p>
                </div>
                <div class="tab-pane{$tab3}" id="panel_tab4_example3">

                    <p>
                        {include file="user/mail/mail_from_downlines.tpl"  name=""}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}