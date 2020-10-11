



        <div class="content">
            {form_open('','role="form" class="" name="reg_mail_settings" id="reg_mail_settings"')}
                {include file="layout/error_box.tpl"} 
                   
                  {form_open_multipart('admin/configuration/content_management','role="form" class="" name= "terms_form"  id="terms_form"')}                                             
               
                    <div class="panel-body">
                    {include file="layout/error_box.tpl"} 
                        <div class="form-group">
                            <label class="control-label" for="txtDefaultHtmlArea">{lang('main_matter')}</label>
                                <textarea class="ckeditor form-control"  id="content_terms"  name="content_terms" title="{lang('main_matter')}"  rows="6">{if isset($content['upgrade_terms_cond'])}{$content['upgrade_terms_cond']}{else}
                                All subscribers of Infinite MLM services agree to be bound by the terms of this service. The Infinite MLM software is an entire solution for all type of business plan like Binary, Matrix, Unilevel and many other compensation plans. This is developed by a leading MLM software development company Infinite Open Source Solutions LLP. More over these we are keen to construct MLM software as per the business plan suggested by the clients.This MLM software is featured of with integrated with SMS, E-Wallet,Replicating Website,E-Pin,E-Commerce, Shopping Cart,Web Design and more{/if}</textarea>
                                {form_error('content_terms')}
                        </div>

                        <div class="form-group">
                            <button class="btn btn-sm btn-primary"  name="submit_upgrade_term" id="submit_upgrade_term" type="submit" value="{lang('update')}" > {lang('update')}</button>
                        </div>
                    </div>   
              
            
                    
            {form_close()}
        </div>    