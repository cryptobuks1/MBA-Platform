{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/header.tpl"  name=""}

{include file="admin/configuration/system_setting_common.tpl"}
<style type="text/css">
 
    @media only screen and (max-width: 1024px) and (min-width: 768px){
.spacer-xs {
    height: -webkit-fill-available;
}
.main-content .container {
    
    height: -webkit-fill-available;
}
}
.radio-inline, .checkbox-inline {
    
    padding-left: 0;
}
</style>



<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <i class="fa fa-external-link-square"></i>  Theme Settings
                <div class="panel-tools">
                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                    </a>
                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                        <i class="fa fa-refresh"></i>
                    </a>
                    <a class="btn btn-xs btn-link panel-expand" href="#">
                        <i class="fa fa-resize-full"></i>
                    </a>
                </div>
            </div>
            <div class="panel-body">
                {form_open('','role="form" class="smart-wizard form-horizontal" name= "form_setting"  id="form_setting"')}

                <div class="form-group">
                <label class="col-sm-4" for="admin_def_theme">
                    <h5>{lang('admin_theme')}</h5>
                </label>
               </div>


                
                 <div class="form-group">
                <div class="col-sm-12">  
                    {$i=1}
                    {foreach from=$admin_themes item=v}
                        <div class="col-sm-3">
                            <div class="col-sm-12"> 
                            <label class="radio-inline">
                                <input type="radio" name="admin_def_theme" value="{$v.name}" {if $v.default} checked {/if} tabindex="0">
                                {if $v.name=='white'}
                                    TRUEWHITE
                                {else}
                                {strtoupper($v.name)}
                                {/if}
                            </label>
                            </div>  
                            <div class="col-sm-12">
                                    <img style="padding-top: 10px; max-width: 300px; width: 100%;" src='{$PUBLIC_URL}images/themes/{$v.icon}' id="admin_theme">
                            </div>  
                        </div>
                        {$i = $i+1}
                    {/foreach}
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4" for="user_def_theme">
                    <h5>{lang('user_theme')}</h5>
                </label>
            </div>
            <div class="form-group">
                <div class="col-sm-12">   
                    {foreach from=$user_themes item=v}
                        <div class="col-sm-3">
                            <div class="col-sm-12"> 
                            <label class="radio-inline">
                                <input type="radio" name="user_def_theme" value="{$v.name}" {if $v.default} checked {/if}  tabindex="0">
                                {if $v.name=='white'}
                                    TRUEWHITE
                                {else}
                                {strtoupper($v.name)}
                                {/if}
                                </label>
                            </div>  
                            <div class="col-sm-12">  
                                    <img style="padding-top: 10px; max-width: 300px; width: 100%;"  src='{$PUBLIC_URL}images/themes/{$v.icon}' id="user_theme">
                            </div>  
                        </div>
                        {$i = $i+1}
                    {/foreach}
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-12">
                    <button class="btn btn-bricky theme_setting"  type="submit" value="{lang('update')}" tabindex="0" name="setting" id="setting" title="{lang('update')}" onclick="setHiddenValue('tab4')" style="
                    margin-left: 2em;">{lang('update')}</button>
                </div>
            </div>
        {form_close()}
                     
                
                {form_close()}
            </div>
        </div>
    </div>
</div>



 

{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}
{include file="admin/layout/themes/{$ADMIN_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}
