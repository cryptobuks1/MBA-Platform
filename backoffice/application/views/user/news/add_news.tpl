{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl" name=""}
<innerdashes>
    <div id="span_js_messages" style="display:none;">
        <span id="error_msg1">{$tran_you_must_enter_news_title}</span>
        <span id="error_msg2">{$tran_you_must_enter_news}</span>
        <span id="confirm_msg1">{$tran_sure_you_want_to_edit_this_news_there_is_no_undo}</span>
        <span id="confirm_msg2">{$tran_sure_you_want_to_delete_this_news_there_is_no_undo}</span>
    </div>
    <hdash>
        <img src="{$PUBLIC_URL}images/1335698592_edit.png" border="0" />
        {$tran_add_news_and_events}
        {if $HELP_STATUS}
            <a href="https://infinitemlmsoftware.com/help/news-management" target="_blank"><buttons><img src="{$PUBLIC_URL}images/1359639504_help.png" /></buttons></a>    
                {/if}
    </hdash>
    <style>
 
             @media only screen and (min-width: 768px) and (max-width: 1024px) {
 .main-content > .container {
	height: -webkit-fill-available;
}
    .spacer-xs {
    
    height: -webkit-fill-available !important;
}
}
</style>
    <cdash-inner>
        {form_open('', 'class="niceform" method="post"  name="upload_news" id="upload_news"  onSubmit="return validate_newsupload(this);"')}
            <div id="inputs">
                <table width="100%" border="0"  >
                    <tr height="30" class="text">
                        <td WIDTH="150"><strong>{$tran_news_title}</strong></td><td>
                            <input tabindex="1" name="news_title" id="news_title" type="text" size="30" value="{$news_title}"/>

                        </td>
                    </tr>
                    <tr height="30" class="text">
                        <td><strong>{$tran_news_description}<font color="#ff0000">*</font></strong></td>
                        <td><textarea class="textfixed" rows="4" name="news_desc" id="news_desc" cols="22" tabindex="2" >{$news_desc}</textarea></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            {if $edit_id==""}
                                <input tabindex="3" name="news_submit" type="submit" value="{$tran_submit}">
                            {else}
                                <input tabindex="3" name="news_update" type="submit" value="{$tran_update}" style="background-color:#84A031; border-color:#84A031; font-weight:bold;">
                                <input name="news_id" id="news_id" type="hidden"  value="{$news_id}"/>
                            {/if}
                        </td>
                    </tr>
                </table>
            </div>
        {form_close()}
    </cdash-inner>
</innerdashes>                
<innerdashes>                
    <cdash-inner>
        <table id = "grid">
            <thead>
                <tr class="th">
                    <th>{$tran_no}</th>
                    <th>{$tran_news_title}</th>
                    <th>{$tran_date}</th>
                    <th>{$tran_action}</th>
                </tr>
            </thead>
            <tbody>
                {if $arr_count!=0}
                    {assign var="class" value=""}
                    {assign var="path" value="{$BASE_URL}user/"}
                    {assign var="i" value=0}
                    {foreach from=$news_details item=v}
                        {assign var="news_id" value="{$v.news_id}"}

                        {if $i%2==0}
                            {$class='tr1'}
                        {else}
                            {$class='tr2'}
                        {/if}
                        {$i=$i+1}
                        <tr class="{$class}">
                            <td>{$i}</td>
                            <td>{$v.news_title}</td>
                            <td>{$v.news_date}</td>
                            <td><a href="javascript:edit_news({$news_id},'{$path}')"><img src="{$PUBLIC_URL}images/edit.png" title="{$tran_edit} {$v.news_title}" style="border:none;"></a> / <a href="javascript:delete_news({$news_id},'{$path}')"><img src="{$PUBLIC_URL}images/delete.png" title="{$tran_delete} {$v.news_title}" style="border:none;"></a></td>
                        </tr>                    
                    {/foreach}
                </tbody>
                <counter></counter>
                {else}
                <tr><td colspan="6" align="center"><h4>{$tran_no_news_found}</h4></td></tr>
                        {/if}
        </table>
    </cdash-inner>
</innerdashes>

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}