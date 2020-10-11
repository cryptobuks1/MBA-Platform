<style>

    .tab-content{    
        margin-bottom: 5px;
        padding-bottom: 0;
    }
    .post{
        padding-bottom: 0px;
    }  
    .modal-content {
        border-radius: 5px;
    }
</style>
<div class="panel-body">
    <input type="hidden" id="inbox_form" name="inbox_form" value="{$BASE_URL}" />
    {if $news_count>0}         
        <section class="content">
            <div class="row">
                {foreach from=$news_details item=v}
                    {$id = $v.news_id} 
                    <div class="col-md-4">
                        <div class="tab-content news-bore">
                            <div class="post" style="border-bottom: none;">
                                <div class="user-block">
                                    <span class="username">
                                        <a href="#" style="word-wrap: break-word;">{$v.news_title}</a>
                                        <a href ="#panel-config{$id}" onclick="readMessage({$id}, this.parentNode.parentNode.rowIndex, 'user', '{$BASE_URL}user')" class="pull-right tooltips margin-r-5" data-placement="top" data-original-title="Expand" data-toggle="modal" ><i class="fa fa-expand" style="color: #4d8189;margin-top: 22px;"></i></a>
                                    </span>
                                    <span class="description"><i class="fa fa-calendar-plus-o margin-r-5" style=" color: 
                                    #16aad8;"></i> {$v.news_date|date_format:"%D"}</span>
                                </div>
                            </div>  
                        </div>
                    </div>
                {/foreach}  
            </div>
        </section>


    {else}                   
        <h4 align="center">{lang('You_have_no_news_in_inbox')}</h4>
        {/if}
        {$result_per_page}
</div>

