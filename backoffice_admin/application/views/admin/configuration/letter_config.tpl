
        <div class="content">
            {form_open_multipart('admin/configuration/content_management','role="form" class="" name= "letter_config"  id="letter_config"')}
                {if $LANG_STATUS=='yes'}
                    {include file="layout/error_box.tpl"}
    
                    <div class="form-group">
                        <label class="control-label" for="lang_selector">{lang('Select_a_Language')}</label>
                            <select  class="form-control"  name="lang_selector" id='lang_selector' onchange="set_language_id(this.value, 'letter');" >
                                {foreach from=$lang_arr item=v}
                                    {if $lang_id==$v.lang_id}
                                        <option value="{$v.lang_id}" selected="">{$v.lang_name}</option>
                                    {else}
                                        <option value="{$v.lang_id}">{$v.lang_name}</option>
                                    {/if}
                                {/foreach}
                            </select>
                            <input type="hidden" name="lang_id" id="lang_id" value="{$lang_id}"/>
                            <input type="hidden" name="base_url" id="base_url" value="{$BASE_URL}"/>
                    </div>
                {/if}

                {if $LANG_STATUS=='no'}
                    <input type="hidden" name="lang_id" id="lang_id" value="1"/>
                {/if}

                <div class="form-group">
                    <label class="control-label" for="txtDefaultHtmlArea">{lang('main_matter')}</label>
                        <textarea class="ckeditor form-control"  id="txtDefaultHtmlArea"  name="txtDefaultHtmlArea" title="{lang('main_matter')}" >
                            {$letter_arr["main_matter"]}
                        </textarea>
                        {form_error('txtDefaultHtmlArea')}
                </div>
                    
                <div class="form-group">
                    <button class="btn btn-sm btn-primary" name="setting" id="setting" type="submit" value="{lang('update')}" > {lang('update')}</button>
                </div>
            {form_close()}
        </div>