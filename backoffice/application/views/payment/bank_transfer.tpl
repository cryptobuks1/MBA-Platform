
<div class="bhoechie-tab-content bank {if $active_tab_val=='bank_transfer'}active{/if}">
    <div class="content">
        <div class="form-group">
            <label class="no_bg_clr required"> {lang('select_reciept')} </label>
            <input class="m-b-xs padding_center" id="userfile" name="userfile" accept="image/*" type="file">  
            <p style="color: #ff0000;">({lang('Allowed_types_are_pg_jpeg_png')})</p>       
            <img class="m-i-xs" id="img_prev" src="#" alt=""/>
            <a href="#" class="btn btn-light-grey btn-file fileupload-exists" data-dismiss="fileupload" id="remove_id" style="display:none;">
                <i class="fa fa-times"></i> {lang('remove')}
            </a>
        </div>
        <div class="form-group">
            <button type="button" class="btn btn-addon m-b-xs btn-info update_profile_image" id="upload_reciept"> <i class="fa fa-arrow-circle-o-up"></i> {lang('upload')} </button>
        </div>
    </div>
</div>