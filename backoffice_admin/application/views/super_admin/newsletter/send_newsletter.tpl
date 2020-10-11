{include file="super_admin/layout/header.tpl" name=""}
<div id="span_js_messages" style="display: none;">
    <span id="error_msg1">{lang('you_must_enter_username')}</span>
    <span id="error_msg2">{lang('you_must_enter_subject')}</span>
    <span id="error_msg3">{lang('you_must_enter_message')}</span>
</div>
<div class="row">

    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>{lang('send_news_letter')} 
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-close" href="#">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                {*                <form role="form" class="smart-wizard form-horizontal"  id="send_newsletter" name="send_newsletter" method="post" action="">*}
                {form_open('', 'name="send_newsletter" id="send_newsletter" class="smart-wizard form-horizontal" method="post"')}
                <div class="col-md-12">
                    <div class="errorHandler alert alert-danger no-display">
                        <i class="fa fa-times-sign"></i> {lang('errors_check')}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="status_all">{lang('Send_Mail_To')}<span class="symbol required"></span></label>
                    <div class="col-sm-3">
                        <input tabindex="1" type="radio" id="status_all" name="mail_status" value="all" onclick="view_user_newsletter(this.value)"  checked='1' />
                        <label for="status_all"></label>all{lang('all_subscribers')}
                    </div>
                    <div class="col-sm-3">
                        <input tabindex="1" type="radio" name="mail_status" id="status_mul" value="single"   onclick="view_user_newsletter(this.value)"/>
                        <label for="status_mul"></label>single{lang('single_subscribers')}
                    </div>
                </div>
                <div class="form-group" id="user_div"  style="display:none;" >                  
                    <div class="form-group">
                        <label class="col-sm-2 control-label" for="user_name" style="width: 211px;">{lang('select_mlm_user')}:<span class="symbol required"></span></label>
                        <div class="col-sm-4">
                            <input  type="text"  name="user_name" id="user_name"   autocomplete="Off"  onkeyup="ajax_showOptions(this, 'getUsersByLetters', 'no', event)"  tabindex="1" >{form_error('user_name')}
                            <span id="username_box" style="display:none;"></span>
                        </div>

                    </div>                                                 
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="subject">{lang('subject')}<span class="symbol required"></span> </label>
                    <div class="col-sm-3">
                        <input tabindex="2" name="subject" type="text" id="subject" size="35"   /> {form_error('subject')}
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="message">{lang('newsletter_to_subscribers')}<span class="symbol required"></span></label>                       
                    <div class="col-sm-9">
                        <textarea rows="12"  name="message" id="message" cols="22" tabindex="2" class="ckeditor form-control"></textarea>{form_error('message')}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2 col-sm-offset-2">
                        <button class="btn btn-bricky" type="submit" name="send_newsleteer"  id="send_newsleteer" value="{lang('send_message')}" tabindex="4">{lang('send_newsletter')}</button>
                    </div>
                </div>
                <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                {form_close()}
            </div>
        </div>
    </div>
</div>
{include file="super_admin/layout/footer.tpl" title="Example Smarty Page" name=""}

{include file="super_admin/layout/page_footer.tpl" title="Example Smarty Page" name=""} 
