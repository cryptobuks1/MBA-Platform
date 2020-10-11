{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}
    <div id="span_js_messages" style="display: none;"> 
        <span id="row_msg">{lang('rows')}</span>
        <span id="show_msg">{lang('shows')}</span>
        <span id="validate_msg1">{lang('you_must_enter_banner_name')}</span>
        <span id="validate_msg2">{lang('please_enter_valid_url')}</span>
    </div>

    <div class="button_back">                          
        <a href="{BASE_URL}/admin/member/invite_banner_config" class="btn m-b-xs btn-sm btn-info btn-addon"><i class="fa fa-backward"></i>{lang('back')}</a>
    </div>  
    
        <div class="panel panel-default">
            <div class="tab">
                <div class="content">
                {form_open_multipart('','role="form" class="smart-wizard" method="post" name="banner_form" id="product_form"')}
                <div id="pdf">
                            <div class="form-group"> 
                                <label class="control-label required">{lang('banner_name')}</label>
                                    <input class="form-control" name="banner_name" id="banner_name" value="" autocomplete="Off"  type="text">
                                    {form_error('banner_name')}
                            </div>
                            
                            <div class="form-group"> 
                                <label class="control-label">{lang('target_url')}</label>
                                    <input class="form-control" name="target_url" id="target_url" value="" autocomplete="Off"  type="text">
                                    {form_error('target_url')}
                            </div>
                            
                            <div class="form-group">
                                <div class="" style="margin-top: 10px !important;">
                                <div data-provides="fileupload" class="bg_file_upload" style="overflow: hidden;">
                                    <span class="btn btn-light-grey"></i> <span class="fileupload-new"></span>
                                        <input name="banner_image" id="banner_image" type="file"  >
                                    </span>
                                </div>
                                <p class="help-block">
                                   {lang('please_choose_a_png_file.')}<span class="symbol required"></span> <br>{lang('max_size_20MB')}
                                </p>
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-sm btn-primary"  name="banner" type="submit" value="submit">{lang('add_item')}</button>
                            </div>
                </div>

                {form_close()}
            </div>
        </div>
    </div>

 {/block}
 
 {block name=script}
  {$smarty.block.parent}
    <script src="{$PUBLIC_URL}/javascript/validate_invite_banner.js"></script>
 {/block}