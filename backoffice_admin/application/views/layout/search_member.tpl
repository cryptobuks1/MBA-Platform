<div class="panel panel-default">
    <div class="panel-body">
        {form_open({$SHORT_URL},'role="form" class="" name="search_member" id="search_member"
        action="" method="post"')}
        <input type="hidden" id="search_member_error" value="{lang('search_member_error')}" />
        <input type="hidden" id="search_member_error2" value="{lang('invalid_user_name')}" />
        {* {include file="layout/error_box.tpl"} *}

        <div class="col-sm-3 padding_both">
            <div class="form-group">
                <label class="required" for="user_name">{lang('user_name')}</label>
                <input class="form-control user_autolist" type="text" id="user_name" name="user_name" autocomplete="Off">
            </div>
        </div>
        <div class="col-sm-3 padding_both_small">
            <div class="form-group mark_paid">
                <button class="btn btn-sm btn-primary" type="submit" id="search_member_submit" value="search_member_submit"
                    name="search_member_submit">
                    {lang('search')}
                </button>
            </div>
        </div>
        {form_close()}
    </div>
</div>