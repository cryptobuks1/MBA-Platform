<div class="panel panel-default">
    <div class="panel-heading">
        <i class="fa fa-external-link-square"></i>{lang('mail_compose_to_downlines')}
    </div>

    <div class="panel-body"> 
            {form_open('user/mail/mail_to_downlines','role="form" class=""  method="post"  name="send_news" id="send_news"')}
            <div class="col-md-12">
                <div class="errorHandler alert alert-danger no-display">
                    <i class="fa fa-times-sign"></i> {$tran_errors_check}.
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="subject">{lang('subject')}<font color="#ff0000">*</font> </label>
                <div class="col-sm-3">
                    <input tabindex="1" name="subject" type="text" id="subject" size="35"   /><span class='validation_error'>{form_error('subject')}</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label" for="user_name">{lang('type')} <span class="symbol required"></span></label>
                <div class="col-sm-3">
                    <input type="radio" name="user" id="all_user" checked="" value="all" tabindex="1" onclick="document.getElementById('select_user_div').style.display = 'none';"/>
                    <label for="upgrade_type" >{lang('my_team')}</label>
                    <input type="radio" name="user" id="individual" value="individual"  tabindex="2" onclick="document.getElementById('select_user_div').style.display = '';"/>  
                    <label for="upgrade_type" >{lang('individual')}</label>
                </div>
            </div>
            <div class="form-group" id="select_user_div" style="display: none;">
                <label class="col-sm-2 control-label" for="subject">{lang('select_a_team_member')}</label>
                <div class="col-sm-3">
                    <select name="username" id="username"  tabindex="12" class="form-control" >
                        <option selected="selected" value="" >{lang('select_one')}</option>
                        {foreach from = $user_downlines  item=levels}
                            {foreach from = $levels  item=users}
                                <option value="{$users.user_id}">{$users.user_name}</option>
                            {/foreach}
                        {/foreach}
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-2 control-label" for="content">{lang('content')}<font color="#ff0000">*</font> </label>
                <div class="col-sm-9">
                    <textarea rows="12"  name="content" id="content" cols="22" tabindex="2" class="ckeditor form-control"></textarea><span class='validation_error'>{form_error('content')}</span>
                </div>
            </div>

            <div class="form-group">

                <div class="col-sm-2 col-sm-offset-2">

                    <button class="btn btn-bricky"tabindex="3" name="mail_submit" type="submit" value="Send Email"> {lang('sent_mail')}</button>
                </div>
                <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">

            </div>
                {form_close()}
    </div>
</div>
