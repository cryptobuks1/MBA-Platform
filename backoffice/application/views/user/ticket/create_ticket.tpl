<div id="span_js_messages" style="display:none;"> 
    <span id="error_msg1">{lang('subject_is_required')}</span>
    <span id="error_msg2">{lang('priority_is_required')}</span>
    <span id="error_msg3">{lang('category_is_required')}</span>
    <span id="error_msg4">{lang('message_is_required')}</span>    
    <span id="error_msg5">{lang('please_enter_ticket_id')}</span>    
</div>

{*<div class="row">
    <div class="col-sm-12">*}
        {*<div class="panel panel-default">
                <div class="panel-body">*}


                    {form_open_multipart('user/ticket_system', 'role="form" class="" name="create_ticket" id="create_ticket" enctype="multipart/form-data"')}
                    <input type="hidden" name="active_tab" id="active_tab" value="tab2" >
                   
                    <div class="form-group">
                        <label>{lang('subject')}</label>
                        <input type="text" name="subject" id="subject" class="form-control" tabindex="1" {if isset($create_ticket_arr['subject'])} value="{$create_ticket_arr['subject']}"{/if}/>
                        {if isset($validation_error['subject'])}<span class='val-error' >{$validation_error['subject']}</span>{/if}
                    </div>
                    <div class="form-group">
                        <label>{lang('priority')}</label>
                        <select name="priority" id="priority" type="text" class="form-control" tabindex="2"> 
                            <option value="" selected>{lang('select_priority')}</option>
                            {foreach from=$ticket_priority item=t}
                                <option value="{$t.id}" >{$t.priority}</option>
                            {/foreach}

                        </select>  
                        {if isset($validation_error['priority'])}<span class='val-error' >{$validation_error['priority']} </span>{/if}
                    </div>
                    <div class="form-group">
                        <label>{lang('category')}</label>
                        <select tabindex="3" name="category" type="text" id="category" class="form-control" >
                            <option value="">{lang('select_type')}</option>
                            {foreach from=$category_arr item=v}
                                {if isset($create_ticket_arr['category']) && $create_ticket_arr['category']!="" && $v.id == $create_ticket_arr['category']}
                                    <option value="{$v.id}" selected>{$v.category_name}</option>
                                {/if}   
                                <option value="{$v.id}">{$v.category_name}</option>
                            {/foreach}
                        </select>
                        {if isset($validation_error['category'])}<span class='val-error' >{$validation_error['category']} </span>{/if}
                    </div>
                    <div class="form-group">
                        <label>{lang('message_to_admin')}</label>
                        <textarea class="textfixed form-control" name="message" rows="" placeholder="" id="tran_concept" tabindex="5" style="height: 70px;"></textarea>
                        {if isset($create_ticket_arr['message'])}{$create_ticket_arr['message']}{/if}</textarea>
                        {if isset($validation_error['message'])}<span class='val-error' >{$validation_error['message']} </span>{/if}
                    </div>
                    <div class="form-group">
                        <label>{lang('attachment')}</label>
                        <div class="form-group">
                            <div data-provides="fileupload" class="fileupload fileupload-new">
                                <span class="btn btn-file btn-light-grey">
                                    <i class="fa fa-folder-open-o"></i> 
                                    <span class="fileupload-new">{lang('select_file')}</span>
                                    <span class="fileupload-exists">{lang('change')}</span>
                                    <input type="file" id="upload_doc" name="upload_doc" tabindex="5" >
                                </span>
                                <span class="fileupload-preview"></span>
                                <a style="float: none" data-dismiss="fileupload" class="close fileupload-exists" href="#">×</a>
                            </div>
                        </div>
                        <p>
                            <font color="#ff0000">{lang('kb')}({lang('allowed_types_are_gif_jpg_png_jpeg_jpg')})</font>
                        </p> 
                    </div>
                    <div class="form-group ticket">
                        <button class="btn btn-sm btn-primary" type="submit"id="usersend" value="submit" name="usersend" tabindex="6" >{lang('submit')}</button>
                    </div>
                    <input type="hidden" id="path_temp" name="path_temp" value="{$PUBLIC_URL}">
                    {form_close()}
                {*</div>
            </div>*}
        {*</div>
    </div> *}
