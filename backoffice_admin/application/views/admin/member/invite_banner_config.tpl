{extends file=$BASE_TEMPLATE}

{block name=$CONTENT_BLOCK}

{* <div class="b wrapper m-b-sm panel">
    <p>{lang('note_invite_banner_config')}</p>
</div> *}
    
    <div style="display:none;" class="alert alert-info col-md-12" id="banner_inv">{lang('banner_invites_URL_copied')}</div>
        {form_open_multipart('admin/add_banner_invite','role="form" class="smart-wizard"  method="post" name="banner_form" id="product_form"')}
            <div class="form-group">
                <button class="btn btn-sm btn-primary btn-addon" name="" type="submit" value="submit"><i class="fa fa-plus"></i>{lang('add_banner_invite')}</button>
            </div>  
        {form_close()}
        
        {if count($banners)>0}
        {assign var="i" value="0"}
        {assign var="class" value=""}
        {foreach from=$banners item=v}   
            <div class="">
              <div class="panel">
                <div class="panel-body">
                  <article class="zm-post-lay-d clearfix">
                    <div class="zm-post-thumb f-left">
                        <img src="{$SITE_URL}/uploads/images/banners/{$v.content}" alt="Banner Image" class="img-ban">
                    </div>
                    <div class="zm-post-dis f-right">
                        <div class="zm-post-header">
                            <h2 class="zm-post-title"><a href="#">{$v.subject}</a></h2>
                            <div class="form-group">
                              <textarea class="form-control textarea_height_fix" placeholder="link" disabled="" id="banner{$v.id}">{if $v.target_url == null}<a href="{$REPLICATION_URL}/{$LOG_USER_NAME}">{else}<a href="{$v.target_url}">{/if}<img src="{$PUBLIC_URL}images/banners/{$v.content}" height="150" width="250"></a></textarea>
                            </div>
                            <div class="col-sm-6 col-xs-6 padding_both_small">
                                <div class="form-group">
                                    <button type="button" id="banner{$v.id}" class="btn btn-primary banner_inv">{lang('copy')}</button>
                                </div>
                            </div>
                            <div class="col-sm-6 text-right">
                                {form_open('admin/member/delete_banner','method="post"')}
                                    <input type='hidden' id='banner_id' name='banner_id' value='{$v.id}'>
                                    <button class="btn btn-danger" type='submit' id='delete' name='delete' value="delete"><i class="fa fa-trash-o "></i></button>
                                {form_close()}
                            </div>
                        </div>
                    </div>
                  </article>
                </div>
              </div>
            </div>
        {/foreach}
        {else}
           <div class="b wrapper m-b-sm panel">
                <h4 align="center">{lang('no_data')}</h4>
            </div>
        {/if}
        {$result_per_page}     
{/block}
 
 {block name=script}
  {$smarty.block.parent}
    <script src="{$PUBLIC_URL}/javascript/validate_invite_banner.js"></script>
 {/block}