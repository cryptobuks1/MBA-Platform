{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display:none;">
        <span id="u_err">{lang('must_select_username')}</span>
        <span id="type_err">{lang('must_select_type')}</span>
        <span id="status_err">{lang('something_wrong')}</span>
    </div>
    <div class="modal" style="margin-top: 100px" id="reason_modal" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" >
                        &times;
                    </button>
                    <h4 class="modal-title">{lang('kyc_status')}</h4>
                </div>
                <div class="modal-body">
                    <table cellpadding="0" cellspacing="0" align="center">
                        <tr>
                            <td>
                                <textarea name="reason" id='reason'></textarea>
                            </td>
                        </tr>
                        <tr></tr>
                        <tr></tr>
                    </table>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open('','role="form" class="" method="post"  name="searchkyc" id="searchkyc"')}
            <div class="col-sm-3 padding_both ">
                <div class="form-group text-center-width">
                    <label>{lang('select_category')}</label>
                    <select class="form-control" name="type" id='type'>
                        <option value=''>{lang('select')}</option>
                        {foreach from=$kyc_catg item=v}
                            <option value="{$v.id}">{$v.category}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group text-center-width">
                    <label>{lang('status')}</label>
                    <select class="form-control" name="status" id='status'>
                        <option value=''>{lang('select')}</option>
                        <option value='Pending'>{lang('Pending')}</option>
                        <option value="Rejected">{lang('Rejected')}</option>
                        <option value="Approved">{lang('Approved')}</option>
                    </select>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label>{lang('select_user_name')}</label>
                    <input name="user_name" class="form-control user_autolist" id="user_name" type="text" autocomplete="off">
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group mark_paid">
                    <button class="btn btn-sm btn-primary" type="submit" id="view_kyc" name="view_kyc" value="{lang('view')}"> {lang('view')}</button>
                </div>
            </div>
            {form_close()}
            <div class="col-sm-12 padding_both_small">
                <p> <u><a href="{$BASE_URL}admin/kyc_settings" class="text-info">{lang('manage_kyc_configuration')}?</a> </u></p>
            </div>
        </div>
    </div>
    {if $show_table eq 'yes' || count($kyc_list) > 0}
        <div class="panel panel-default wrapper">
        <div classs="panel-body">
            {form_open('','role="form" class=""   name="from_to_form" id="from_to_form" method="post" target="_blank"')}
            {if count($kyc_list) > 0}
            <div class="table-responsive">
                <table st-table="rowCollectionBasic" class="table table-bordered table-striped">
                    <thead>
                        <tr class="th">
                            <th>{lang('#')}</th>
                            <th>{lang('user_name')}</th>
                            <th>{lang('Name')}</th>
                            <th>{lang('category')}</th>
                            <th>{lang('status')}</th>
                            <th>{lang('view')}</th>
                            <th>{lang('action')}</th>
                        </tr>
                    </thead>
                    <tbody>
                        {assign var="i" value=1}
                        {foreach from = $kyc_list key = k item = v}
                            <tr id="row_id{$i}">
                                <td>{$i}</td>
                                <td>{$v['user_name']}</td>
                                <td>{$v['full_name']}</td>
                                <td>{$v['category']}</td>
                                <td><span class="label label-{$v['font_class']}"> {lang($v['status'])}</span>
                                </td>
                                <td>
                                    {foreach from=$v['file_name'] item=f}
                                        {if $f|pathinfo:$smarty.const.PATHINFO_EXTENSION == 'pdf'}
                                            <a href="{$SITE_URL}/uploads/images/document/kyc/{$f}" class="btn btn-info" data-placement="top" data-original-title="" title="{lang('download')}" target="_blank">
                                                <i class="fa fa-download" data-toggle="tooltip" title="Download"></i></a>
                                            {else}
                                            <a class="btn btn-primary thumbs" href="javascript:mym('{$SITE_URL}/uploads/images/document/kyc/{$f}')"> <img id="borderimg1" width="30" height="20" src="{$SITE_URL}/uploads/images/document/kyc/{$f}" scrolling="no"></a>
                                            {/if}
                                        {/foreach}

                                </td>
                                <td>
                                    {if $v['status'] eq 'pending'}
                                        <input style="color: #00CC00" type="button" id="verify_button{$i}" name='verify_button{$i}' onclick="verify('{$v["user_name"]}',{$v['type']}, this, 'row_id{$i}')" value="Approve" class="btn btn-primary"/>
                                        <input type="button" style="color: #CC0000" id="reject_button{$i}" name='reject_button{$i}' onclick="reject('{$v["user_name"]}',{$v['type']}, this, 'row_id{$i}')" value="Reject" class="btn btn-primary"/>
                                    {else if $v['status'] eq 'rejected'}
                                        <button class="btn-link text-info" type="button" style="margin-top: 0px !important;" id="reject_button{$i}" name='reject_button{$i}' onclick="veiwreason('{$v['reason']}')" value="Reason" title="{lang('view_reason')}"> <i class="fa fa-eye"></i></button>
                                        {else}
                                            {lang('na')}
                                        {/if}
                                </td>
                            </tr>
                            {$i = $i + 1}
                        {/foreach}
                    </tbody>
                </table>
                </div>
                </div>
            {else}
                <h4 class="text-center">{lang('no_details')}</h4>
            {/if}
            {form_close()}
        </div>
        <div class="m-b pink-gradient">
            <div class="card-body ">
                <div class="media">
                    <figure class="avatar-50"><i class="glyphicon glyphicon-book"></i></figure>
                    <div class="media-body">
                        <h6 class="my-0">{lang('you_can_manage_kyc_category_from_above_link')}</h6>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="EnSureModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                                        <div class="modal-header"  style="height: 46px;">
                        <button type="button" class="bootbox-close-button close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body" style="text-align:center;width:100%">
                        <img id="im" src="">
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade" id="EnSureModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="bootbox-close-button close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title">{lang('enter_reason')}</h4>
                    </div>
                    <div class="modal-body" style="text-align:center;width:100%">

                        <form class="bootbox-form">
                            <input class="bootbox-input bootbox-input-text form-control" autocomplete="off" type="text">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button data-bb-handler="confirm" type="button" class="btn btn-primary">OK</button>
                    </div>
                </div>
            </div>
        </div>
    {/if}
{/block}
{block name="script"}
    <script>
        jQuery(document).ready(function () {
        {*        Main.init();*}
            //DatePicker.init();
        {*        ValidateKYC.init();*}
        });

        function mym(image) {
            document.getElementById("im").src = image;
            $("#EnSureModal").modal();
        }

        function verify(uname, type, button, rowid) {
            $.post('{$BASE_URL}admin/profile/ajaxVerify', {literal}{
                user_name: uname,
                type: type
            },{/literal}
                    function (data) { //alert(data);
                        if (data === 'no') { //if username not avaiable
                            alert('{lang('something_wrong')}');
                        } else {
                            bootbox.alert('{lang('approved')}');
                            $('#' + rowid).remove();
                            button.disabled = true;
                            button.value = '{lang('approved')}';
                        }
                    });
        }

        function reject(uname, type, button, rowid) {
            bootbox.prompt('{lang('enter_reason')}', function (reason) {
                if (reason != "" && reason != null) {
                    $("#reason_filed").html('');
                    $.post('{$BASE_URL}admin/profile/ajaxReject', {literal}{
                        user_name: uname,
                        type: type,
                        reason: reason
                    },{/literal}
                            function (data) { //alert(data);
                                if (data === 'no') { //if username not avaiable
                                    alert('{lang('something_wrong')}');
                                } else {
                                    bootbox.alert('{lang('rejected')}');
                                    $('#' + rowid).remove();
                                    button.disabled = true;
                                    button.value = '{lang('rejected')}';
                                }
                            });
                } else {
                    if ($('#reason_filed').length == 0) {
                        $(".bootbox-input").after('<span id="reason_filed">{lang('required')}</span>');
                    } else {
                        $("#reason_filed").html('{lang('required')}');
                    }
                    return false;
                }
            });
        }

        function veiwreason(msg) {
            bootbox.alert("{lang('reason')} : " + msg);
        }

        $(".btn-dis").click(function () {
            $(this).button('loading');
        });
    </script>
    <style>
    .modal-footer {
    padding-bottom: 10px;
    padding-top: 10px;
    padding-right: 10px;
     }
    .modal-footer .btn-default {
     display:none;
     margin-left: 10px;
     }
</style>
{/block}
