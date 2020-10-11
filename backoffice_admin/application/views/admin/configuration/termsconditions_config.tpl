
        <div class="content">
            {form_open_multipart('admin/configuration/content_management','role="form" class="" name= "terms_config" id= "terms_config"')}
                {if $LANG_STATUS=='yes'}
                    {include file="layout/error_box.tpl"} 
                    <div class="form-group">
                        <label class="control-label" for="lang_selector">
                            {lang('Select_a_Language')} 
                        </label>
                            <select  class="form-control"  name="lang_selector" id='lang_selector' onchange="set_language_id(this.value, 'terms');">
                                {foreach from=$lang_arr item=v}
                                    {if $lang_id==$v.lang_id}
                                        <option value="{$v.lang_id}" selected="">{$v.lang_name}</option>
                                    {else}
                                        <option value="{$v.lang_id}">{$v.lang_name}</option>
                                    {/if}
                                {/foreach}
                            </select>{form_error('lang_selector')}
                            <input type="hidden" name="lang_id" id="lang_id" value="{$lang_id}"/>
                            <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}"/>
                    </div>      
                {/if}

                {if $LANG_STATUS=='no'}
                    <input type="hidden" name="lang_id" id="lang_id" value="1"/>
                {/if}
                
                <div class="form-group">
                    <label class="control-label required" for="txtDefaultHtmlArea1">
                        {lang('terms_and_conditions')}
                    </label>
                        <textarea id="txtDefaultHtmlArea1"  name="txtDefaultHtmlArea1" class="ckeditor form-control">
                            {$terms}
                        </textarea>
                        {form_error('txtDefaultHtmlArea1')}
                </div>
                    
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" name="content_submit" id="content_submit" type="submit" value="{lang('update')}" > {lang('update')}</button>
                </div>
            {form_close()}
        </div>