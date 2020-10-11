{include file="super_admin/layout/header.tpl" name=""}

<div id="span_js_messages" style="display: none;"> 
    <span id="row_msg">{lang('rows')}</span>
    <span id="show_msg">{lang('shows')}</span>
</div>

{if $status}

   <div class="main-login col-sm-6 col-sm-offset-6" >

    <div class="logo">
        <img src="{$SITE_URL}/uploads/images/logos/logo.png" align ="left" style="margin-left: -176px;"/>
    </div>
   
    <div style="margin-bottom: 61px; margin-top: 113px; width: 400px; margin-left: -242px;">

                       
                            <h3>
                                <b>
                                {lang('you_have_been_unsubscribed')}</b> 
                            </h3>
            
    </div>
    <div class="" style=" text-align: center; float: none; margin-top: 10px; ">
        {date('Y')} &copy; {$COMPANY_NAME}
    </div>
</div>

{else}
      <div class="main-login col-sm-6 col-sm-offset-6" >

    <div class="logo">
        <img src="{$PUBLIC_URL}images/logos/logo.png" align ="left" style="margin-left: -176px;"/>
    </div>
   
    <div style="margin-bottom: 61px; margin-top: 113px; width: 400px; margin-left: -242px;">

                       
                            <h3>
                                <b>   {lang('user_already_unsubscribed')}</b> 
                            </h3>
            
    </div>
    <div class="" style=" text-align: center; float: none; margin-top: 10px; ">
        {date('Y')} &copy; {$COMPANY_NAME}
    </div>
</div>  

{/if}


{include file="super_admin/layout/footer.tpl" title="Example Smarty Page" name=""}

{include file="super_admin/layout/page_footer.tpl" title="Example Smarty Page" name=""}  