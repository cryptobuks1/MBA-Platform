{extends file=$BASE_TEMPLATE}
{block name="script"} {$smarty.block.parent}
    <script src="{$PUBLIC_URL}javascript/validate_edit_profile.js"></script>
{/block}
{block name=$CONTENT_BLOCK}
    <div class="panel panel-default">
        <div class="panel-body">
            {form_open_multipart('user/profile/update_profileimg_banner','role="form" class="" name= "edit_profile"  id="edit_profile"')}
            <div class="col-sm-3 padding_both">
                <div class="form-group">
                    <label class="control-label  pro-label">{lang('upload_banner')}</label>
                    <div data-provides="fileupload" class="bg_file_upload pro_file_upload">
                        <input name="file2" id="file2" type="file">
                        <label id="fileLabel1">{lang('select_file')}</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group">
                    <label class="control-label  pro-label">{lang('upload_profile_photo')}</label>
                    <div data-provides="fileupload" class="bg_file_upload pro_file_upload">
                        <input name="file1" id="file1" type="file">
                        <label id="fileLabel2">{lang('select_file')}</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 padding_both_small">
                <div class="form-group mark_paid">
                    <button type="submit" class="btn btn-sm btn-primary">{lang('update_profile')}</button>
                </div>
            </div>
            {form_close()}
        </div>
    </div>
{/block}