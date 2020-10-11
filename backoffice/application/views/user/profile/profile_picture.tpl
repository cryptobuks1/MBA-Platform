{include file="user/layout/themes/{$USER_THEME_FOLDER}/header.tpl"  name=""}
<innerdashes>
    <hdash>    
        <img src="{$PUBLIC_URL}images/1335604253_hire-me.png"/>		
        {$u_name}'{$tran_s_profile_pic}
        {if $HELP_STATUS}
            <a href="https://infinitemlmsoftware.com/help/profile_management" target="_blank"><buttons><img src="{$PUBLIC_URL}images/1359639504_help.png"  /></buttons></a>  
                {/if}
    </hdash>
    <cdash-inner>                        			
        <table width="80%" >
            <tr>
                <td><img src="{$PUBLIC_URL}images/profile_picture/{$file_name}" alt="" align="absmiddle" height="116px" width="116px"/></td>
                <td>
                    <table cellpadding="0" cellspacing="0" cellpadding="0">
                        <tr>
                            <td>
                                {form_open_multipart('', 'name="change_profile_picture_form" id="change_profile_picture_form" method="post"')}
                                    <table cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td><input tabindex="2" type="file" id="userfile" name="userfile"></td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <input type="submit" name="change_picture" id="change_picture" value="{$tran_change_profile_pic}" />							
                                            </td>
                                        </tr>
                                    </table>
                                {form_close()}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </cdash-inner>
</innerdashes>                                                                                                                                       

{include file="user/layout/themes/{$USER_THEME_FOLDER}/footer.tpl" title="Example Smarty Page" name=""}

{include file="user/layout/themes/{$USER_THEME_FOLDER}/page_footer.tpl" title="Example Smarty Page" name=""}